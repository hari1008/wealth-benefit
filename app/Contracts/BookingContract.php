<?php

/*
 * File: BookingContract.php
 */

namespace App\Contracts;

interface BookingContract {
    
    public function postBookCalendar($request);
    public function postExpertBookingFeedBack($request);
    public function getBookingList($request);
    public function putCancelBooking($request);
    public function putMoveBooking($request);
}
