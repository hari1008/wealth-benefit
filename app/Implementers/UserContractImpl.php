<?php

/*
 * File: UserContractImpl.php
 */

namespace App\Implementers;

use App\Contracts\UserContract;
use App\Models\User;
use App\Models\ActivationCode;
use App\Codes\StatusCode;
use App\Implementers\BaseImplementer;
use App\Models\Device;
use App\Models\PasswordReset;
use App\Models\ExpertCalendar;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Helper\Utility\FileRepositoryLocal;
use App\Helper\Utility\FileRepositoryS3;
use App\Codes\Constant;
use App\Models\ExpertHealthCategories;
use DB;
use App\Models\GetHelp;
use App\Helper\Utility\UtilityHelper;
use App\Helper\Utility\CommonHelper;
use App\Models\UserBooking;
use App\Models\ExpertQualification;
use App\Models\SessionPrice;
use App\Models\MasterHealthCategories;
use App\Models\UserWellnessAnswer;

class UserContractImpl extends BaseImplementer implements UserContract {

    public function __construct() {
        $this->userModel = new User();
        if(env('STORAGE_TYPE') == 'S3'){
            $this->file = new FileRepositoryS3();
        }
        else{
            $this->file = new FileRepositoryLocal();
        }
    }

    /**
     * 
     * Does sign up of the users and sending a verification mail to their mail Id 
     * 
     * @param $data it contains all the value given for Sign Up
     * 
     * @throws Exception If something happens during the process
     * 
     * @return Inserted user object if everything went right
     * 
     */
    public function postSignUp($data) {
        DB::beginTransaction();
        try {
                $result = User::getUserByMail($data['email']);
                if (is_object($result)) {
                    return $this->renderFailure(trans('messages.email_already_registered'), Response::HTTP_BAD_REQUEST);
                }
                $activationCode = ActivationCode::checkCodeStatus($data['activationCode'])->first();
                if (!is_object($activationCode)) {
                    return $this->renderFailure(trans('messages.invalid_activation_code'), Response::HTTP_BAD_REQUEST);
                }
                if ($activationCode['mail'] != $data['email']) {
                    return $this->renderFailure(trans('messages.activation_code_not_mapped_with_email'), Response::HTTP_BAD_REQUEST);
                } 
                $data['ecosystemId'] = $activationCode['ecosystem_id'];
                $user = User::createUser($data);
                ActivationCode::updateUsedCode($data['activationCode']);
            
                $deviceModel = new Device();
                $user_token = $deviceModel->registerDevice($user->user_id, isset($data['deviceToken']) ? $data['deviceToken'] : '', $data['deviceType']);
                $user->userToken = $user_token;
                $email = $data['email'];
                Mail::send('email.verify_email', array('token' => $user->email_verify_token, 'email' => $data['email']), function($message) use($email) {
                    $message->to($email)->subject('Benefit Wellness - Verify Email');
                });
                DB::commit();
                return $this->renderSuccess(trans('messages.sugnup_and_mail_sent_successfully'), [$user]);
         }    
         catch (\Exception $e) {
            DB::rollBack();
            UtilityHelper::logExceptionWithObject(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * 
     * Does password change
     * 
     * @param $data which contains current and new password
     * 
     * @throws Exception If something happens during the process
     * 
     * @return success if successfully changed otherwise failure 
     * 
     */
    public function putChangePassword($data) {
        try {
            if (Auth::attempt(['password' => $data['currentPassword'], 'user_id' => Auth::user()->user_id])) {
                $userData = Auth::user();
                $updateRow = User::where('user_id', $userData->user_id)->update(array('password' => bcrypt($data['newPassword'])));
                return $this->renderSuccess(trans('messages.password_updated'));
            } else {
                return $this->renderFailure(trans('messages.incorrect_pass'), Response::HTTP_BAD_REQUEST);
            }
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * 
     * Does user sign out
     * 
     * @param Null
     * 
     * @throws Exception If something happens during the process
     * 
     * @return success if successfully done signout otherwise failure 
     * 
     */
    public function putSignOut() {
        try {
            Device::unRegisterSingle(Auth::user()->user_id);
            return $this->renderSuccess(trans('messages.sign_out_successfull'));
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * 
     * Does checking of activation code status
     * 
     * @param $data which contains the activation code
     * 
     * @throws Exception If something happens during the process
     * 
     * @return success if activation code is valid otherwise failure 
     * 
     */
    public function getCodeStatus($data) {
        try {
            $activationCode = ActivationCode::checkCodeStatus($data['activationCode'])->first();
            
            if (is_object($activationCode)) {
                if($activationCode['ecosystem']['expiry_date'] > date('Y-m-d')){
                    return $this->renderSuccess(trans('messages.valid_activation_code'));
                }
                else{
                    return $this->renderFailure(trans('messages.ecosystem_expired'), Response::HTTP_OK);
                }
            } else {
                return $this->renderFailure(trans('messages.invalid_activation_code'), Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * 
     * Does verification of account when user click on the email verification link   
     * 
     * @param $request which contains email and token
     * 
     * @throws Exception If something happens during the process
     * 
     * @return success if email and token is valid otherwise failure 
     * 
     */
    public function getCheckEmailVerification($request) {
        return $updateRow = User::where('email', $request['email'])->where('email_verify_token', $request['token'])->update(array('email_verify_token' => '', 'is_verified' => 1));
    }

    /**
     * 
     * Does sign in of user, also temporary block account if too many wrong attempts
     * 
     * @param $data which contains email , password & facebookId
     * 
     * @throws Exception If something happens during the process
     * 
     * @return user object if email and password is valid otherwise failure 
     * 
     */
    public function postSignIn($data) {

        try {
            if (!empty($data['facebookId'])) {

                $user = User::where('facebook_id', $data['facebookId'])->with('ecosystem.features')->first();
                if (is_object($user)) {
                    if ($user->is_verified == Constant::$NotVerified) {
                        return $this->renderFailure(trans('messages.account_is_not_verified'), Response::HTTP_FORBIDDEN);
                    } else {
                        $deviceModel = new Device();
                        $user_token = $deviceModel->registerDevice($user->user_id, isset($data['deviceToken']) ? $data['deviceToken'] : '', $data['deviceType']);
                        $user->userToken = $user_token;
                        return $this->renderSuccess(trans('messages.sign_in_successfully'), [$user]);
                    }
                } else {
                    $user = User::createUserByFacebookId($data);
                    $deviceModel = new Device();
                    $user_token = $deviceModel->registerDevice($user->user_id, isset($data['deviceToken']) ? $data['deviceToken'] : '', $data['deviceType']);
                    $user->userToken = $user_token;
                    return $this->renderSuccess(trans('messages.sign_in_successfully'), [$user]);
                }
            }

            $user = User::getUserByMailAndPassword($data);
            if (is_object($user)) {
                if ($user->ecosystem_status == Constant::$NO) {
                    return $this->renderFailure(trans('messages.ecosystem_expired'), Response::HTTP_FORBIDDEN);
                }
                $minutes = CommonHelper::countTimeDIffrenceInMinutes($user->wrong_signin_datetime);
                if ($minutes > Constant::$TIME_IN_MINUTES_TO_REACTIVE_BLOCKED_ACCOUNT) {
                    $user->wrong_signin_count = NULL;
                    $user->wrong_signin_count = 0;
                    $user->forget_password_count = 0;
                    $user->save();
                    $deviceModel = new Device();
                    $user_token = $deviceModel->registerDevice($user->user_id, isset($data['deviceToken']) ? $data['deviceToken'] : '', $data['deviceType']);
                    $user->userToken = $user_token;
                    $result = $this->renderSuccess(trans('messages.sign_in_successfully'), [$user]);
                } else {

                    $time_left_to_reactive = Constant::$TIME_IN_MINUTES_TO_REACTIVE_BLOCKED_ACCOUNT - $minutes;
                    $result = $this->renderFailure(trans('Your account is temporarily blocked due to multiple wrong attempts. Please try to login again after ' . $time_left_to_reactive . ' minutes'), Response::HTTP_FORBIDDEN);
                }
            } else {

                $user = User::getUserByMail($data['email']);
                if (is_object($user)) {

                    $result = $this->renderFailure(trans('messages.invalid_credentials'), Response::HTTP_NON_AUTHORITATIVE_INFORMATION);
                    $user->wrong_signin_count++;
                    if ($user->wrong_signin_count >= Constant::$MAX_SIGNIN_COUNT) {
                        $user->wrong_signin_datetime = date("Y-m-d H:i:s");
                        $result = $this->renderFailure(trans('Your Account is blocked for next ' . Constant::$TIME_IN_MINUTES_TO_REACTIVE_BLOCKED_ACCOUNT . ' mins due to multiple wrong credential attempts'), Response::HTTP_NON_AUTHORITATIVE_INFORMATION);
                    }
                    $user->save();
                } else {
                    $result = $this->renderFailure(trans('Invalid Email Id'), Response::HTTP_NOT_FOUND);
                }
            }
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            $result = $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
        return $result;
    }

    /**
     * 
     * Does mail when user forgot their password 
     * 
     * @param $data which contains email of user
     * 
     * @throws Exception If something happens during the process
     * 
     * @return user object with success if mail with link sent successfully otherwise failure 
     * 
     */
    public function putForgotPassword($data) {
        try {
            $user = User::getUserByMail($data['email']);
            if (!is_object($user)) {
                $result = $this->renderFailure(trans('Invalid Email Id'), Response::HTTP_NOT_FOUND, [$user]);
                return $result;
            }
            if ($user->forget_password_count < Constant::$MAX_FORGOT_COUNT) {
                $name = $user->first_name . ' ' . $user->last_name;
                $token = PasswordReset::updateUserToken($user->email);
                $mail = Mail::send('email.forgot_password', array('name' => $name, 'token' => $token, 'email' => $user->email), function($message) use($user) {
                            $message->to($user->email, $user->first_name . ' ' . $user->last_name)->subject('Benefit Wellness - Reset Password');
                        });
                $user->forget_password_count++;
                $user->save();
                // check for failures
                if (Mail::failures()) {
                    $result = $this->renderFailure(trans('Failed to send Forgot Password Email'), Response::HTTP_FAILED_DEPENDENCY, [$user]);
                    return $result;
                }
                $result = $this->renderSuccess(trans('Forgot Password Mail Sent Successfully'));
            } else {
                $result = $this->renderFailure(trans('Maximum number of forgot password attempts reached'), Response::HTTP_TOO_MANY_REQUESTS);
            }
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            $result = $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
        return $result;
    }

    public function postUserImages($data) {
        $user = Auth::user();
        if (!empty($data['image'])) {
            $user->image = $data['image'];
        }
        if (!empty($data['expertImage'])) {
            $user->expert_image = $data['expertImage'];
        }
        $user->save();
        $user->userToken = $data->header('userToken');
        $result = $this->renderSuccess(trans('messages.user_images_uploaded_successfully'), [$user]);
        return $result;
    }

    /**
     * 
     * Does profile update of expert
     * 
     * @param $data which contains information of expert to update
     * 
     * @throws Exception If something happens during the process
     * 
     * @return user object with success if updated successfully otherwise failure 
     * 
     */
    public function putExpertProfile($data) {
        try {
            $user = User::updateExpertProfile($data);
            
            if (is_object($user)) {

                return $this->renderSuccess(trans('messages.expert_profile_updated_successfully'),[$user]);
            } else {
                return $this->renderFailure(trans('messages.expert_profile_error_successfully'), Response::HTTP_NOT_FOUND);
            }
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * 
     * Provide list of experts according to searched parameters
     * 
     * @param $data contains parameters on which search has to be taken place
     * 
     * @throws Exception If something happens during the process
     * 
     * @return user(expert) objects with success if every thing went right otherwise failure 
     * 
     */
    public function getExpertList($data) {
        try {
            User::updateUserLatLong($data['currentLat'], $data['currentLong']);
            $result = User::searchExpert($data);
            $page = $data->input('page', 1);
            $expertList = UtilityHelper::getPaging($result, $page);
            $experts = array('page' => (int) $page,
                'total' => (int) $expertList['page_count'],
                'total_count' => (int) $expertList['total'],
                'experts' => $expertList['resultList']);
            return $this->renderSuccess(trans('messages.experts_retrieved_successfully'), $experts);
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * 
     * Provide detailed information of expert
     * 
     * @param $data contains expert_id to find detailed information of expert
     * 
     * @throws Exception If something happens during the process
     * 
     * @return user(expert) object with success if every thing went right otherwise failure 
     * 
     */
    public function getExpertInfo($data) {
        try {
            $user = User::expertProfile($data->input('expertId'));
//            dd($user);
            if (is_object($user)) {
                return $this->renderSuccess(trans('messages.expert_profile_retrieved_successfully'), $user);
            } else {
                return $this->renderFailure(trans('messages.expert_profile_failed_retrieved'), Response::HTTP_NOT_FOUND);
            }
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * 
     * Does creation of available slots for expert
     * 
     * @param $data contains information to create availability calender of expert
     * 
     * @throws Exception If something happens during the process
     * 
     * @return days objects with success if every thing went right otherwise failure 
     * 
     */
    public function postCreateCalendar($data) {
        DB::beginTransaction();
        try {
            $givenSlotDate = $data['date'];

            if (!(int) $data['isAvailable']) {
                ExpertCalendar::deleteExpertCalendarRecordByDate($givenSlotDate, Auth::user()->user_id);
                $allCalendarSlots = ExpertCalendar::getAllExpertCalendarRecord(Auth::user()->user_id);
                DB::commit();
                return $this->renderSuccess(trans('messages.expert_calendar_deleted'), $allCalendarSlots);
            }
            if ((int) $data['isReoccur']) {
                $newCalendarData = [];
                $now = new \DateTime();
                $currentDate = $now->format('Y-m-d');
                $lastDateOfSlots = CommonHelper::addDayswithdate($currentDate, Constant::$TIME_DURATION_FOR_REOCCUR);

                ExpertCalendar::deleteMultipleExpertCalendarRecord($givenSlotDate, $lastDateOfSlots, Auth::user()->user_id);

                $givenSlotDatetime = new \DateTime($givenSlotDate);
                $lastDatetimeOfSlots = new \DateTime($lastDateOfSlots);
                $weekDays = explode(',',$data['days']);
                while ($givenSlotDatetime <= $lastDatetimeOfSlots) {
                    
                    $dayofweek = date('w', strtotime($givenSlotDate));
                    if(in_array($dayofweek,$weekDays)):
                        foreach ($data['slots'] as $slot) {
                            $newCalendarData[] = ['date' => $givenSlotDate, 'start_time' => $slot['startTime'], 'end_time' => $slot['endTime'], 'expert_id' => Auth::user()->user_id];
                        }
                    endif; 
                    $givenSlotDate = CommonHelper::addDayswithdate($givenSlotDate, 1);
                    $givenSlotDatetime = new \DateTime($givenSlotDate);
                }
                ExpertCalendar::addBulkCalendarData($newCalendarData);
            } 
            else {
                ExpertCalendar::deleteMultipleExpertCalendarRecord($givenSlotDate, $givenSlotDate, Auth::user()->user_id);
                foreach ($data['slots'] as $slot) {
                    $newCalendarData[] = ['date' => $givenSlotDate, 'start_time' => $slot['startTime'], 'end_time' => $slot['endTime'], 'expert_id' => Auth::user()->user_id];
                }
                ExpertCalendar::addBulkCalendarData($newCalendarData);
            }
            $allCalendarSlots = ExpertCalendar::getAllExpertCalendarRecord(Auth::user()->user_id);
            DB::commit();
            return $this->renderSuccess(trans('messages.expert_calendar_created_successfully'), $allCalendarSlots);
        } catch (\Exception $e) {
            DB::rollBack();
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * 
     * Does provide available slots for expert of limited period
     * 
     * @param NULL
     * 
     * @throws Exception If something happens during the process
     * 
     * @return  objects with success if every thing went right otherwise failure 
     * 
     */
    public function getCalendarSlots() {
        try {
            $availability['userInfo'] = Auth::user();
            $availability['availableSlots'] = ExpertCalendar::getAllExpertCalendarRecord();
            $availability['bookedSlots'] = UserBooking::getAllExpertBooking();
            return $this->renderSuccess(trans('messages.availability_info_retrieved_successfully'), [$availability]);
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * 
     * Does creation of available slots for expert
     * 
     * @param $data contains information to create availability calender of expert
     * 
     * @throws Exception If something happens during the process
     * 
     * @return days objects with success if every thing went right otherwise failure 
     * 
     */
    public function deleteCalendarSlot($data) {
        try {
            if ($data['deleteType'] == Constant::$SINGLE_SLOT) {
                $expertCalendar = ExpertCalendar::findExpertCalendarRecord($data['calendarId']);
                if (is_object($expertCalendar)) {
                    $expertCalendar->forcedelete();
                    return $this->renderSuccess(trans('messages.expert_calendar_deleted'));
                } else {
                    return $this->renderFailure(trans('messages.expert_calendar_slot_not_found'), Response::HTTP_NOT_FOUND);
                }
            } else {
                $numberOfDeletedRecords = ExpertCalendar::deleteMultipleExpertCalendarRecord($data['date']);
                if ($numberOfDeletedRecords == 0) {
                    return $this->renderSuccess(trans('messages.expert_calendar_slot_not_found'));
                } else {
                    return $this->renderSuccess(trans('messages.expert_calendar_deleted'));
                }
            }
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * 
     * Does profile update of User
     * 
     * @param $data which contains information of user to update
     * 
     * @throws Exception If something happens during the process
     * 
     * @return user object with success if updated successfully otherwise failure 
     * 
     */
    public function postUpdateProfile($data) {

        try {
            $user = User::updateUser($data);
            if (is_object($user)) {
                return $this->renderSuccess(trans('messages.profile_updated'), [$user]);
            } else {
                return $this->renderFailure(trans('messages.profile_updation_failed'), StatusCode::$EXCEPTION, [false]);
            }
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * 
     * Update Activation code with respect to the logged in user and also update the status of activation to used
     * 
     * @param $data which contains information of activation code and user type to which we need to update activation code
     * 
     * @throws Exception If something happens during the process
     * 
     * @return user object with success if updated successfully otherwise failure 
     * 
     */
    public function postUpdateActivationCode($data) {
        try {
            $activationCodeStatus = ActivationCode::checkCodeStatus($data['activationCode'])->first();
            
            if ($activationCodeStatus['mail'] != Auth::user()->email) {
                return $this->renderFailure(trans('messages.activation_code_not_mapped_with_email'), Response::HTTP_BAD_REQUEST);
            } 
            $data['ecosystemId'] = $activationCodeStatus['ecosystem_id'];
            if (is_object($activationCodeStatus)) {
                $user = User::updateActivationCode($data);
                if (is_object($user)) {
                    ActivationCode::updateUsedCode($data['activationCode']);
                } else {
                    $result = $this->renderFailure(trans('messages.activation_code_updation_failed'), StatusCode::$EXCEPTION, [false]);
                }
                $result = $this->renderSuccess(trans('messages.activation_code_updated'), [$user]);
            } else {
                $result = $this->renderFailure(trans('messages.invalid_activation_code'), Response::HTTP_BAD_REQUEST, [false]);
            }
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            $result = $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
        return $result;
    }

    /**
     * 
     * Update wellness age answers and find wellness age according to them
     * 
     * @param $data which contains information about issue faced by the user
     * 
     * @throws Exception If something happens during the process
     * 
     * @return user object with success if updated successfully otherwise failure 
     * 
     */
    public function putUpdateWellnessAnswer($data) {
        DB::beginTransaction();
        try {
            $wellnessAge = $data['wellnessAge'];
            $newData = [];
            $newData['gender'] = $data['gender'];
            $newData['dob'] = $data['dob'];
            $newData['height'] = $data['height'];
            $newData['heightUnit'] = $data['heightUnit'];
            $newData['weight'] = $data['weight'];
            $newData['weightUnit'] = $data['weightUnit'];
            $newData['cigrattesPerDay'] = $data['cigrattesPerDay'];
            $newData['exerciseHourPerWeek'] = $data['exerciseHourPerWeek'];
            $newData['exerciseIntensity'] = $data['exerciseIntensity'];
            $newData['eatingHabit'] = $data['eatingHabit'];
            $newData['bloodPresure'] = $data['bloodPresure'];
            $newData['stressLevel'] = $data['stressLevel'];
            $newData['sleepHour'] = $data['sleepHour'];
            $newData['happiness'] = $data['happiness'];
            $newData['diabetes'] = $data['diabetes'];
            $user = Auth::user();
            $user = User::updateWellnessAnswer(json_encode($newData), $wellnessAge,$user);
            UserWellnessAnswer::addWellnessAnswers($newData,$wellnessAge,$user->user_id);
            if (is_object($user)) {
                $result = $this->renderSuccess(trans('messages.wellness_answers_updated'), [$user]);
            } else {
                $result = $this->renderFailure(trans('messages.common_error'), StatusCode::$EXCEPTION, [false]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            UtilityHelper::logExceptionWithObject(__METHOD__, $e);
            $result = $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
        return $result;
    }

    /**
     * 
     * Does wellness age calculation
     * 
     * @param $data containing information on which wellness age will depend
     * 
     * @throws Exception If something happens during the process
     * 
     * @return Calculated wellness Age
     * 
     */
    public function countWellnessAge($data) {
        $gender = $data['gender'];
        $dob = $data['dob'];
        $age = CommonHelper::getAgeFromDOB($dob);

        $height = $data['height'];
        $heightUnit = $data['heightUnit'];

        if ($heightUnit == Constant::$HEIGHT_IN_FEET)
            $height = CommonHelper::getHeightInCm($height);

        $weight = $data['weight'];
        $weightUnit = $data['weightUnit'];

        if ($weightUnit == Constant::$WEIGHT_IN_LBS)
            $weight = CommonHelper::getWeightInKg($weight);

        $cigrattesPerDay = $data['cigrattesPerDay'];
        $exerciseHourPerWeek = $data['exerciseHourPerWeek'];
        $exerciseIntensity = $data['exerciseIntensity'];
        $eatingHabit = $data['eatingHabit'];
        $bloodPresure = $data['bloodPresure'];
        $stressLevel = $data['stressLevel'];
        $sleepHours = $data['sleepHour'];
        $happiness = $data['happiness'];
        $diabetes = $data['diabetes'];

        $weightAsPerHeight = $weight / $height;


        $weightCheck = self::countWeightCheck($gender, $height, $weightAsPerHeight);

        $smokerCheck = self::countSmokerCheck($age, $cigrattesPerDay);

        $exerciseCheck = self::countExerciseCheck($exerciseIntensity, $exerciseHourPerWeek);

        $dietCheck = ($eatingHabit - 3) * -1.5;

        $bloodPresureCheck = self::countBloodPresureCheck($bloodPresure);

        $stressCheck = ($stressLevel - 5) / 2;

        $sleepCheck = self::countSleepHourCheck($sleepHours);

        $happinessCheck = ($happiness - 3) * -0.75;
        
        $diabetesCheck = ($diabetes == Constant::$DIABETES_YES)?1:0;
        

        $checkSum = $weightCheck + $smokerCheck + $exerciseCheck + $dietCheck + $bloodPresureCheck + $stressCheck + $sleepCheck + $happinessCheck + $diabetesCheck;

        $wellnessAge = round($age + $checkSum);
        return $wellnessAge;
    }

    public function countExerciseCheck($exerciseIntensity, $exerciseHourPerWeek) {
        switch ($exerciseIntensity) {
            case 1: //Low
                $exerciseCheck = $exerciseHourPerWeek * - 0.5;
                break;
            case 2: // Medium
                $exerciseCheck = $exerciseHourPerWeek * - 0.6;
                break;
            default:
                $exerciseCheck = $exerciseHourPerWeek * - 0.7;
        }
        return $exerciseCheck;
    }

    public function countBloodPresureCheck($bloodPresure) {
        switch ($bloodPresure) {
            case 2: // Normal
            case 4: // Don't Know
                $bloodPresureCheck = 0;
                break;
            default: // Low,High
                $bloodPresureCheck = 2;
        }
        return $bloodPresureCheck;
    }

    public function countWeightCheck($gender, $height, $weightAsPerHeight) {
        if ($gender == 'F') {
            if ($weightAsPerHeight < 0.36) {
                $weightCheck = 1;
            } else {
                if ($height < 180) {
                    if ($weightAsPerHeight < 0.43) {
                        $weightCheck = 0;
                    } else {
                        $weightCheck = ($weightAsPerHeight - 0.43) * 37;
                    }
                } else {
                    if ($weightAsPerHeight < 0.5) {
                        $weightCheck = 0;
                    } else {
                        $weightCheck = ($weightAsPerHeight - 0.5) * 37;
                    }
                }
            }
        } else {
            if ($weightAsPerHeight < 0.36) {
                $weightCheck = 3;
            } else {
                if ($height < 180) {
                    if ($weightAsPerHeight < 0.43) {
                        $weightCheck = 0;
                    } else {
                        $weightCheck = ($weightAsPerHeight - 0.43) * 50;
                    }
                } else {
                    if ($weightAsPerHeight < 0.5) {
                        $weightCheck = 0;
                    } else {
                        $weightCheck = ($weightAsPerHeight - 0.5) * 50;
                    }
                }
            }
        }
        return $weightCheck;
    }

    public function countSmokerCheck($age, $cigrattesPerDay) {
        if ($age > 30) {
            if ($cigrattesPerDay <= 3) {
                $smokerCheck = 0;
            } else {
                $smokerCheck = $cigrattesPerDay / 2;
            }
        } else {
            if ($cigrattesPerDay < 3) {
                $smokerCheck = -1;
            } elseif ($cigrattesPerDay == 3) {
                $smokerCheck = 0;
            } else {
                $smokerCheck = $cigrattesPerDay / 2.5;
            }
        }
        return $smokerCheck;
    }

    public function countSleepHourCheck($sleepHours) {
        if ($sleepHours < 4) {
            $sleepCheck = 5;
        } else {
            if ($sleepHours < 7.5) {
                $sleepCheck = 2;
            } elseif ($sleepHours < 8.1) {
                $sleepCheck = 0;
            } else {
                $sleepCheck = -2;
            }
        }
        return $sleepCheck;
    }

    /**
     * 
     * Send push notification
     * 
     * @param $request containing information of push
     * 
     * @throws Exception If something happens during the process
     * 
     * @return success if everything went right
     * 
     */
    public function getSendNotification($request) {
        try {

            $deviceObj = new Device();
            $type = Constant::$notificationSendInvitation;
            $data = array(
                'type' => $type,
                'alert' => 'Test Message',
                'toUserId' => (array) Auth::user()->user_id,
                'time' => time());
            $deviceObj->sendPush($data);

            return $this->renderSuccess(trans('messages.notification_send_successfully'));
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * 
     * Adding the qualification , categories and other info of the expert
     * 
     * @param $request containing information to update
     * 
     * @throws Exception If something happens during the process
     * 
     * @return success if everything went right
     * 
     */
    public function postExpertHeathCategory($request) {
        DB::beginTransaction();
        try {
            // Adding Qualification of expert
            $qualifications = $this->updateExpertQualification($request->all());
            
            // Adding bio of the user
            User::updateSpecificFileds(array('bio' => $request['bio']),Auth::user());

            // Adding categories if it is a Health Professional else Session Price Info
            if ($request['expertType'] == Constant::$HEALTH_PROFESSIONAL && !empty($request['expertHealthCategory'])) {
                $expertCategoriesArray = explode(',', $request['expertHealthCategory']);
                $data = self::addExpertHealthCat($expertCategoriesArray, Auth::user()->user_id);
                ExpertHealthCategories::where('expert_id',Auth::user()->user_id)->forceDelete();
                ExpertHealthCategories::insert($data);
            } else {
                $sessionPrices = array('introductory' => $request['introductoryPrice'], 'one_session' => $request['oneSessionPrice'], 'ten_session' => $request['tenSessionPrice'], 'twenty_session' => $request['twentySessionPrice']);
                SessionPrice::updateExpertSessionPrice($sessionPrices, Auth::user()->user_id);
            }
            DB::commit();
            return $this->renderSuccess(trans('messages.expert_profile_updated_successfully'),$qualifications);
        } catch (Exception $e) {
            DB::rollBack();
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }
    
    /**
     * 
     * Updating Expert Qualification if Id is given otherwise inserting it using bulk
     * 
     * @param $data containing information to add/update
     * 
     * @return NULL
     * 
     */
    public function updateExpertQualification($data){
        
        $bulkDataOfQualification = [];
        for ($i = 1; $i <= $data['qualificationImageCount']; $i++) {
            if(!empty($data['qualificationId' . $i])){
                $qualificationData = [];
                if (!empty($data['qualificationImage' . $i])){
//                    $image = $this->file->upload($data['qualificationImage' . $i], Constant::$USER_QUALIFICATION_IMAGE);
                    $qualificationData['qualification_image'] = $data['qualificationImage' . $i];
                }
                if (!empty($data['qualificationName' . $i])){
                    $qualificationData['qualification_name'] = $data['qualificationName' . $i]; }
                ExpertQualification::updateExpertQualification($data['qualificationId' . $i],$qualificationData);
            }
            else{
                if (!empty($data['qualificationImage' . $i]) && !empty($data['qualificationName' . $i])) {
//                    $image = $this->file->upload($data['qualificationImage' . $i], Constant::$USER_QUALIFICATION_IMAGE);
                    $bulkDataOfQualification[] = array('qualification_image' => $data['qualificationImage' . $i], 'qualification_name' => $data['qualificationName' . $i], 'expert_id' => Auth::user()->user_id);
                }
            }
        }
        $qualifications = ExpertQualification::addExpertQualification($bulkDataOfQualification);
        return $qualifications;
    }
    
    
    public static function addExpertHealthCat($interestHealthCatArray,$userId)
    {    
        $categories = MasterHealthCategories::all()->keyBy('category_id');
        $data = array();
        if (is_array($interestHealthCatArray) && count($interestHealthCatArray) > 0) {
            foreach ($interestHealthCatArray as $catId) {
                
                $data[] = array(
                    'expert_id' => $userId,
                    'category_id' => $catId,
                    'category_name' => $categories[$catId]['name']
                );
            }
        }
       return $data;
    }

    /**
     * 
     * Send help request to the backend if user need help (limited help request allowed per day)
     * 
     * @param $data contain description of help
     * 
     * @throws Exception If something happens during the process
     * 
     * @return success if help request created successfully otherwise failure
     * 
     */
    public function postHelp($data) {
        try {
            $count = GetHelp::getCountTodayHelp();
            if ($count < Constant::$MAX_GET_HELP_COUNT) {
                $help = GetHelp::createHelp($data);
                if (is_object($help)) {
                    return $this->renderSuccess(trans('messages.user_help_recieved_successfully'), [$help]);
                } else {
                    return $this->model_not_found_error(trans('messages.common_error'));
                }
            } else {
                return $this->model_not_found_error(trans('messages.reached_daily_limit_for_help'));
            }
        } catch (Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * 
     * Does provide profile info of user
     * 
     * @param NULL
     * 
     * @throws Exception If something happens during the process
     * 
     * @return user object 
     * 
     */
    public function getProfile() {
        try {
            $user = User::getUserProfileWithGoals();
            return $this->renderSuccess(trans('messages.profile_retrieved_successfully'), $user);
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * 
     * Does provide profile info of user with their availability
     * 
     * @param NULL
     * 
     * @throws Exception If something happens during the process
     * 
     * @return user object 
     * 
     */
    public function getProfileWithAvailability($data) {
        try {
            if(empty($data['userid'])){
                $user = Auth::user();
            }
            else{
                $user = User::getUserById($data['userid']);
                if(!is_object($user)){
                    return $this->renderFailure(trans('messages.user_not_found'), Response::HTTP_OK);
                }
            }
            $user = User::getUserProfileWithAvailability($user);
            return $this->renderSuccess(trans('messages.profile_retrieved_successfully'), $user);
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }
    
    public function getUserWithGoals($data) {
        try {
            if(empty($data['userid'])){
                $user = Auth::user();
            }
            else{
                $user = User::getUserById($data['userid']);
                if(!is_object($user)){
                    return $this->renderFailure(trans('messages.user_not_found'), Response::HTTP_OK);
                }
            }
            
            $user = User::getUserWithGoals($user);
            return $this->renderSuccess(trans('messages.profile_retrieved_successfully'), $user);
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }
    
    public function putRemoveExpertProfile() {
        DB::beginTransaction();
        try {
                $user = Auth::user();
                $user = User::deleteExpert($user);
                DB::commit();
                return $this->renderSuccess(trans('messages.expert_profile_deleted'),[$user]);
        } catch (\Exception $e) {
            DB::rollBack();
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }
    
    public function postMailActivationCode($data) {
        try {
                $user = User::where('email',$data['email'])->first();
                if(is_object($user)){
                    return $this->renderFailure(trans('messages.email_already_registered'), Response::HTTP_OK);
                }
                $activationCode = ActivationCode::where('mail',$data['email'])->first();
                $email = $data['email'];
                $emailParts = explode("@",$email);
                Mail::send('email.activation_code_email', array('activation_code' =>$activationCode['code'],'username'=>$emailParts[0]), function($message) use($email) {
                    $message->to($email)->subject('Benefit Wellness - Activation Code');
                });
                return $this->renderSuccess(trans('messages.activation_code_mail_sent'));
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

}
