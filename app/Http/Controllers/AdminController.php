<?php

namespace App\Http\Controllers;

use App\Contracts\AdminContract;
use App\Http\Requests\Admin\ChangePasswordRequest;
use App\Http\Requests\Admin\CsvRequest;
use App\Http\Requests\Admin\DeleteActivationCodeRequest;
use App\Http\Requests\Admin\DeleteUserRequest;
use App\Http\Requests\Admin\ExpertUserRequest;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\InsuranceRequestData;
use App\Http\Requests\Admin\ProviderRequestData;
use App\Http\Requests\Admin\DeleteHealthDataRequest;
use App\Http\Requests\Admin\DeleteWorkDataRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\TermsConditionRequest;
use App\Http\Requests\Admin\WorkRequestData;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Admin\DeleteGymDataRequest;
use App\Http\Requests\Admin\GymRequestData;
use App\Http\Requests\Admin\DeleteRewardDataRequest;
use App\Http\Requests\Admin\RestoreRewardDataRequest;
use App\Http\Requests\Admin\RewardRequestData;
use App\Http\Requests\Admin\EcosystemRequestData;
use App\Http\Requests\Admin\DeleteEcosystemDataRequest;
use App\Http\Requests\Admin\MerchantRequestData;
use App\Http\Requests\Admin\DeleteMerchantDataRequest;
use App\Http\Requests\Admin\GetRewardByMerchantRequest;
use App\Http\Requests\Admin\DeleteHealthCategoryDataRequest;
use App\Codes\Constant;
use App\Http\Requests\Admin\HealthCategoryRequestData;

class AdminController extends BaseController {

    protected $admin;

    public function __construct(AdminContract $admin) {
        parent::__construct();
        $this->admin = $admin;
        $this->middleware('auth', ['except' => [ 'getForgotPassword', 'postForgotPassword','getWelcome','getTermsCondition']]);
        $this->middleware('xss', ['except' => ['postAddTermsCondition','getAddTermsCondition']]);
        $this->middleware('adminauth', ['except' => ['getImportExcel','postDeleteActivationCode','postImportExcel','getActivationCodeList','getActivationCodeData','postChangePassword','getUserListing','getForgotPassword', 'postForgotPassword','getWelcome','getTermsCondition']]);
    }
    
    public function getWelcome(){
        return view('welcomemessage');
    }

    /**
     * @function getForgotPassword
     * @pupose to get forgot password page
     * @return type
     *
     */
    public function getForgotPassword() {
        if (!Auth::check()) {
            return view('admin.forgot_password');
        } else {
            return redirect('/');
        }
    }

    /**
     * @function postForgotPassword
     * @pupose to post forgot password page
     * @return type
     *
     */
    public function postForgotPassword(Request $request) {
        $result = $this->admin->postForgotPassword($request);
        // if password send
        if ($result === TRUE) {
            Session::put('success_msg',trans('messages.pwd_email_send'));
            return redirect('/')->with('success', trans('messages.pwd_email_send'));
        } else if ($result === \App\Codes\StatusCode::$EMAIL_NOT_EXISTS) { 
            // if email id not found
            return redirect('forgot-password')->with('error', trans('messages.email_not_exists'));
        } else {
            return redirect('forgot-password')->with('error', trans('messages.error.exception')); 
        }
    }

    /**
     * @function getChangePassword
     * @purpose to get change password form
     * @return type
     *
     */
    public function getChangePassword() {
        return view('admin.change_password');
    }

    /**
     * @function postChangePassword
     * @purpose to post change password data
     * @param ChangePasswordRequest $request
     * @return type
     *
     */
    public function postChangePassword(ChangePasswordRequest $request) {
        return $this->admin->postChangePassword($request);
    }

    /**
     * @function getImportExcel
     * @purpose to get import csv form
     * @return type
     *
     */
    public function getImportExcel($id) {
        return view('admin.import_excel',array('id'=>$id));
    }

    /**
     * @function postImportExcel
     * @purpose to post import csv form
     * @param CsvRequest $request
     * @return type
     *
     */
    public function postImportExcel(CsvRequest $request) {

        return $this->admin->postImportExcel($request);
    }

    /**
     * @function getActivationCodeList
     * @purpose to get activation code list page
     * @return type
     *
     */
    public function getActivationCodeList($id) {
        if(Auth::user()->user_type == Constant::$SUB_ADMIN){
            $ecoSystem = Auth::user()->subAdminEcosystem()->first();
            if($id != $ecoSystem['ecosystem_id']){
                die('Not Authorized');
            }
        }
        return $this->admin->getActivationCodeList($id);
    }

    /**
     * @function getActivationCodeData
     * @purpose to get activation code list data from database
     * @return type
     *
     */
    public function getActivationCodeData($id) {
        return $this->admin->getActivationCodeData($id);
    }

    /**
     * @function postDeleteActivationCode
     * @purpose to change status of  activation code
     * @param DeleteActivationCodeRequest $request
     * @return type
     *
     */
    public function postDeleteActivationCode(DeleteActivationCodeRequest $request) {
        return $this->admin->postDeleteActivationCode($request);
    }

    /**
     * @function getUserListing
     * @purpose to get user listing
     * @return type
     *
     */
    public function getUserListing() {
        if(Auth::user()->user_type == Constant::$SUB_ADMIN){
            $ecoSystem = Auth::user()->subAdminEcosystem()->first();
            return redirect('code-listing/'.$ecoSystem['ecosystem_id']);
        }
        return $this->admin->getUserListing();
    }

    /**
     * @function getUserData
     * @purpose to get user data
     * @param Request $request
     * @return type
     *
     */
    public function getUserData(Request $request) {

        return $this->admin->getUserData($request);
    }

    /**
     * @function getUserDetail
     * @purpose to get user detail
     * @param Request $request
     * @param type $id
     * @return type
     *
     *
     */
    public function getUserDetail($id) {

        return $this->admin->getUserDetail($id);
    }

    /**
     * @function postDeleteUser
     * @purpose to delete user
     * @param DeleteUserRequest $request
     * @return type
     *
     */
    public function postDeleteUser(DeleteUserRequest $request) {
        return $this->admin->postDeleteUser($request);
    }

    /**
     * @function getUserListing
     * @purpose to get user listing
     * @return type
     *
     */
    public function getGymListing() {
        return $this->admin->getGymListing();
    }

    /**
     * @function getUserData
     * @purpose to get user data
     * @param Request $request
     * @return type
     *
     */
    public function getGymData(Request $request) {

        return $this->admin->getGymData($request);
    }
    
    /**
     * @function postApproveExpert
     * @purpose approve expert request
     * @param ExpertUserRequest $request
     * @return type
     *
     */
    public function postApproveExpert(ExpertUserRequest $request) {
        return $this->admin->postApproveExpert($request);
    }

    /**
     * @function postDisapproveExpert
     * @purpose to dispprove expert request
     * @param ExpertUserRequest $request
     * @return type
     *
     */
    public function postDisapproveExpert(ExpertUserRequest $request) {
        return $this->admin->postDisapproveExpert($request);
    }

    /**
     * @function getProviderListing
     * @purpose to get health provider listing page
     * @return type
     *
     */
    public function getProviderListing() {
        return $this->admin->getProviderListing();
    }

    /**
     * @function getProviderData
     * @purpose to fetch health provider data from database
     * @param Request $request
     * @return type
     *
     */
    public function getProviderData() {

        return $this->admin->getProviderData();
    }
    
    /**
     * @function getWorkListing
     * @purpose to get work listing page
     * @return type
     *
     */
    public function getWorkListing() {
        return $this->admin->getWorkListing();
    }
    
    /**
     * @function getMerchantListing
     * @purpose to get merchant listing page
     * @return type
     *
     */
    public function getMerchantListing() {
        return $this->admin->getMerchantListing();
    }
    
    /**
     * @function getMerchantData
     * @purpose to get merchant data
     * @return type
     *
     */
    public function getMerchantData() {

        return $this->admin->getMerchantData();
    }
    
    /**
     * @function getWorkData
     * @purpose to get work data
     * @return type
     *
     */
    public function getWorkData() {

        return $this->admin->getWorkData();
    }
    
    /**
     * @function getEcosystemListing
     * @purpose to get ecosystems listing page
     * @return type
     *
     */
    public function getEcosystemListing() {
        return $this->admin->getEcosystemListing();
    }
    
    /**
     * @function getEcosystemData
     * @purpose to get ecosystem data
     * @return type
     *
     */
    public function getEcosystemData() {

        return $this->admin->getEcosystemData();
    }
    
    /**
     * @function getRewardListing
     * @purpose to get reward listing page
     * @return type
     *
     */
    public function getRewardListing() {
        return $this->admin->getRewardListing();
    }
    
    /**
     * @function getRewardByMerchant
     * @purpose to get reward listing by merchant
     * @return type
     *
     */
    public function getRewardByMerchant(GetRewardByMerchantRequest $request) {
        return $this->admin->getRewardByMerchant($request);
    }

    /**
     * @function getRewardData
     * @purpose to get reward data
     * @return type
     *
     */
    public function getRewardData() {

        return $this->admin->getRewardData();
    }

    /**
     * @function getInsuranceListing
     * @purpose to get health insurance listing page
     * @return type
     *
     */
    public function getInsuranceListing() {
        return $this->admin->getInsuranceListing();
    }

    /**
     * @function getInsuranceData
     * @purpose to get health insurance data
     * @return type
     *
     */
    public function getInsuranceData() {

        return $this->admin->getInsuranceData();
    }

    /**
     * @function getHealthProvider
     * @purpose to get health provider data
     * @param Request $request
     * @return type
     *
     */
    public function getHealthProvider(Request $request) {
        if (!empty($request->get('id'))) {
            $attributeId = $request->get('id');
        } else {
            $attributeId = '';
        }
        return $this->admin->getHealthProvider($attributeId);
    }

    /**
     * @function getHealthInsurance
     * @purpose to get health insurance data
     * @param Request $request
     * @return type
     *
     */
    public function getHealthInsurance(Request $request) {
        if (!empty($request->get('id'))) {
            $attributeId = $request->get('id');
        } else {
            $attributeId = '';
        }
        return $this->admin->getHealthInsurance($attributeId);
    }
    
    
    /**
     * @function getWork
     * @purpose to get work data
     * @param Request $request
     * @return type
     *
     */
    public function getWork(Request $request) {
        if (!empty($request->get('id'))) {
            $workId = $request->get('id');
        } else {
            $workId = '';
        }
        return $this->admin->getWork($workId);
    }
    
    /**
     * @function getMerchant
     * @purpose to get merchant data
     * @param Request $request
     * @return type
     *
     */
    public function getMerchant(Request $request) {
        if (!empty($request->get('id'))) {
            $merchantId = $request->get('id');
        } else {
            $merchantId = '';
        }
        return $this->admin->getMerchant($merchantId);
    }
    
    
    /**
     * @function getEcosystem
     * @purpose to get ecosystem data
     * @param Request $request
     * @return type
     *
     */
    public function getEcosystem(Request $request) {
        if (!empty($request->get('id'))) {
            $ecosystemId = $request->get('id');
        } else {
            $ecosystemId = '';
        }
        return $this->admin->getEcosystem($ecosystemId);
    }
    
    /**
     * @function getReward
     * @purpose to get reward data
     * @param Request $request
     * @return type
     *
     */
    public function getReward(Request $request) {
        if (!empty($request->get('id'))) {
            $rewardId = $request->get('id');
        } else {
            $rewardId = '';
        }
        return $this->admin->getReward($rewardId);
    }
    
    
    public function getGym(Request $request) {
        if (!empty($request->get('id'))) {
            $gymId = $request->get('id');
        } else {
            $gymId = '';
        }
        
        return $this->admin->getGym($gymId);
    }
    
    /**
     * @function postSaveWorkData
     * @purpose to save/update work data
     * @param WorkRequestData $request
     * @return type
     *
     */
    public function postSaveWorkData(WorkRequestData $request) {

        return $this->admin->postSaveWorkData($request);
    }
    
    /**
     * @function postSaveMerchantData
     * @purpose to save/update merchant data
     * @param MerchantRequestData $request
     * @return type
     *
     */
    public function postSaveMerchantData(MerchantRequestData $request) {

        return $this->admin->postSaveMerchantData($request);
    }
    
    /**
     * @function postSaveEcosystemData
     * @purpose to save/update ecosystem data
     * @param EcosystemRequestData $request
     * @return type
     *
     */
    public function postSaveEcosystemData(EcosystemRequestData $request) {

        return $this->admin->postSaveEcosystemData($request);
    }
    
    /**
     * @function postSaveRewardData
     * @purpose to save/update work data
     * @param WorkRequestData $request
     * @return type
     *
     */
    public function postSaveRewardData(RewardRequestData $request) {

        return $this->admin->postSaveRewardData($request);
    }
    
    /**
     * @function postSaveGymData
     * @purpose to save/update gym data
     * @param GymRequestData $request
     * @return type
     *
     */
    public function postSaveGymData(GymRequestData $request) {
        return $this->admin->postSaveGymData($request);
    }

    /**
     * @function postSaveInsuranceData
     * @purpose to save/update health insurance data
     * @param InsuranceRequestData $request
     * @return type
     *
     */
    public function postSaveInsuranceData(InsuranceRequestData $request) {

        return $this->admin->postSaveInsuranceData($request);
    }

    /**
     * @function postSaveProviderData
     * @purpose to save/update health provider data
     * @param ProviderRequestData $request
     * @return type
     *
     */
    public function postSaveProviderData(ProviderRequestData $request) {

        return $this->admin->postSaveProviderData($request);
    }

    /**
     * @function postDeleteProviderdata
     * @purpose to delete health provider data
     * @param DeleteHealthDataRequest $request
     * @return type
     *
     */
    public function postDeleteProviderdata(DeleteHealthDataRequest $request) {
        return $this->admin->postDeleteProviderdata($request);
    }

    /**
     * @function postDeleteInsurancedata
     * @purpose to delete health insurance data
     * @param DeleteHealthDataRequest $request
     * @return type
     *
     */
    public function postDeleteInsurancedata(DeleteHealthDataRequest $request) {
        return $this->admin->postDeleteInsurancedata($request);
    }
    
    /**
     * @function postDeleteWorkdata
     * @purpose to delete work data
     * @param DeleteWorkDataRequest $request
     * @return type
     *
     */
    public function postDeleteWorkdata(DeleteWorkDataRequest $request) {
        return $this->admin->postDeleteWorkdata($request);
    }
    
    /**
     * @function postDeleteMerchantData
     * @purpose to delete merchant data
     * @param DeleteMerchantDataRequest $request
     * @return type
     *
     */
    public function postDeleteMerchantData(DeleteMerchantDataRequest $request) {
        return $this->admin->postDeleteMerchantData($request);
    }
    
    
    /**
     * @function postDeleteEcosystemData
     * @purpose to delete Ecosystem data
     * @param DeleteWorkDataRequest $request
     * @return type
     *
     */
    public function postDeleteEcosystemData(DeleteEcosystemDataRequest $request) {
        return $this->admin->postDeleteEcosystemdata($request);
    }
    
    /**
     * @function postDeleteEcosystemData
     * @purpose to delete Ecosystem data
     * @param DeleteWorkDataRequest $request
     * @return type
     *
     */
    public function postChangeEcosystemStatus(DeleteEcosystemDataRequest $request) {
        return $this->admin->postChangeEcosystemStatus($request);
    }
    
    /**
     * @function postDeleteRewardData
     * @purpose to delete reward data
     * @param DeleteRewardDataRequest $request
     * @return type
     *
     */
    public function postDeleteRewardData(DeleteRewardDataRequest $request) {
        return $this->admin->postDeleteRewardData($request);
    }
    
    /**
     * @function postRestoreRewardData
     * @purpose to restore reward data
     * @param RestoreRewardDataRequest $request
     * @return type
     *
     */
    public function postRestoreRewardData(RestoreRewardDataRequest $request) {
        return $this->admin->postRestoreRewardData($request);
    }
    
    /**
     * @function postDeleteGymdata
     * @purpose to delete gym data
     * @param DeleteGymDataRequest $request
     * @return type
     *
     */
    public function postDeleteGymdata(DeleteGymDataRequest $request) {
        return $this->admin->postDeleteGymdata($request);
    }

    /**
     * @function getReportedIssue
     * @purpose to get reported issue page
     * @return type
     *
     */
    public function getReportedIssue() {
        return $this->admin->getReportedIssue();
    }

    /**
     * @function getReportedIssueData
     * @purpose to fetch reported issue from database
     * @return type
     *
     */
    public function getReportedIssueData() {

        return $this->admin->getReportedIssueData();
    }

    /**
     * @function getRatingListing
     * @purpose to get rating list page
     * @return type
     *
     */
    public function getRatingListing() {
        return $this->admin->getRatingListing();
    }

    /**
     * @function getRatingListingData
     * @purpose to get rating list from database
     * @param Request $request
     * @return type
     *
     */
    public function getRatingListingData(Request $request) {

        return $this->admin->getRatingListingData($request);
    }

    /**
     * @function getHelpListing
     * @purpose to get help listing page
     * @return type
     *
     */
    public function getHelpListing() {
        return $this->admin->getHelpListing();
    }

    /**
     * @function getHelpListingData
     * @purpose to get help listing data from database
     * @param Request $request
     * @return type
     *
     */
    public function getHelpListingData(Request $request) {

        return $this->admin->getHelpListingData($request);
    }

    /**
     * @function getUserProviderListing
     * @purpose to return user interestedhealth provider report
     * @return type
     *
     */
    public function getUserProviderListing() {
        return $this->admin->getUserProviderListing();
    }

    /**
     * @function getUserProviderListingData
     * @purpose to get user interested in health provider data
     * @param Request $request
     * @return type
     *
     */
    public function getUserProviderListingData(Request $request) {

        return $this->admin->getUserProviderListingData($request);
    }

    /**
     * @function getUserInsuranceListing
     * @purpose to return user interestedhealth insurance report
     * @return type
     *
     */
    public function getUserInsuranceListing() {
        return $this->admin->getUserInsuranceListing();
    }

    /**
     * @function getUserInsuranceListingData
     * @purpose to get user interested in health insurance data
     * @param Request $request
     * @return type
     *
     */
    public function getUserInsuranceListingData(Request $request) {

        return $this->admin->getUserInsuranceListingData($request);
    }

    /**
     * @function getCSVDownload
     * @purpose to download csv on the basis of type (1= health provider 2=health insurance)
     * @param type $type
     * @param Request $request
     * @return type
     *
     */
    public function getCSVDownload($type, Request $request) {
        return $this->admin->getCSVDownload($type, $request);
    }
    /**
     * @function getTermsCondition
     * @purpose to get terms & condition
     * @param type $type
     * @param Request $request
     * @return type
     * 
     */
    public function getTermsCondition(){
        return $this->admin->getTermsCondition();
    }
    /**
     * @function getAddTermsCondition
     * @purpose to add terms & condition
     * @param type $type
     * @param Request $request
     * @return type
     * 
     */
    public function getAddTermsCondition(){
        return $this->admin->getAddTermsCondition();
    }
    
    public function postAddTermsCondition(TermsConditionRequest $request){
     
        return $this->admin->postAddTermsCondition($request);
    }
    

    /**
     * @function getHealthCategoryListing
     * @purpose to get health category listing
     * @return type
     *
     */
    public function getHealthCategoryListing() {
        return $this->admin->getHealthCategoryListing();
    }

    /**
     * @function getHealthCategoryData
     * @purpose to get health category data
     * @param Request $request
     * @return data
     *
     */
    public function getHealthCategoryData(Request $request) {

        return $this->admin->getHealthCategoryData($request);
    }
    
    /**
     * @function postDeleteHealthCategoryData
     * @purpose to delete health category data
     * @param DeleteHealthCategoryDataRequest $request
     * @return type
     *
     */
    public function postDeleteHealthCategoryData(DeleteHealthCategoryDataRequest $request) {
        return $this->admin->postDeleteHealthCategoryData($request);
    }
    
    /**
     * @function getHealthCategory
     * @purpose to get work data
     * @param Request $request
     * @return type
     *
     */
    public function getHealthCategory(Request $request) {
        if (!empty($request->get('id'))) {
            $healthCategoryId = $request->get('id');
        } else {
            $healthCategoryId = '';
        }
        return $this->admin->getHealthCategory($healthCategoryId);
    }
    
    /**
     * @function postSaveWorkData
     * @purpose to save/update work data
     * @param WorkRequestData $request
     * @return type
     *
     */
    public function postSaveHealthCategoryData(HealthCategoryRequestData $request) {

        return $this->admin->postSaveHealthCategoryData($request);
    } 
    public function getDownloadQualificationImage($request) {

        return $this->admin->getDownloadQualificationImage($request);
    }
}
