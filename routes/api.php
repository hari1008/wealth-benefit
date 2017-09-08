<?php

//use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(array('middleware'=> 'loginputs'), function(){
Route::get('terms-condition/', '\App\Http\Controllers\PageController@getTermsCondition');
Route::group(['prefix'=>'user/','middleware'=>'apiauth'],function(){       
   Route::put('change-password', '\App\Http\Controllers\UserController@putChangePassword');
   Route::put('sign-out', '\App\Http\Controllers\UserController@putSignOut');
   Route::post('user-image', '\App\Http\Controllers\UserController@postUserImages');
   Route::put('expert-profile', '\App\Http\Controllers\UserController@putExpertProfile');
   Route::put('update-profile', '\App\Http\Controllers\UserController@putUpdateProfileUser');
   Route::put('update-activation-code', '\App\Http\Controllers\UserController@putUpdateActivationCodeUser');
   Route::post('create-expert-calendar', '\App\Http\Controllers\UserController@postCreateCalendarExpert');
   Route::delete('delete-expert-calendar-slot', '\App\Http\Controllers\UserController@deleteExpertCalendarSlot');
   Route::get('expert-calendar-slots', '\App\Http\Controllers\UserController@getExpertCalendarSlots');
   Route::put('update-wellness-answers', '\App\Http\Controllers\UserController@putUpdateWellnessAnswerUser');
   Route::get('search-expert', '\App\Http\Controllers\UserController@getFindExpert');
   Route::get('view-expert', '\App\Http\Controllers\UserController@getViewExpert');
   Route::get('push-notify', '\App\Http\Controllers\UserController@getSendNotitifcation');
   Route::post('expert-update-basic', '\App\Http\Controllers\UserController@postExpertHealthCategory');
   Route::post('help', '\App\Http\Controllers\UserController@postHelpUser');
   Route::get('notifications-list', '\App\Http\Controllers\NotificationController@getUserNotifications');
   Route::get('my-profile', '\App\Http\Controllers\UserController@getUserProfile');
   Route::get('availability', '\App\Http\Controllers\UserController@getUserAvailability');
   Route::get('goals-info', '\App\Http\Controllers\UserController@getUserGoalsInfo');
   Route::get('delete-expert', '\App\Http\Controllers\UserController@putRemoveExpertProfile');
 });
    
 Route::group(['prefix'=>'user/'],function(){ 
 Route::post('send-activation-code', '\App\Http\Controllers\UserController@postMailActivationCode');
 Route::post('sign-up', '\App\Http\Controllers\UserController@postSignUpUser');
 Route::get('check-activation-code', '\App\Http\Controllers\UserController@getCheckCode');
 Route::post('sign-in', '\App\Http\Controllers\UserController@postSignInUser');
 Route::put('forgot-password', '\App\Http\Controllers\UserController@putForgotPasswordUser');
 Route::get('trim-script', '\App\Http\Controllers\UserController@getinputStatus');
});

Route::group(['prefix'=>'health/'],function(){ 
   Route::get('category-list', '\App\Http\Controllers\HealthController@getCategoryList'); 
   Route::get('question-list', '\App\Http\Controllers\HealthController@getQuestionList'); 
});

Route::group(['prefix'=>'device/','middleware'=>'apiauth'],function(){ 
   Route::put('sync-health-device', '\App\Http\Controllers\HealthDeviceController@putSyncUserHealthDevice'); 
   Route::get('health-device-data', '\App\Http\Controllers\HealthDeviceController@getSyncHealthDeviceData');
   Route::get('health-devices-data-yearly', '\App\Http\Controllers\HealthDeviceController@getSyncHealthDeviceDataYearly');
   Route::put('sync-health-devices', '\App\Http\Controllers\HealthDeviceController@putSyncUserHealthDevice1'); 
   Route::get('health-devices-data', '\App\Http\Controllers\HealthDeviceController@getSyncHealthDeviceData1'); 
   Route::get('last-sync', '\App\Http\Controllers\HealthDeviceController@getLastSyncHealthDevice'); 
   Route::get('today-health-devices-data', '\App\Http\Controllers\HealthDeviceController@getCompleteHealthDeviceData'); 
});

Route::group(['prefix'=>'invite/','middleware'=>'apiauth'],function(){ 
   
   Route::post('send', '\App\Http\Controllers\InviteController@postSendInvitationUser');
   Route::get('recieved-list', '\App\Http\Controllers\InviteController@getListRecievedInvitationUser');
   Route::get('sent-list', '\App\Http\Controllers\InviteController@getListSentInvitationUser');
   Route::get('list', '\App\Http\Controllers\InviteController@getListInvitationUser');
   Route::put('withdraw', '\App\Http\Controllers\InviteController@putWithdrawInvitationUser');
   Route::put('update-status', '\App\Http\Controllers\InviteController@putUpdateInvitationStatusUser');
   Route::get('accepted-users-list', '\App\Http\Controllers\InviteController@getListInvitationAcceptedUser');
   Route::get('search-users-to-invite', '\App\Http\Controllers\InviteController@getListUserToInvite');
});

Route::group(['prefix'=>'highfive/','middleware'=>'apiauth'],function(){ 
   
   Route::post('send', '\App\Http\Controllers\HighfiveController@postSendHighfiveUser');
   Route::get('received-list', '\App\Http\Controllers\HighfiveController@getReceivedHighfiveUser'); 

});

Route::group(['prefix'=>'booking/','middleware'=>'apiauth'],function(){       
   
   Route::post('expert-calendar', '\App\Http\Controllers\BookingController@postBookCalendarExpert');
   Route::get('list', '\App\Http\Controllers\BookingController@getBookingListUser');
   Route::put('cancel', '\App\Http\Controllers\BookingController@putCancelBookingUser');
   Route::put('move', '\App\Http\Controllers\BookingController@putMoveBookingUser');
   Route::post('feedback', '\App\Http\Controllers\BookingController@postExpertBookingFeedback');
   
 });

 Route::group(['prefix'=>'health-provider-insurance/','middleware'=>'apiauth'],function(){       
   
   Route::get('list', '\App\Http\Controllers\HealthProviderController@getHealthProviderList');
   Route::post('show-interest', '\App\Http\Controllers\HealthProviderController@postUserShowIntrest');
   
 });
 
 Route::group(['prefix'=>'work/','middleware'=>'apiauth'],function(){       
   Route::get('list', '\App\Http\Controllers\WorkController@getWorkList');
 });
 
 Route::group(['prefix'=>'partners/','middleware'=>'apiauth'],function(){       
   Route::get('list', '\App\Http\Controllers\PageController@getPartners');
 });
 
 Route::group(['prefix'=>'qualification/','middleware'=>'apiauth'],function(){       
   Route::delete('delete/{id}', '\App\Http\Controllers\QualificationController@deleteQualification');
 });
 
 Route::group(['prefix'=>'issue/','middleware'=>'apiauth'],function(){       
   Route::get('list', '\App\Http\Controllers\IssueController@getIssuesList');
   Route::post('report', '\App\Http\Controllers\IssueController@postReportIssueUser');
 });
 
 Route::group(['prefix'=>'notification/','middleware'=>'apiauth'],function(){       
   Route::get('list', '\App\Http\Controllers\NotificationController@getUserNotifications');
   Route::get('unread-count', '\App\Http\Controllers\NotificationController@getUserUnreadNotificationCount');
   Route::put('mark-read', '\App\Http\Controllers\NotificationController@putNotificationStatus');
 });
 
 Route::group(['prefix'=>'transaction/','middleware'=>'apiauth'],function(){       
   Route::post('add', '\App\Http\Controllers\TransactionController@postAddUserTransaction');
 });
 
 Route::group(['prefix'=>'gym/','middleware'=>'apiauth'],function(){       
   Route::post('check-in', '\App\Http\Controllers\GymController@postUserCheckIn');
   Route::post('check-out', '\App\Http\Controllers\GymController@postUserCheckOut');
   Route::get('details', '\App\Http\Controllers\GymController@getUserGymDetails');
 });
 
 Route::group(['prefix'=>'reward/','middleware'=>'apiauth'],function(){       
   Route::get('list', '\App\Http\Controllers\RewardController@getRewardList');
   Route::post('redeem', '\App\Http\Controllers\RewardController@postRewardRedeem');
   Route::post('use-points', '\App\Http\Controllers\RewardController@postUsePoints');
 });
 
  Route::group(['prefix'=>'wallet/','middleware'=>'apiauth'],function(){       
   Route::get('list', '\App\Http\Controllers\WalletController@getWalletRewardList');
   Route::post('add', '\App\Http\Controllers\WalletController@postAddRewardInWallet');
 });
 
 Route::group(['prefix'=>'garmin/','middleware'=>'apiauth'],function(){       
   Route::get('get-request-token', '\App\Http\Controllers\GarminController@getRequestToken');
   Route::get('get-access-token', '\App\Http\Controllers\GarminController@getAccessToken');
   Route::get('get-dailies-data', '\App\Http\Controllers\GarminController@getDailiesData');
   Route::post('register-user-token-secret', '\App\Http\Controllers\GarminController@postUserTokenSecret');
 });
 Route::group(['prefix'=>'garmin/'],function(){       
    Route::post('post-data', '\App\Http\Controllers\GarminController@postGarminData');
 });
 
 Route::group(['prefix'=>'conversation/','middleware'=>'apiauth'],function(){       
   Route::get('get-list', '\App\Http\Controllers\ConversationController@getConversationList');
   Route::post('send-message', '\App\Http\Controllers\ConversationController@postUserMessage');
   Route::get('get-dailies-data', '\App\Http\Controllers\GarminController@getDailiesData');
 });
 //test
 
 Route::post('get-split-payment', '\App\Http\Controllers\PaymentController@getSplitPayment');
});
