<?php

/*
 * File: NotificationContract.php
 */

namespace App\Contracts;

interface NotificationContract {
    public function getNotificationsList();
    public function makeItRead($request);
    public function unreadNotificationsCount();
}
