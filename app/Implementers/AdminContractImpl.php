<?php

/*
 * File: AdminContractImpl.php
 */

namespace App\Implementers;

use App\Contracts\AdminContract;
use App\Helper\Utility\FileRepositoryLocal;
use App\Models\User;
use App\Helper\Utility\UtilityHelper;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Codes\Constant;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Models\ActivationCode;
use Yajra;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use App\Models\MasterHealthDataByType;
use App\Models\ReportIssue;
use App\Models\UserFeedback;
use Illuminate\Support\Facades\DB;
use App\Models\GetHelp;
use App\Models\UserHealthProvider;
use App\Codes\StatusCode;
use App\Models\Setting;
use App\Models\Device;
use App\Models\MasterWorks;
use App\Models\MasterGym;
use App\Models\MasterBeacon;
use App\Models\MasterReward;
use App\Models\MasterEcosystem;
use App\Helper\Utility\CommonHelper;
use App\Models\MasterFeature;
use App\Models\MasterMerchant;
use App\Models\EcosystemReward;
use App\Helper\Utility\FileRepositoryS3;
use App\Models\SessionPrice;
use App\Models\MasterHealthCategories;
use App\Models\NotificationsLogs;
use App\Models\ExpertQualification;

class AdminContractImpl extends BaseImplementer implements AdminContract {

    public function __construct() {
        if (env('STORAGE_TYPE') == 'S3') {
            $this->file = new FileRepositoryS3();
        } else {
            $this->file = new FileRepositoryLocal();
        }
    }

    /**
     * @function postForgotPassword
     * @description purpose to get temporary password on mail and then change password when logged in
     * @param type $request
     * @return boolean
     */
    public function postForgotPassword($request) {
        try {
            $user = User::where('email', $request->email)->where('user_type', '=', Constant::$ADMIN)->where('deleted_at', NULL)->first();
            // if user object not found
            if (!is_object($user)) {
                return StatusCode::$EMAIL_NOT_EXISTS;
            }
            $tempPassword = UtilityHelper::generateRandomString(6);
            User::updatePassword($user->user_id, $tempPassword, 1);

            $orgName = Constant::$ORGANISATIONNAME;
            $email = $user->email;
            $fullName = $user->first_name . ' ' . $user->last_name;
            // to send mail
            Mail::send('email.admin_forgot_password', array('orgName' => $orgName, 'password' => $tempPassword, 'fullName' => $fullName), function($message) use($email, $orgName) {
                $message->to($email)->subject('New Password Request');
            });
            return TRUE;
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     *
     * @function postChangePassword
     * @description this function is used to change password
     * @param type $request
     * @return boolean
     */
    public function postChangePassword($request) {
        $inputData = $request->input();
        try {
            $userId = Auth::user()->user_id;
            $checkPassword = User::where('user_id', $userId)
                    ->where('deleted_at', Constant::$DELETED_NULL)
                    ->select('password')
                    ->first();

            if (!is_object($checkPassword)) {
                $return = $this->renderFailure(trans('messages.account_suspended'), Response::HTTP_OK);
            } elseif (!Hash::check($inputData['oldPassword'], $checkPassword->password)) {

                $return = $this->renderFailure(trans('messages.incorrect_old_password'), Response::HTTP_OK);
            } else {

                User::updatePassword($userId, $inputData['newPassword']);
                $return = $this->renderSuccess(trans('messages.password_change_success'));
            }
        } catch (Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            $return = $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
        return $return;
    }

    /**
     * @function postImportExcel
     * @purpose is used to export csv file
     * @param type $request
     * @return type
     *
     */
    public function postImportExcel($request) {
        try {

            $failedRowArray = [];
            $path = Input::file('import_file')->getRealPath();
            $ecoSystemId = $request->input('ecosystemId');
            $data = Excel::load($path)->get();
            if (!empty($data) && $data->count()) {
                $ecosystem = MasterEcosystem::where('ecosystem_id', $ecoSystemId)->with('codesCount')->first();
                $activationCodeCount = $ecosystem['codesCount']['code_count'];

                $keys = array_keys($data[0]->toArray());
                $i = 1;
                // to check availability of number of users
                if (($data->count() + $activationCodeCount) > $ecosystem['number_of_users']) {
                    return $this->renderFailure(trans('messages.activation_code_limit_reached'), StatusCode::$CSV_HEADERS_INCORRECT);
                }

                // to check headers of the sheet
                if ($keys[0] != Config::get('constants.activationHeader.mail') || $keys[1] != Config::get('constants.activationHeader.name') || $keys[2] != Config::get('constants.activationHeader.surname') || $keys[3] != Config::get('constants.activationHeader.company') || $keys[4] != Config::get('constants.activationHeader.department') || $keys[5] != Config::get('constants.activationHeader.designation')) {
                    return $this->renderFailure(trans('messages.csv_file_headers_incorrect'), StatusCode::$CSV_HEADERS_INCORRECT);
                }

                $existingActivationCodes = ActivationCode::getActivationCodeList();

                foreach ($data as $key => $value) {

                    $code = CommonHelper::getRandSecure(Constant::$ACTIVATION_CODE_LENGTH, $existingActivationCodes);

                    $eachRow = array('code' => $code,
                        'mail' => $value->mail,
                        'name' => $value->name,
                        'surname' => $value->surname,
                        'company' => $value->company,
                        'department' => $value->department,
                        'designation' => $value->designation,
                        'ecoSystem_id' => $ecoSystemId);
                    //rules to validate each row of the sheet
                    $rule = array(
                        'code' => 'required|unique:master_activation_codes,code,NULL,code_id,deleted_at,NULL',
                        'mail' => 'required|email|unique:master_activation_codes,mail,NULL,code_id,deleted_at,NULL',
                        'name' => 'required',
                        'surname' => 'required',
                        'company' => 'required',
                        'department' => 'required',
                        'designation' => 'required',
                        'ecoSystem_id' => 'required',
                    );
                    $message = [];
                    $validator = Validator::make($eachRow, $rule, $message);
                    if (($validator->fails())) { // if validation fails
                        $errorMessage = !empty($validator->messages()) && count($validator->messages()) ? $validator->messages() : trans('messages.code_already_taken');
                        $failedRowArray[] = ['row' => $i, 'error' => $errorMessage];
                    } else {
                        $insert[] = ['code' => $code, 'mail' => $value->mail, 'name' => $value->name, 'surname' => $value->surname, 'company' => $value->company, 'department' => $value->department, 'designation' => $value->designation, 'ecoSystem_id' => $ecoSystemId];
                        array_push($existingActivationCodes, $code);
                    }

                    $i++;
                }

                if (!empty($insert)) {
                    // save the records
                    ActivationCode::insert($insert);
                    $noOfRowsImported = count($insert);
                    if (empty($failedRowArray)) {

                        return $this->renderSuccess(trans('messages.import_success'));
                    } else {
                        $noOfRowsNotImported = count($failedRowArray);
                        // display the errors with error data
                        return $this->renderFailure(trans('messages.Unable_import', ['noOfRowsImported' => $noOfRowsImported, 'noOfRowsNotImported' => $noOfRowsNotImported]), Response::HTTP_OK, $failedRowArray);
                    }
                } else {
                    // display the errors with error data
                    return $this->renderFailure(trans('messages.import_failure'), Response::HTTP_OK, $failedRowArray);
                }
            } else {
                // display the errors when file is empty
                return $this->renderFailure(trans('messages.import_file_empty'), Response::HTTP_OK);
            }
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * @function getActivationCodeList
     * @purpose to show activation code list
     * @return type
     *
     */
    public function getActivationCodeList($id) {
        return view('admin.code_listing', array('id' => $id));
    }

    /**
     * @function getActivationCodeData
     * @purpose to get activation code from database
     * @return type
     *
     */
    public function getActivationCodeData($id) {
        try {
            $results = ActivationCode::where('ecosystem_id', $id)->where('deleted_at', Constant::$DELETED_NULL)->orderBy('created_at', 'desc')->get();
            $activationStatus = Config::get('constants.activationStatus');
            $activationIsUsed = Config::get('constants.activationIsUsed');
            return Yajra\Datatables\Datatables::of($results)
                            ->editColumn('status', function ($model)use($activationStatus) {
                                if ($model->status == Constant::$codeActive) {
                                    return $activationStatus['active'];
                                } else {
                                    return $activationStatus['inactive'];
                                }
                            })
                            ->editColumn('is_used', function ($model)use($activationIsUsed) {
                                return $activationIsUsed[$model->is_used];
                            })
                            ->make(true);
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * @function postDeleteActivationCode
     * @purpose to change status of activation code from active to inactive
     * @param type $request
     * @return type
     *
     */
    public function postDeleteActivationCode($request) {
        try {
            $inputData = $request['ids'];
            if (ActivationCode::deleteActivationCode($inputData)) {
                Session::put('success-message', trans('messages.activationcode_deleted_success'));
                return $this->renderSuccess(trans('messages.activationcode_deleted_success'));
            }
            return $this->renderFailure(trans('messages.activationcode_deleted_failure'), Response::HTTP_OK);
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * @function getUserListing
     * @purpose to return user listing page
     * @return type
     *
     */
    public function getUserListing() {
        return view('admin.user_listing');
    }

    /**
     * @function getUserData
     * @purpose to fetch user data from database
     * @param type $request
     * @return type
     *
     */
    public function getUserData($request) {
        try {
            // if for expert
            if (!empty($request->get('flag'))) {
                $results = User::where('is_interested_for_expert', '=', Constant::$EXPERT_CONFIRM)->where('deleted_at', Constant::$DELETED_NULL)->with('ecosystem')->orderBy('created_at', 'desc')->get();
            } else { // else for other type of users
                $results = User::where('user_type', '!=', Constant::$ADMIN)->where('deleted_at', Constant::$DELETED_NULL)->with('ecosystem')->orderBy('created_at', 'desc')->get();
            }


            return Yajra\Datatables\Datatables::of($results)
                            ->editColumn('image', function ($model) {
                                return !empty($model->image) ? $model->image : asset('images/profile.png');
                            })
                            ->make(true);
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * @function getUserListing
     * @purpose to return user listing page
     * @return type
     *
     */
    public function getGymListing() {
        return view('admin.gym_listing');
    }

    /**
     * @function getUserData
     * @purpose to fetch user data from database
     * @param type $request
     * @return type
     *
     */
    public function getGymData($request) {
        try {
            $results = MasterGym::orderBy('created_at', 'desc')->get();
            return Yajra\Datatables\Datatables::of($results)->make(true);
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * @function postDeleteUser
     * @purpose to delete user(s)
     * @param type $request
     * @return type
     *
     */
    public function postDeleteUser($request) {
        try {
            if (User::deleteUser($request['ids'])) {
                Session::put('success-message', trans('messages.user_deleted_success'));
                return $this->renderSuccess(trans('messages.user_deleted_success'));
            }
            return $this->renderFailure(trans('messages.user_deleted_failure'), Response::HTTP_OK);
        } catch (Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * @function postDisapproveExpert
     * @purpose to reject user to beome expert
     * @param type $request
     * @return type
     *
     */
    public function postDisapproveExpert($request) {
        try {
            $user = User::disapproveUserAsExpert($request['id']);
            if (!empty($user)) {
                $orgName = Constant::$ORGANISATIONNAME;
                $email = $user->email;
                $fullName = $user->first_name . ' ' . $user->last_name;

                Mail::send('email.disapprove_expert', array('orgName' => $orgName, 'fullName' => $fullName), function($message) use($email, $orgName) {
                    $message->to($email)->subject('Request To become Expert rejected');
                });

                $deviceObj = new Device();
                $type = Constant::$EXPERT_DISAPPROVED_NOTIFICATION;
                $data = array('type' => $type, 'alert' => 'Request To become Expert rejected', 'toUserId' => (array) $request['id'], 'time' => time());
                $deviceObj->sendPush($data);

                $notificationData['reciever_user_id'] = $request['id'];
                $notificationData['sender_user_id'] = Auth::user()->user_id;
                $notificationData['type'] = $type;
                $notificationData['message'] = '<div style="font-family:AkkuratLight;font-size:16px;letter-spacing:1pt;color:rgb(109,111,125);">Request to become an expert rejected.</div>';

                $notification = NotificationsLogs::createNotification($notificationData); // adding notification to the notification
                //mail to be sent
                Session::put('success-message', trans('messages.user_disapproved_success'));
                return $this->renderSuccess(trans('messages.user_disapproved_success'));
            }
            return $this->renderFailure(trans('messages.user_disapproved_failure'), Response::HTTP_OK);
        } catch (Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * @function postApproveExpert
     * @purpose to approve expert request to beme expert
     * @param type $request
     * @return type
     *
     */
    public function postApproveExpert($request) {
        try {
            $user = User::approveUserAsExpert($request['id']);
            if (!empty($user)) {

                $email = $user->email;
                $fullName = $user->first_name . ' ' . $user->last_name;
                //mail to be sent
                Mail::send('email.approve_expert', array('fullName' => $fullName), function($message)use($email) {
                    $message->to($email)->subject('Request to become Expert approved');
                });

                $deviceObj = new Device();
                $type = Constant::$EXPERT_APPROVED_NOTIFICATION;
                $data = array('type' => $type, 'alert' => 'Request To become Expert approved', 'toUserId' => (array) $request['id'], 'time' => time());
                $deviceObj->sendPush($data);

                $notificationData['reciever_user_id'] = $request['id'];
                $notificationData['sender_user_id'] = Auth::user()->user_id;
                $notificationData['type'] = $type;
                $notificationData['message'] = '<div style="font-family:AkkuratLight;font-size:16px;letter-spacing:1pt;color:rgb(109,111,125);">Request to become an expert approved.</div>';

                $notification = NotificationsLogs::createNotification($notificationData); // adding notification to the notification

                Session::put('success-message', trans('messages.user_approved_success'));
                return $this->renderSuccess(trans('messages.user_approved_success'));
            }
            return $this->renderFailure(trans('messages.user_approved_failure'), Response::HTTP_OK);
        } catch (Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * @function getUserDetail
     * @purpose to fetch complete user detail
     * @param type $id
     * @return type
     *
     *
     */
    public function getUserDetail($id) {
        $userDetail = User::with(['expertcalendar' => function($query) {
                        $query->where(DB::raw("DATE(date)"), '>', date('Y-m-d'));
                        $query->orderBy('date', 'asc');
                        $query->orderBy('start_time', 'asc');
                    }])->with('SessionPrices')->with('qualifications')->where('user_id', $id)->first();
        $expertCalendar = [];
        if (!empty($userDetail)) {
            foreach ($userDetail['expertcalendar'] as $userCalendar) {
                $expertCalendar[$userCalendar->date][] = array('date' => $userCalendar->date, 'start_time' => $userCalendar->start_time,
                    'end_time' => $userCalendar->end_time,
                );
            }
        }
        return view('admin.user_detail', array('userDetail' => $userDetail, 'expertCalendar' => $expertCalendar));
    }

    /**
     * @function getProviderListing
     * @purpose to return health provider listing page
     * @return type
     *
     */
    public function getProviderListing() {
        return view('admin.provider_listing');
    }

    /**
     * @function getProviderData
     * @purpose to fetch health provider data from datatable
     * @param type $request
     * @return type
     *
     */
    public function getProviderData() {
        $results = MasterHealthDataByType::where('type', Config::get('constants.attributeType.healthProvider'))->orderBy('created_at', 'DESC')->get();
        $weekDay = Config::get('constants.weekDay');
        $delivery = Config::get('constants.delivery');
        return Yajra\Datatables\Datatables::of($results)
                        ->editColumn('logo', function ($model) {
                            $logo = !empty($model->logo) ? $model->logo : asset('images/venue_default_img.png');
                            return $logo;
                        })
                        ->addColumn('timings', function ($model) {

                            return !empty($model->opening_hrs) ? $model->opening_hrs . '-' . $model->closing_hrs : '';
                        })
                        ->editColumn('closing_day', function ($model)use($weekDay) {

                            return !empty($model->closing_day) ? $weekDay[$model->closing_day] : '';
                        })
                        ->editColumn('delivery', function ($model)use($delivery) {

                            return ($model->delivery == 1 || $model->delivery == 0) ? $delivery[$model->delivery] : '';
                        })
                        ->make(true);
    }

    /**
     * @function getInsuranceListing
     * @purpose to get health insurance page listing
     * @return type
     *
     */
    public function getInsuranceListing() {
        return view('admin.insurance_listing');
    }

    /**
     * @function getInsuranceData
     * @purpose fetch health insurance data
     * @return type
     *
     */
    public function getInsuranceData() {
        $results = MasterHealthDataByType::where('type', Config::get('constants.attributeType.healthInsurance'))->get();
        return Yajra\Datatables\Datatables::of($results)
                        ->editColumn('logo', function ($model) {
                            $logo = !empty($model->logo) ? $model->logo : asset('images/venue_default_img.png');
                            return $logo;
                        })
                        ->make(true);
    }

    /**
     * @function getWorkListing
     * @purpose to get work page listing
     * @return type
     *
     */
    public function getWorkListing() {
        return view('admin.work_listing');
    }

    /**
     * @function getMerchantListing
     * @purpose to get merchant page listing
     * @return type
     *
     */
    public function getMerchantListing() {
        return view('admin.merchant_listing');
    }

    /**
     * @function getEcosystemListing
     * @purpose to get ecosystem page listing
     * @return type
     *
     */
    public function getEcosystemListing() {
        return view('admin.ecosystem_listing');
    }

    /**
     * @function getEcosystemData
     * @purpose fetch ecosystem data
     * @return type
     *
     */
    public function getEcosystemData() {
        $results = MasterEcosystem::withTrashed();
        return Yajra\Datatables\Datatables::of($results)->withTrashed()->make(true);
    }

    /**
     * @function getRewardListing
     * @purpose to get Reward page listing
     * @return Null
     *
     */
    public function getRewardListing() {
        return view('admin.reward_listing');
    }

    /**
     * @function getRewardListing
     * @purpose to get Reward page listing
     * @return Null
     *
     */
    public function getRewardByMerchant($data) {
        try {
            $rewardsData = MasterReward::where('master_merchant_id', $data['id'])->pluck('reward_name', 'master_reward_id');
            return $this->renderSuccess(trans('messages.reward_retrieved_successfully'), $rewardsData);
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * @function getRewardData
     * @purpose fetch reward data
     * @return type
     *
     */
    public function getRewardData() {
        $results = MasterReward::withTrashed()->get();
        return Yajra\Datatables\Datatables::of($results)
                        ->editColumn('logo', function ($model) {
                            $logo = !empty($model->logo) ? $model->logo : asset('images/venue_default_img.png');
                            return $logo;
                        })
                        ->make(true);
    }

    /**
     * @function getWorkData
     * @purpose fetch work data
     * @return type
     *
     */
    public function getWorkData() {
        $results = MasterWorks::get();
        return Yajra\Datatables\Datatables::of($results)
                        ->editColumn('logo', function ($model) {
                            $logo = !empty($model->logo) ? $model->logo : asset('images/venue_default_img.png');
                            return $logo;
                        })
                        ->make(true);
    }

    /**
     * @function getMerchantData
     * @purpose fetch merchant data
     * @return type
     *
     */
    public function getMerchantData() {
        $results = MasterMerchant::get();
        return Yajra\Datatables\Datatables::of($results)->make(true);
    }

    /**
     * @function getWork
     * @purpose return work data
     * @param type $workId
     * @return type
     *
     */
    public function getWork($workId) {
        $data = [];
        if (!empty($workId)) {
            $data = MasterWorks::getWorkData($workId);
        }
        return view('admin.save_work', array('workData' => $data));
    }

    /**
     * @function getMerchant
     * @purpose return merchant data
     * @param type $merchantId
     * @return type
     *
     */
    public function getMerchant($merchantId) {
        $data = [];
        if (!empty($merchantId)) {
            $data = MasterMerchant::find($merchantId);
        }
        return view('admin.save_merchant', array('merchantData' => $data));
    }

    /**
     * @function getEcosystem
     * @purpose return ecosystem data
     * @param type $ecosystemId
     * @return type
     *
     */
    public function getEcosystem($ecosystemId) {
        $data = [];
        $rewardsData = [];
        $features = MasterFeature::getAllFeatures();
        $merchants = MasterMerchant::getMerchantsList();
        $works = MasterWorks::getWorksList(Constant::$PERSONAL_TRAINER);
        if (!empty($ecosystemId)) {
            $data = MasterEcosystem::getEcosystemData($ecosystemId);
            $allUniqueMerchants = array_unique($data->rewards()->pluck('master_merchant_id')->toArray());
            $rewardsData = MasterReward::getRewardByMerchant($allUniqueMerchants);
        }
        return view('admin.save_ecosystem', array('ecosystemData' => $data, 'merchants' => $merchants, 'features' => $features, 'works' => $works, 'rewardsData' => $rewardsData));
    }

    /**
     * @function getReward
     * @purpose return reward data
     * @param type $rewardId
     * @return type
     *
     */
    public function getReward($rewardId) {
        $data = [];
        if (!empty($rewardId)) {
            $data = MasterReward::getRewardData($rewardId);
        }
        $merchants = MasterMerchant::getMerchantsList();
        return view('admin.save_reward', array('rewardData' => $data, 'merchants' => $merchants));
    }

    public function getGym($gymId) {
        $gymGroups = MasterWorks::getWorksList(Constant::$PERSONAL_TRAINER);
        $data = [];
        if (!empty($gymId)) {
            $data = MasterGym::getGymData($gymId);
        }
        return view('admin.save_gym', array('gymData' => $data, 'gymGroups' => $gymGroups));
    }

    /**
     * @function postSaveWorkData
     * @purpose save and edit work data
     * @param type $request
     * @return type
     *
     */
    public function postSaveWorkData($request) {
        try {
            $imageType = Config::get('constants.imageType');
            $workId = $request->input('work_id', 0);
            if ($workId > 0) {
                $workData = MasterWorks::where('work_id', $workId)->first();
            } else {
                $workData = new MasterWorks();
            }
            $workData->work_name = $request->input('work_name');
            $workData->type = $request->input('type');
            $returnImage = $this->file->upload($request->file('logo'), $imageType['workImagePath']);
            if (!empty($returnImage['image'])) {
                $workData->logo = $returnImage['image'];
            }

            $workData->save();
            Session::put('success-message', trans('messages.health_insurance_success'));
            return $this->renderSuccess(trans('messages.health_insurance_success'));
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * @function postSaveEcosystemData
     * @purpose save and edit ecosystem data
     * @param type $request
     * @return type
     *
     */
    public function postSaveEcosystemData($request) {
        DB::beginTransaction();
        try {
            $ecosystemId = $request->input('ecosystem_id', 0);
            $password = CommonHelper::getRandSecure(Constant::$MERCHANT_CODE_LENGTH);
            if ($ecosystemId > 0) {
                $ecosystemData = MasterEcosystem::withTrashed()->where('ecosystem_id', $ecosystemId)->with('subadmin')->first();
                if (!empty($request->input('email'))) {
                    $user = User::getUserByMail($request->input('email'));
                    if (empty($ecosystemData['subadmin']['email'])) {
                        if (is_object($user)) {
                            return $this->renderFailure(trans('messages.email_already_registered'), Response::HTTP_OK);
                        }
                        $user = User::createSubAdmin($request->input('email'), $password);
                        $this->sendEcosystemSubadminPasswordEmail($ecosystemData, $request->input('email'), $password);
                        $ecosystemData->subadmin_user_id = $user['user_id'];
                    } else {
                        if ($request->input('email') != $ecosystemData['subadmin']['email']) {
                            if (is_object($user)) {
                                return $this->renderFailure(trans('messages.email_already_registered'), Response::HTTP_OK);
                            }
                            $user = User::createSubAdmin($request->input('email'), $password);
                            $this->sendEcosystemSubadminPasswordEmail($ecosystemData, $request->input('email'), $password);
                            User::deleteUser(array($ecosystemData['subadmin']['user_id']));
                            $ecosystemData->subadmin_user_id = $user['user_id'];
                        }
                    }
                }
            } else {
                $ecosystemData = new MasterEcosystem();
                if (!empty($request->input('email'))) {
                    $user = User::getUserByMail($request->input('email'));
                    if (is_object($user)) {
                        return $this->renderFailure(trans('messages.email_already_registered'), Response::HTTP_OK);
                    }
                    $user = User::createSubAdmin($request->input('email'), $password);
                    $this->sendEcosystemSubadminPasswordEmail($ecosystemData, $request->input('email'), $password);
                    $ecosystemData->subadmin_user_id = $user['user_id'];
                }
            }
            $ecosystemData->ecosystem_name = $request->input('ecosystem_name');
            $ecosystemData->number_of_users = $request->input('number_of_users');
            $ecosystemData->expiry_date = $request->input('expiry_date');
            $ecosystemData = $this->uploadEcosystemLogo($ecosystemData, $request->file('logo'));
            $ecosystemData->save();


            $this->syncEcosystemFeatures($ecosystemData, $request->input('features'));
            $this->syncEcosystemgyms($ecosystemData, $request->input('gyms'));
            $this->syncEcosystemRewards($ecosystemData, $request->input('rewards'));
            DB::commit();
            Session::put('success-message', trans('messages.ecosystem_success'));
            return $this->renderSuccess(trans('messages.ecosystem_success'));
        } catch (\Exception $e) {
            DB::rollBack();
            UtilityHelper::logExceptionWithObject(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * @function syncEcosystemRewards
     * @purpose synchronize the rewards of the ecosystem
     */
    public function syncEcosystemRewards($ecosystemData, $rewardsData) {
        $ecosystemData->rewards()->delete();
        if (!empty($rewardsData)) {
            $allRewardData = [];
            foreach ($rewardsData as $rewardData) {
                $allRewardData[] = ['master_merchant_id' => $rewardData['master_merchant_id'],
                    'master_reward_id' => $rewardData['master_reward_id'],
                    'tier' => $rewardData['tier'],
                    'expiry' => $rewardData['expiry'],
                    'ecosystem_id' => $ecosystemData['ecosystem_id']
                ];
            }
            EcosystemReward::insert($allRewardData);
        }
    }

    /**
     * @function syncEcosystemFeatures
     * @purpose synchronize the features of the ecosystem
     */
    public function syncEcosystemFeatures($ecosystemData, $data) {
        if (!empty($data)) {
            $ecosystemData->features()->sync($data);
        } else {
            $ecosystemData->features()->sync([]);
        }
    }

    /**
     * @function syncEcosystemgyms
     * @purpose synchronize the gyms of the ecosystem
     */
    public function syncEcosystemgyms($ecosystemData, $data) {
        if (!empty($data)) {
            $ecosystemData->gyms()->sync($data);
        } else {
            $ecosystemData->gyms()->sync([]);
        }
    }

    /**
     * @function uploadEcosystemLogo
     * @purpose upload logo of the ecosystem
     */
    public function uploadEcosystemLogo($ecosystemData, $data) {
        if (!empty($data)) {
            $imageType = Config::get('constants.imageType');
            $returnImage = $this->file->upload($data, $imageType['ecosystemImagePath']);
            if (!empty($returnImage['image'])) {
                $ecosystemData->logo = $returnImage['image'];
            }
        }
        return $ecosystemData;
    }

    /**
     * @function sendEcosystemSubadminPasswordEmail
     * @purpose send mail to the sub-admin of the ecosystem
     */
    public function sendEcosystemSubadminPasswordEmail($ecosystemData, $email, $password) {
        if (!empty($ecosystemData->subadmin_user_id)) {
            Mail::send('email.password_email', array('password' => $password), function($message) use($email) {
                $message->to($email)->subject('Benefit Wellness - Subadmin Password Email');
            });
        }
    }

    /**
     * @function postSaveMerchantData
     * @purpose save and edit merchant data
     * @param type $request
     * @return type
     *
     */
    public function postSaveMerchantData($request) {
        try {
            $merchantId = $request->input('master_merchant_id', 0);
            if ($merchantId > 0) {
                $merchantData = MasterMerchant::where('master_merchant_id', $merchantId)->first();
            } else {
                $merchantData = new MasterMerchant();
                $existingMerchantCodes = MasterMerchant::pluck('merchant_code')->toArray();
                $merchantData->merchant_code = CommonHelper::getRandSecure(Constant::$MERCHANT_CODE_LENGTH, $existingMerchantCodes, Constant::$NUMERIC);
            }
            $merchantData->merchant_name = $request->input('merchant_name');
            $merchantData->save();
            Session::put('success-message', trans('messages.merchant_success'));
            return $this->renderSuccess(trans('messages.merchant_success'));
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * @function postSaveRewardData
     * @purpose save and edit reward data
     * @param type $request
     * @return type
     *
     */
    public function postSaveRewardData($request) {
        try {
            $imageType = Config::get('constants.imageType');
            $rewardId = $request->input('master_reward_id', 0);
            if ($rewardId > 0) {
                $rewardData = MasterReward::where('master_reward_id', $rewardId)->first();
            } else {
                $rewardData = new MasterReward();
            }
            $rewardData->reward_name = $request->input('reward_name');
            $rewardData->reward_description = $request->input('reward_description');
            $rewardData->master_merchant_id = $request->input('master_merchant_id');
            $returnImage = $this->file->upload($request->file('reward_image'), $imageType['rewardImagePath']);
            if (!empty($returnImage['image'])) {
                $rewardData->reward_image = $returnImage['image'];
            }
            $rewardData->save();
            Session::put('success-message', trans('messages.reward_saved_successfully'));
            return $this->renderSuccess(trans('messages.reward_saved_successfully'));
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * @function postSaveGymData
     * @purpose save and edit Gym data
     * @param type $request
     * @return true of success
     *
     */
    public function postSaveGymData($request) {
        DB::beginTransaction();
        try {
            $masterGymId = MasterGym::addGymData($request);
            MasterBeacon::addBeaconData($request['beacon'], $masterGymId);
            DB::commit();
            Session::put('success-message', trans('messages.gym_success'));
            return $this->renderSuccess(trans('messages.gym_success'));
        } catch (\Exception $e) {
            DB::rollBack();
            UtilityHelper::logExceptionWithObject(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * @function postSaveInsuranceData
     * @purpose save and edit health insurance data
     * @param type $request
     * @return type
     *
     */
    public function postSaveInsuranceData($request) {
        try {

            $imageType = Config::get('constants.imageType');
            $attributeId = $request->input('attribute_id', 0);
            $attributeType = Config::get('constants.attributeType');
            if ($attributeId > 0) {
                $healthData = MasterHealthDataByType::where('attribute_id', $attributeId)->first();
            } else {
                $healthData = new MasterHealthDataByType();
            }
            $healthData->name = $request->input('name');
            $healthData->type = $attributeType['healthInsurance'];
            $healthData->description = $request->input('description');
            $healthData->website = $request->input('website');
            $returnImage = $this->file->upload($request->file('logo'), $imageType['healthDataImagePath']);
            if (!empty($returnImage['image'])) {
                $healthData->logo = $returnImage['image'];
            }

            $healthData->save();
            Session::put('success-message', trans('messages.health_insurance_success'));
            return $this->renderSuccess(trans('messages.health_insurance_success'));
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * @function postSaveProviderData
     * @purpose to save and edit health provider data
     * @param type $request
     * @return type
     *
     */
    public function postSaveProviderData($request) {
        try {
            $imageType = Config::get('constants.imageType');
            $attributeId = $request->input('attribute_id', 0);
            $attributeType = Config::get('constants.attributeType');
            if ($attributeId > 0) {
                $healthData = MasterHealthDataByType::where('attribute_id', $attributeId)->first();
            } else {
                $healthData = new MasterHealthDataByType();
            }
            $healthData->name = $request->input('name');
            $healthData->type = $attributeType['healthProvider'];
            $healthData->description = $request->input('description');
            $healthData->website = $request->input('website');
            $healthData->email = $request->input('email');
            $healthData->phone = $request->input('phone');
            $healthData->closing_day = $request->input('closing_day');
            $healthData->opening_hrs = $request->input('opening_hrs');
            $healthData->closing_hrs = $request->input('closing_hrs');
            $healthData->delivery = $request->input('delivery');
            $healthData->address = $request->input('address');
            $healthData->lat = $request->input('lat');
            $healthData->lng = $request->input('lng');

            $returnImage = $this->file->upload($request->file('logo'), $imageType['healthDataImagePath']);

            if (!empty($returnImage['image'])) {
                $healthData->logo = $returnImage['image'];
            }

            $healthData->save();
            Session::put('success-message', trans('messages.health_provider_success'));
            return $this->renderSuccess(trans('messages.health_provider_success'));
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * @function getHealthProvider
     * @purpose return health provider data
     * @param type $attributeId
     * @return type
     *
     */
    public function getHealthProvider($attributeId) {
        $data = [];
        $weekArray = Config::get('constants.weekArray');
        $timings = Config::get('constants.timings');
        if (!empty($attributeId)) {
            $data = MasterHealthDataByType::getHealthData($attributeId);
        }
        return view('admin.save_provider', array('healthData' => $data, 'weekArray' => $weekArray, 'timings' => $timings));
    }

    /**
     * @function getHealthInsurance
     * @purpose return health insurance data
     * @param type $attributeId
     * @return type
     *
     */
    public function getHealthInsurance($attributeId) {
        $data = [];
        if (!empty($attributeId)) {
            $data = MasterHealthDataByType::getHealthData($attributeId);
        }
        return view('admin.save_insurance', array('healthData' => $data));
    }

    /**
     * @function postDeleteProviderdata
     * @purpose to delete health provider data
     * @param type $request
     * @return type
     *
     */
    public function postDeleteProviderdata($request) {
        try {
            $inputData = $request['ids'];
            if (MasterHealthDataByType::deleteHealthData($inputData)) {
                Session::put('success-message', trans('messages.provider_deleted_success'));
                return $this->renderSuccess(trans('messages.provider_deleted_success'));
            }
            return $this->renderFailure(trans('messages.provider_deleted_failure'), Response::HTTP_OK);
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * @function postDeleteInsurancedata
     * @purpose to delete health insurance data
     * @param type $request
     * @return type
     *
     */
    public function postDeleteInsurancedata($request) {
        try {
            $inputData = $request['ids'];
            if (MasterHealthDataByType::deleteHealthData($inputData)) {
                Session::put('success-message', trans('messages.insurance_deleted_success'));
                return $this->renderSuccess(trans('messages.insurance_deleted_success'));
            }
            return $this->renderFailure(trans('messages.insurance_deleted_failure'), Response::HTTP_OK);
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * @function postDeleteWorkdata
     * @purpose to delete Work data
     * @param type $request
     * @return type
     *
     */
    public function postDeleteWorkdata($request) {
        try {
            $inputData = $request['ids'];
            if (MasterWorks::deleteWorkData($inputData)) {
                Session::put('success-message', trans('messages.work_deleted_success'));
                return $this->renderSuccess(trans('messages.work_deleted_success'));
            }
            return $this->renderFailure(trans('messages.insurance_deleted_failure'), Response::HTTP_OK);
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * @function postDeleteMerchantData
     * @purpose to delete merchant data
     * @param type $request
     * @return type
     *
     */
    public function postDeleteMerchantData($request) {
        try {
            $inputData = $request['ids'];
            if (MasterMerchant::deleteMerchantData($inputData)) {
                Session::put('success-message', trans('messages.merchant_deleted_success'));
                return $this->renderSuccess(trans('messages.merchant_deleted_success'));
            }
            return $this->renderFailure(trans('messages.insurance_deleted_failure'), Response::HTTP_OK);
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * @function postDeleteEcosystemdata
     * @purpose to delete ecosystem data
     * @param type $request
     * @return type
     *
     */
    public function postDeleteEcosystemdata($request) {
        DB::beginTransaction();
        try {
            $inputData = $request['ids'];
            if (MasterEcosystem::deleteEcosystemData($inputData)) {
                Session::put('success-message', trans('messages.ecosystem_deleted_success'));
                DB::commit();
                return $this->renderSuccess(trans('messages.ecosystem_deleted_success'));
            }
            return $this->renderFailure(trans('messages.ecosystem_deleted_failure'), Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollBack();
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * @function postDeleteEcosystemdata
     * @purpose to delete ecosystem data
     * @param type $request
     * @return type
     *
     */
    public function postChangeEcosystemStatus($request) {
        DB::beginTransaction();
        try {
            $inputData = $request['ids'];
            if (MasterEcosystem::changeEcosystemData($inputData)) {
                Session::put('success-message', trans('messages.ecosystem_status_change_success'));
                DB::commit();
                return $this->renderSuccess(trans('messages.ecosystem_status_change_success'));
            }
            return $this->renderFailure(trans('messages.ecosystem_deleted_failure'), Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollBack();
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * @function postDeleteRewarddata
     * @purpose to delete Reward data
     * @param type $request
     * @return type
     *
     */
    public function postDeleteRewarddata($request) {
        try {
            $inputData = $request['ids'];
            MasterReward::deleteRewardData($inputData);
            Session::put('success-message', trans('messages.rewards_deactivated_successfully'));
            return $this->renderSuccess(trans('messages.rewards_deactivated_successfully'));
            return $this->renderFailure(trans('messages.insurance_deleted_failure'), Response::HTTP_OK);
        } catch (\Exception $e) {
            UtilityHelper::logExceptionWithObject(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * @function postRestoreRewardData
     * @purpose to restore Reward data
     * @param type $request
     * @return type
     *
     */
    public function postRestoreRewardData($request) {
        try {
            $inputData = $request['ids'];
            MasterReward::restoreRewardData($inputData);
            Session::put('success-message', trans('messages.rewards_activated_successfully'));
            return $this->renderSuccess(trans('messages.rewards_activated_successfully'));
        } catch (\Exception $e) {
            UtilityHelper::logExceptionWithObject(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * @function postDeleteGymdata
     * @purpose to delete Gym data
     * @param type $request
     * @return type
     *
     */
    public function postDeleteGymdata($request) {
        try {
            $inputData = $request['ids'];
            if (MasterGym::deleteGymData($inputData)) {
                Session::put('success-message', trans('messages.gym_deleted_success'));
                return $this->renderSuccess(trans('messages.gym_deleted_success'));
            }
            return $this->renderFailure(trans('messages.gym_delete_failed'), Response::HTTP_OK);
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * @function getReportedIssue
     * @purpose to return reported issue page
     * @param type null
     * @return type
     *
     */
    public function getReportedIssue() {
        return view('admin.reported_issue');
    }

    /**
     * @function getReportedIssueData
     * @purpose to fetch reported issue from database
     * @param type null
     * @return type
     *
     */
    public function getReportedIssueData() {
        try {
            $results = ReportIssue::with(['reportedissueuser', 'reportedissuedetail'])->get();

            return Yajra\Datatables\Datatables::of($results)
                            ->editColumn('issue_id', function ($model) {
                                return !empty($model->reportedissueuser['last_name']) ? $model->reportedissueuser['first_name'] . ' ' . $model->reportedissueuser['last_name'] : $model->reportedissueuser['first_name'];
                            })
                            ->editColumn('user_id', function ($model) {
                                return $model->reportedissuedetail['issue'];
                            })
                            ->editColumn('created_at', function ($model) {
                                return UtilityHelper::formatDate($model->created_at);
                            })
                            ->make(true);
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * @function getRatingListing
     * @purpose to fetch rating list page
     * @param type null
     * @return type
     *
     */
    public function getRatingListing() {
        return view('admin.rating_listing');
    }

    /**
     * @function getRatingListingData
     * @purpose to fetch rating issue from database
     * @param type null
     * @return type
     *
     */
    public function getRatingListingData($request) {
        try {
            $fromDate = $request->get('fromDate');
            $toDate = $request->get('toDate');
            $results = UserFeedback::with(['userinfo', 'expertinfo'])->whereBetween(DB::raw("DATE(created_at)"), [$fromDate, $toDate])->get();

            return Yajra\Datatables\Datatables::of($results)
                            ->editColumn('user_id', function ($model) {
                                return !empty($model->userinfo['last_name']) ? $model->userinfo['first_name'] . ' ' . $model->userinfo['last_name'] : $model->reportedissueuser['first_name'];
                            })
                            ->editColumn('expert_id', function ($model) {
                                return !empty($model->expertinfo['last_name']) ? $model->expertinfo['first_name'] . ' ' . $model->expertinfo['last_name'] : $model->expertinfo['first_name'];
                            })
                            ->editColumn('created_at', function ($model) {
                                return UtilityHelper::formatDate($model->created_at);
                            })
                            ->make(true);
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * @function getHelpListing
     * @purpose to fetch help listing page
     * @return type
     *
     */
    public function getHelpListing() {
        return view('admin.get_help_listing');
    }

    /**
     * @function getHelpListingData
     * @purpose to fetch help listing data
     * @param type $request
     * @return type
     *
     */
    public function getHelpListingData($request) {
        try {
            $fromDate = $request->get('fromDate');
            $toDate = $request->get('toDate');
            UtilityHelper::putSession('fromDate', $fromDate);
            UtilityHelper::putSession('toDate', $toDate);
            $results = GetHelp::with('userinfo')->whereBetween(DB::raw("DATE(created_at)"), [$fromDate, $toDate])->get();
            return Yajra\Datatables\Datatables::of($results)
                            ->editColumn('user_id', function ($model) {
                                return !empty($model->userinfo['last_name']) ? $model->userinfo['first_name'] . ' ' . $model->userinfo['last_name'] : $model->reportedissueuser['first_name'];
                            })
                            ->make(true);
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * @function getUserProviderListing
     * @purpose to fetch user interested in health provider page
     * @param type null
     * @return type
     *
     */
    public function getUserProviderListing() {
        return view('admin.user_providers_interest');
    }

    /**
     * @function getUserProviderListingData
     * @purpose to fetch user interested in health provider by date
     * @param type $request
     * @return type
     *
     */
    public function getUserProviderListingData($request) {
        try {
            $fromDate = $request->get('fromDate');
            $toDate = $request->get('toDate');
            $fromDate = $fromDate . " 00:00:00";
            $toDate = $toDate . " 23:59:59";
            UtilityHelper::putSession('fromDate', $fromDate);
            UtilityHelper::putSession('toDate', $toDate);
            $results = UserHealthProvider::join('master_health_providers_insurances', 'master_health_providers_insurances.attribute_id', '=', 'user_health_provider_insurance.attribute_id')
                            ->select('users.email', 'users.first_name', 'users.last_name', 'master_health_providers_insurances.name', 'user_health_provider_insurance.*')
                            ->leftjoin('users', 'users.user_id', '=', 'user_health_provider_insurance.user_id')
                            ->where('master_health_providers_insurances.type', Config::get('constants.attributeType.healthProvider'))
                            ->whereBetween("user_health_provider_insurance.created_at", [$fromDate, $toDate])->get();
            return Yajra\Datatables\Datatables::of($results)
                            ->editColumn('user_id', function ($model) {
                                return !empty($model->last_name) ? $model->first_name . ' ' . $model->last_name : $model->first_name;
                            })
                            ->editColumn('attribute_id', function ($model) {
                                return !empty($model->name) ? $model->name : '';
                            })
                            ->editColumn('created_at', function ($model) {
                                return UtilityHelper::formatDate($model->created_at);
                            })
                            ->make(true);
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    public function getUserInsuranceListing() {
        return view('admin.user_insurances_interest');
    }

    /**
     * @function getUserInsuranceListingData
     * @purpose to fetch user interested in health insurance by date
     * @param type $request
     * @return type
     *
     */
    public function getUserInsuranceListingData($request) {
        try {
            $fromDate = $request->get('fromDate');
            $toDate = $request->get('toDate');
            $fromDate = $fromDate . " 00:00:00";
            $toDate = $toDate . " 23:59:59";

            UtilityHelper::putSession('fromDate', $fromDate);
            UtilityHelper::putSession('toDate', $toDate);


            $results = UserHealthProvider::join('master_health_providers_insurances', 'master_health_providers_insurances.attribute_id', '=', 'user_health_provider_insurance.attribute_id')
                            ->select('users.email', 'users.first_name', 'users.last_name', 'master_health_providers_insurances.name', 'user_health_provider_insurance.*')
                            ->leftjoin('users', 'users.user_id', '=', 'user_health_provider_insurance.user_id')
                            ->where('master_health_providers_insurances.type', Config::get('constants.attributeType.healthInsurance'))
                            ->whereBetween("user_health_provider_insurance.created_at", [$fromDate, $toDate])->get();

            return Yajra\Datatables\Datatables::of($results)
                            ->editColumn('user_id', function ($model) {
                                return !empty($model->last_name) ? $model->first_name . ' ' . $model->last_name : $model->first_name;
                            })
                            ->editColumn('attribute_id', function ($model) {
                                return !empty($model->name) ? $model->name : '';
                            })
                            ->editColumn('created_at', function ($model) {
                                return UtilityHelper::formatDate($model->created_at);
                            })
                            ->make(true);
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * @function getCSVDownload
     * @purpose to export page as csv
     * @param type $type
     * @param type $request
     *
     */
    public function getCSVDownload($type, $request) {
        try {
            $from = UtilityHelper::getSession('fromDate');
            $to = UtilityHelper::getSession('toDate');

            $data = $results = $results = UserHealthProvider::join('master_health_providers_insurances', 'master_health_providers_insurances.attribute_id', '=', 'user_health_provider_insurance.attribute_id')
                            ->select('users.email', 'users.first_name', 'users.last_name', 'master_health_providers_insurances.name', 'user_health_provider_insurance.*')
                            ->leftjoin('users', 'users.user_id', '=', 'user_health_provider_insurance.user_id')
                            ->where('master_health_providers_insurances.type', $type)
                            ->whereBetween("user_health_provider_insurance.created_at", [$from, $to])->get();

            $healthDataArray = [];

            foreach ($data as $d) {
                $healthDataArray[] = array('userName' => !empty($d['last_name']) ? $d['first_name'] . ' ' . $d['last_name'] : $d['first_name'],
                    'email' => $d['email'],
                );
            }
            $columnNames = Config::get('constants.healthDataHeaders');
            $fileName = $type == Config::get('constants.attributeType.healthInsurance') ? 'healthInsurance' : 'healthProvider';
            \Maatwebsite\Excel\Facades\Excel::create($fileName, function($excel) use ($healthDataArray, $from, $to, $columnNames) {
                $excel->sheet('mySheet', function($sheet) use ($healthDataArray, $from, $to, $columnNames) {
                    $sheet->prependRow([
                        'FROM DATE:' . $from . "  " . 'To DATE:' . $to
                    ]);

                    $sheet->freezeFirstRowAndColumn();
                    $sheet->mergeCells('A1:C1');

                    $sheet->appendRow(array_values($columnNames));
                    // getting last row number (the one we already filled and setting it to bold
                    $sheet->row($sheet->getHighestRow(), function ($row) {
                        $row->setFontWeight('bold');
                    });
                    foreach ($healthDataArray as $user) {

                        $sheet->appendRow($user);
                    }
                });
            })->export('csv');
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * @function getTermsCondition
     * @purpose to get terms&condition
     * @param type $type
     * @param \App\Implementers\Request $request
     * 
     */
    public function getTermsCondition() {
        try {
            $settingData = Setting::getData(Config::get('constants.setting.terms'));
            $data = !empty($settingData) ? $settingData['description'] : '';
            return view('admin.setting', ['description' => $data]);
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * @function getAddTermsCondition
     * @purpose add terms&condition
     * @return type
     * 
     */
    public function getAddTermsCondition() {
        $settingData = Setting::getData(Config::get('constants.setting.terms'));
        $introductoryData = Setting::getData(Config::get('constants.setting.introductory'));
        $data = !empty($settingData) ? $settingData['description'] : '';
        $introductory = !empty($introductoryData) ? $introductoryData['description'] : '';
        return view('admin.add_terms_condition', ['description' => $data, 'introductory' => $introductory]);
    }

    /**
     * @function postAddTermsCondition
     * @purpose update db with terms and condition
     * @param type $request
     * 
     */
    public function postAddTermsCondition($request) {
        DB::beginTransaction();
        try {
            Setting::saveData(Config::get('constants.setting.terms'), $request->input('description'));
            Setting::saveData(Config::get('constants.setting.introductory'), $request->input('introductory'));
            $sessionPrice = SessionPrice::updateIntrodctoryPrice($request->input('introductory'));
            DB::commit();
            return $this->renderSuccess(trans('messages.terms_condition_success'));
        } catch (\Exception $e) {
            DB::rollBack();
            UtilityHelper::logExceptionWithObject(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * @function getHealthCategoryData
     * @purpose to get health category data
     * @param Request $request
     * @return data
     *
     */
    public function getHealthCategoryData($request) {
        try {
            $results = MasterHealthCategories::where('deleted_at', Constant::$DELETED_NULL)->orderBy('created_at', 'desc')->get();
            return Yajra\Datatables\Datatables::of($results)->make(true);
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * @function getHealthCategoryListing
     * @purpose to get health category listing
     * @return type
     *
     */
    public function getHealthCategoryListing() {
        return view('admin.health_category_listing');
    }

    /**
     * @function postDeleteHealthCategoryData
     * @purpose to delete health category data
     * @param DeleteHealthCategoryDataRequest $request
     * @return type
     *
     */
    public function postDeleteHealthCategoryData($request) {
        DB::beginTransaction();
        try {
            $inputData = $request['ids'];
            if (MasterHealthCategories::deleteHealthCategoryData($inputData)) {
                DB::commit();
                Session::put('success-message', trans('messages.health_category_deleted_success'));
                return $this->renderSuccess(trans('messages.health_category_deleted_success'));
            }
            return $this->renderFailure(trans('messages.gym_delete_failed'), Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollBack();
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    /**
     * @function getHealthCategory
     * @purpose return Category data
     * @param type $workId
     * @return type
     *
     */
    public function getHealthCategory($healthCategoryId) {
        $data = [];
        if (!empty($healthCategoryId)) {
            $data = MasterHealthCategories::getHealthCategoryData($healthCategoryId);
        }
        return view('admin.save_health_category', array('healthCategoryData' => $data));
    }

    /**
     * @function postSaveHealthCategoryData
     * @purpose save and edit work data
     * @param type $request
     * @return type
     *
     */
    public function postSaveHealthCategoryData($request) {
        try {
            $categoryId = $request->input('category_id', 0);
            if ($categoryId > 0) {
                $healthCategoryData = MasterHealthCategories::where('category_id', $categoryId)->first();
            } else {
                $healthCategoryData = new MasterHealthCategories();
            }
            $healthCategoryData->name = $request->input('name');
            $healthCategoryData->save();
            Session::put('success-message', trans('messages.health_category_success'));
            return $this->renderSuccess(trans('messages.health_category_success'));
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

    public function getDownloadQualificationImage($id) {
        try {
            $image_path = ExpertQualification::getQulificationImageUrl($id);
            $file = $image_path[0]->qualification_image;
            header('Content-type: image/jpeg');
            header('Content-Disposition: attachment; filename="qulification.jpeg"');
            readfile($file);
        } catch (\Exception $e) {
            UtilityHelper::logException(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }

}
