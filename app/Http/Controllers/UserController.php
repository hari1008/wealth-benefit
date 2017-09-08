<?php

/*
 * File: UserController.php
 */

namespace App\Http\Controllers;

use App\Contracts\UserContract;
use Illuminate\Http\Request;
use App\Http\Requests\User\SignUpRequest;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\CheckActivationCodeRequest;
use App\Http\Requests\User\SignInRequest;
use App\Http\Requests\User\ForgotPasswordRequest;
use App\Http\Requests\User\ExpertProfileRequest;
use App\Http\Requests\User\UpdateActivationCodeRequest;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Http\Requests\User\ExpertCalendarRequest;
use App\Http\Requests\User\WellnessAnswerRequest;
use App\Http\Requests\User\ExpertHealthCategoryRequest;
use App\Helper\Utility\CommonHelper;
use App\Http\Requests\User\SearchExpertRequest;
use App\Http\Requests\User\ViewExpertRequest;
use App\Http\Requests\User\HelpRequest;
use App\Http\Requests\User\ExpertCalendarDeleteRequest;
use App\Http\Requests\User\ImageRequest;
use App\Http\Requests\User\SendActivationRequest;

class UserController extends BaseController {
    protected $user;
    public function __construct(UserContract $user) {
        parent::__construct();
        $this->user =$user;
        $this->middleware('jsonvalidate',['except' => ['putSignOut','getExpertCalendarSlots','getUserNotifications','getCheckCode',
            'viewVerifyEmail','postUserImages','getListRecievedInvitationUser','getListSentInvitationUser','getCountUserWellnessAge',
            'getinputStatus','getFindExpert','getViewExpert','getSendNotitifcation','getUserProfile','postExpertHealthCategory',
            'getUserAvailability','getUserGoalsInfo','putRemoveExpertProfile']]);
   }
    
    /**
        * 
        * Does sign up of the users and sending a verification mail to their mail Id 
        * 
        * @param $request it contains all the value given for Sign Up
        * 
        * @throws Exception If something happens during the process
        * 
        * @return Inserted user object if everything went right
        * 
    */ 
    public function postSignUpUser(SignUpRequest $request) {
        return $this->user->postSignUp($request);
    }
    
    /**
        * 
        * Does profile update of expert
        * 
        * @param $request which contains information of expert to update
        * 
        * @throws Exception If something happens during the process
        * 
        * @return user object with success if updated successfully otherwise failure 
        * 
    */
    public function putExpertProfile(ExpertProfileRequest $request) {
        return $this->user->putExpertProfile($request);
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
    public function getUserProfile() {
        return $this->user->getProfile();
    }
    
    public function putRemoveExpertProfile() {
        return $this->user->putRemoveExpertProfile();
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
    public function getUserAvailability(Request $request) {
        return $this->user->getProfileWithAvailability($request); 
    }
    
    public function getUserGoalsInfo(Request $request) {
        return $this->user->getUserWithGoals($request); 
    }
    
    /**
        * 
        * Provide list of experts according to searched parameters
        * 
        * @param $request contains parameters on which search has to be taken place
        * 
        * @throws Exception If something happens during the process
        * 
        * @return user(expert) objects with success if every thing went right otherwise failure 
        * 
    */
    public function getFindExpert(SearchExpertRequest $request) {
        return $this->user->getExpertList($request);
    }
    
    /**
        * 
        * Provide detailed information of expert
        * 
        * @param $request contains expert_id to find detailed information of expert
        * 
        * @throws Exception If something happens during the process
        * 
        * @return user(expert) object with success if every thing went right otherwise failure 
        * 
    */
    public function getViewExpert(ViewExpertRequest $request) {
        return $this->user->getExpertInfo($request);
    }
    
    /**
        * 
        * Does password change
        * 
        * @param $request which contains current and new password
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success if successfully changed otherwise failure 
        * 
    */
    public function putChangePassword(ChangePasswordRequest $request) {
        return $this->user->putChangePassword($request);
    }
    
    /**
        * 
        * Does profile update of User
        * 
        * @param $request which contains information of user to update
        * 
        * @throws Exception If something happens during the process
        * 
        * @return user object with success if updated successfully otherwise failure 
        * 
    */
    public function putUpdateProfileUser(UpdateProfileRequest $request) {
        return $this->user->postUpdateProfile($request);
    }
    
    /**
        * 
        * Update Activation code with respect to the logged in user and also update the status of activation to used
        * 
        * @param $request which contains information of activation code and user type to which we need to update activation code
        * 
        * @throws Exception If something happens during the process
        * 
        * @return user object with success if updated successfully otherwise failure 
        * 
    */
    public function putUpdateActivationCodeUser(UpdateActivationCodeRequest $request) {

        return $this->user->postUpdateActivationCode($request);
    }
    
    /**
        * 
        * Does creation of available slots for expert
        * 
        * @param $request contains information to create availability calender of expert
        * 
        * @throws Exception If something happens during the process
        * 
        * @return days objects with success if every thing went right otherwise failure 
        * 
    */
    public function postCreateCalendarExpert(ExpertCalendarRequest $request) {
        
        return $this->user->postCreateCalendar($request);
    }
    
    /**
        * 
        * Does deletion of available slots for expert
        * 
        * @param $request contains information to delete available slots of expert
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success if deleted successfully otherwise failure 
        * 
    */
    public function deleteExpertCalendarSlot(ExpertCalendarDeleteRequest $request) {
        
        return $this->user->deleteCalendarSlot($request);
    }
    
    /**
        * 
        * Provide list of available and booked slots for expert
        * 
        * @param $request contains information about date for available slots of expert
        * 
        * @throws Exception If something wrong happens during the process
        * 
        * @return objects of booked and available slots
        * 
    */
    public function getExpertCalendarSlots(Request $request) {
        
        return $this->user->getCalendarSlots($request);
    }
    
    /**
        * 
        * Update wellness age answers and find wellness age according to them
        * 
        * @param $request which contains information about issue faced by the user
        * 
        * @throws Exception If something happens during the process
        * 
        * @return user object with success if updated successfully otherwise failure 
        * 
    */
    public function putUpdateWellnessAnswerUser(WellnessAnswerRequest $request) {
       
        return $this->user->putUpdateWellnessAnswer($request);
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
        return  $this->user->putSignout(); 
    }
    
    /**
        * 
        * Does checking of activation code status
        * 
        * @param $request which contains the activation code
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success if activation code is valid otherwise failure 
        * 
    */
    public function getCheckCode(CheckActivationCodeRequest $request){
        
        return  $this->user->getCodeStatus($request); 
    }
    
    
    /**
        * 
        * Does sign in of user, also temporary block account if too many wrong attempts
        * 
        * @param $request which contains email , password & facebookId
        * 
        * @throws Exception If something happens during the process
        * 
        * @return user object if email and password is valid otherwise failure 
        * 
    */
    public function postSignInUser(SignInRequest $request) {
        
        return $this->user->postSignIn($request);
    }
    
    /**
        * 
        * Does mail when user forgot their password 
        * 
        * @param $request which contains email of user
        * 
        * @throws Exception If something happens during the process
        * 
        * @return user object with success if mail with link sent successfully otherwise failure 
        * 
    */
    public function putForgotPasswordUser(ForgotPasswordRequest $request) {

        return $this->user->putForgotPassword($request);
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
    public function viewVerifyEmail(Request $request){
          $updatedRow = $this->user->getCheckEmailVerification($request); 
          return view('verifyEmail', ['key' => $updatedRow]);
    }
    
    public function postUserImages(ImageRequest $request) {
        return $this->user->postUserImages($request);
    }
    
    public function postExpertHealthCategory(ExpertHealthCategoryRequest $request){        
        return $this->user->postExpertHeathCategory($request);
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
    public function getSendNotitifcation(Request $request){
        try{
             return $this->user->getSendNotification($request);
        }
        catch(\Exception $e){
             echo $e->getMessage();
        } 
    }
    
    public function getinputStatus(Request $request){
        try{
            echo CommonHelper::scriptStripper("<html>hello</html>");
        }
        catch(\Exception $e){
            echo $e->getMessage();
        }
    }
    
    /**
        * 
        * Send help request to the backend if user need help (limited help request allowed per day)
        * 
        * @param $request contain description of help
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success if help request created successfully otherwise failure
        * 
    */
    public function postHelpUser(HelpRequest $request){
       return $this->user->postHelp($request);
    }
    
    /**
        * 
        * Send help request to the backend if user need help (limited help request allowed per day)
        * 
        * @param $request contain description of help
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success if help request created successfully otherwise failure
        * 
    */
    public function postMailActivationCode(SendActivationRequest $request){
       return $this->user->postMailActivationCode($request);
    }
    
}
