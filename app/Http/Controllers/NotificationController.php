<?php

/*
 * File: NotificationController.php
 */

namespace App\Http\Controllers;
use App\Contracts\NotificationContract;
use App\Http\Requests\Notification\UpdateStatusNotificationRequest;



class NotificationController extends BaseController {
    protected $notification;
    public function __construct(NotificationContract $notification) {
        parent::__construct();
        $this->notification = $notification;
        $this->middleware('jsonvalidate',['except' => ['getUserNotifications','getUserUnreadNotificationCount']]);
    }
    
     /**
        * 
        * Provide Notification list of logged in user
        * 
        * @param null
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success if everything went right
        * 
    */
    public function getUserNotifications(){
            return $this->notification->getNotificationsList();
    } 
    
    public function getUserUnreadNotificationCount(){
            return $this->notification->unreadNotificationsCount();
    } 
    
    public function putNotificationStatus(UpdateStatusNotificationRequest $request){
            return $this->notification->makeItRead($request);
    } 
    
    
}
