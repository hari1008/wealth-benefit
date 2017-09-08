<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
Route::post('payment', '\App\Http\Controllers\PaymentController@postPaymentDone');
Route::post('response', '\App\Http\Controllers\PaymentController@postResponse');
Route::post('cancel', '\App\Http\Controllers\PaymentController@postCancel');
Route::get('success', '\App\Http\Controllers\PaymentController@postSuccess');
Route::get('failure', '\App\Http\Controllers\PaymentController@postFailure');
Route::get('aborted', '\App\Http\Controllers\PaymentController@postAborted');
Route::post('get-rsa-key', '\App\Http\Controllers\PaymentController@getRSAKey');
Route::get('welcome', '\App\Http\Controllers\AdminController@getWelcome');
Route::get('/', function () { return view('auth.login'); });

  
    Auth::routes();
    Route::get('/', '\App\Http\Controllers\AdminController@getUserListing');
    Route::get('/home', '\App\Http\Controllers\AdminController@getUserListing');
    Route::get('forgot-password', '\App\Http\Controllers\AdminController@getForgotPassword');
    Route::post('forgot-password', '\App\Http\Controllers\AdminController@postForgotPassword');
    Route::get('change-password', '\App\Http\Controllers\AdminController@getChangePassword');
    Route::post('change-password', '\App\Http\Controllers\AdminController@postChangePassword');
    Route::get('import-excel/{id}', '\App\Http\Controllers\AdminController@getImportExcel');
    Route::post('import-excel', '\App\Http\Controllers\AdminController@postImportExcel');
    Route::get('code-data/{id}', '\App\Http\Controllers\AdminController@getActivationCodeData');
    Route::get('code-listing/{id}', '\App\Http\Controllers\AdminController@getActivationCodeList');
    Route::post('delete-activationcode', '\App\Http\Controllers\AdminController@postDeleteActivationCode');
    Route::get('user-listing', '\App\Http\Controllers\AdminController@getUserListing');
    Route::get('user-detail/{id}', '\App\Http\Controllers\AdminController@getUserDetail'); 
    Route::get('download-qualification-image/{id}', '\App\Http\Controllers\AdminController@getDownloadQualificationImage');
    Route::get('user-data', '\App\Http\Controllers\AdminController@getUserData');
    Route::post('delete-user', '\App\Http\Controllers\AdminController@postDeleteUser');
    Route::post('approve', '\App\Http\Controllers\AdminController@postApproveExpert');
    Route::post('disapprove', '\App\Http\Controllers\AdminController@postDisapproveExpert');
    Route::get('provider-listing', '\App\Http\Controllers\AdminController@getProviderListing');
    Route::get('provider-data', '\App\Http\Controllers\AdminController@getProviderData');
    Route::get('insurance-listing', '\App\Http\Controllers\AdminController@getInsuranceListing');
    Route::get('insurance-data', '\App\Http\Controllers\AdminController@getInsuranceData');
    
    Route::get('gym-listing', '\App\Http\Controllers\AdminController@getGymListing');
    Route::get('gym-data', '\App\Http\Controllers\AdminController@getGymData');
    Route::get('gym', '\App\Http\Controllers\AdminController@getGym');
    Route::post('save-gym', '\App\Http\Controllers\AdminController@postSaveGymData');
    Route::post('delete-gym', '\App\Http\Controllers\AdminController@postDeleteGymData');
    
    Route::get('work-listing', '\App\Http\Controllers\AdminController@getWorkListing');
    Route::get('work-data', '\App\Http\Controllers\AdminController@getWorkData');
    Route::get('work', '\App\Http\Controllers\AdminController@getWork');
    Route::post('save-work', '\App\Http\Controllers\AdminController@postSaveWorkData');
    Route::post('delete-work', '\App\Http\Controllers\AdminController@postDeleteWorkData');
    
    Route::get('health-category-listing', '\App\Http\Controllers\AdminController@getHealthCategoryListing');
    Route::get('health-category-data', '\App\Http\Controllers\AdminController@getHealthCategoryData');
    Route::get('health-category', '\App\Http\Controllers\AdminController@getHealthCategory');
    Route::post('save-health-category', '\App\Http\Controllers\AdminController@postSaveHealthCategoryData');
    Route::post('delete-health-category', '\App\Http\Controllers\AdminController@postDeleteHealthCategoryData');
    
    Route::get('ecosystem-listing', '\App\Http\Controllers\AdminController@getEcosystemListing');
    Route::get('my-ecosystem', '\App\Http\Controllers\SubAdminController@getMyEcosystem');
    Route::get('ecosystem-data', '\App\Http\Controllers\AdminController@getEcosystemData');
    Route::get('ecosystem', '\App\Http\Controllers\AdminController@getEcosystem');
    Route::post('save-ecosystem', '\App\Http\Controllers\AdminController@postSaveEcosystemData');
    Route::post('delete-ecosystem', '\App\Http\Controllers\AdminController@postDeleteEcosystemData');
    Route::post('ecosystem-change-status', '\App\Http\Controllers\AdminController@postChangeEcosystemStatus');
    
    Route::get('reward-listing', '\App\Http\Controllers\AdminController@getRewardListing');
    Route::get('reward-data', '\App\Http\Controllers\AdminController@getRewardData');
    Route::get('reward', '\App\Http\Controllers\AdminController@getReward');
    Route::post('save-reward', '\App\Http\Controllers\AdminController@postSaveRewardData');
    Route::post('delete-reward', '\App\Http\Controllers\AdminController@postDeleteRewardData');
    Route::post('restore-reward', '\App\Http\Controllers\AdminController@postRestoreRewardData');
    Route::get('find-reward-by-merchant', '\App\Http\Controllers\AdminController@getRewardByMerchant');
    
    Route::get('merchant-listing', '\App\Http\Controllers\AdminController@getMerchantListing');
    Route::get('merchant-data', '\App\Http\Controllers\AdminController@getMerchantData');
    Route::get('merchant', '\App\Http\Controllers\AdminController@getMerchant');
    Route::post('save-merchant', '\App\Http\Controllers\AdminController@postSaveMerchantData');
    Route::post('delete-merchant', '\App\Http\Controllers\AdminController@postDeleteMerchantData');
    
    Route::get('provider', '\App\Http\Controllers\AdminController@getHealthProvider');
    Route::get('insurance', '\App\Http\Controllers\AdminController@getHealthInsurance');
    Route::post('save-provider', '\App\Http\Controllers\AdminController@postSaveProviderData');
    Route::post('save-insurance', '\App\Http\Controllers\AdminController@postSaveInsuranceData');
    
    Route::post('delete-provider', '\App\Http\Controllers\AdminController@postDeleteInsuranceData');
    Route::post('delete-insurance', '\App\Http\Controllers\AdminController@postDeleteProviderData');
    
    Route::get('reported-issue', '\App\Http\Controllers\AdminController@getReportedIssue');
    Route::get('reported-issue-data', '\App\Http\Controllers\AdminController@getReportedIssueData');
    Route::get('rating-listing', '\App\Http\Controllers\AdminController@getRatingListing');
    Route::get('rating-list-data', '\App\Http\Controllers\AdminController@getRatingListingData');
    
    
    Route::get('get-help-listing', '\App\Http\Controllers\AdminController@getHelpListing');
     
    Route::get('get-help-listing-data', '\App\Http\Controllers\AdminController@getHelpListingData');
    Route::get('user-provider', '\App\Http\Controllers\AdminController@getUserProviderListing');
    Route::get('user-provider-data', '\App\Http\Controllers\AdminController@getUserProviderListingData');
    Route::get('user-insurance', '\App\Http\Controllers\AdminController@getUserInsuranceListing');
    Route::get('user-insurance-data', '\App\Http\Controllers\AdminController@getUserInsuranceListingData');
    Route::get('download/{type}', '\App\Http\Controllers\AdminController@getCSVDownload');
    Route::get('terms-condition/', '\App\Http\Controllers\AdminController@getTermsCondition');
    Route::get('add-terms-condition/', '\App\Http\Controllers\AdminController@getAddTermsCondition');
    Route::post('add-terms-condition/', '\App\Http\Controllers\AdminController@postAddTermsCondition');
    
    
        Route::get('logout', function () {
        Auth::logout();
        Session::flush();
        return redirect('/');
});


Route::get('verify-email','\App\Http\Controllers\UserController@viewVerifyEmail');

