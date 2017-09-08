<?php

/*
 * File: NotificationContractImpl.php
 */

namespace App\Implementers;
use App\Contracts\NotificationContract;
use App\Implementers\BaseImplementer;
use App\Models\NotificationsLogs;
use App\Helper\Utility\UtilityHelper;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\UserBooking;

class NotificationContractImpl extends BaseImplementer implements NotificationContract {
    
    public function __construct() {
        
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
    public function getNotificationsList() {
        try {
            $notifications = NotificationsLogs::listNotifications();
            return $this->renderSuccess(trans('messages.notification_list_retirved_successfully'), $notifications);
        } catch (\Exception $e) {
            UtilityHelper::logExceptionWithObject(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }
    
    public function makeItRead($data) {
        try {
            $notification = NotificationsLogs::getNotification($data['notificationId']);
            if(empty($notification)){
                return $this->renderSuccess(trans('messages.notification_not_found'));
            }
            else{
                NotificationsLogs::makeNotificationRead($notification);
                $unreadCount = NotificationsLogs::getAllUnreadNotification(Auth::user()->user_id);
                $result['notification'] = $notification;
                $result['unread'] = $unreadCount;
                return $this->renderSuccess(trans('messages.notification_status_read_updated_successfully'), $result);
            }
        } catch (\Exception $e) {
            UtilityHelper::logExceptionWithObject(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }
    
    public function unreadNotificationsCount() {
        try {
                $result = [];
                $user = Auth::user();
                $totalWeeklyGoal = $user->allWeeklyGoals()->first();
                $totalRedeemedRewards = $user->allRedeemedRewards()->first();
                $totalWalletRewards = $user->allWalletRewards()->first();
                $result['totalRewardsNeedToRedeem'] = $totalWeeklyGoal['weekly_goals'] - ($totalRedeemedRewards['redeemed_rewards'] + $totalWalletRewards['wallet_rewards']);
                $result['unreadCount'] = NotificationsLogs::getAllUnreadNotification(Auth::user()->user_id);
                $result['bookings'] = UserBooking::getPastBookingList();
                return $this->renderSuccess(trans('messages.unread_notification_count_retreived'),$result);
        } catch (\Exception $e) {
            UtilityHelper::logExceptionWithObject(__METHOD__, $e);
            return $this->renderFailure(trans('messages.error.exception'), Response::HTTP_OK);
        }
    }
}
