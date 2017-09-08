<?php

/*
 * File: BookingController.php
 */

namespace App\Http\Controllers;
use App\Contracts\BookingContract;
use App\Http\Requests\Booking\BookExpertCalendarRequest;
use App\Http\Requests\Booking\CancelBookingRequest;
use App\Http\Requests\Booking\MoveBookingRequest;
use Illuminate\Http\Request;
use App\Http\Requests\Booking\BookingFeedbackRequest;



class BookingController extends BaseController {
    protected $booking;
    public function __construct(BookingContract $booking) {
        parent::__construct();
        $this->booking = $booking;
        $this->middleware('jsonvalidate',['except' => ['getBookingListUser','cronUpdateGoalAndPtBooking']]);
    }
    
    /**
        * 
        * Does booking of calendar for expert
        * 
        * @param $request which contains information about sessions that need to be booked
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success if successfully booked session otherwise failure 
        * 
    */
    public function postBookCalendarExpert(BookExpertCalendarRequest $request) {
        return $this->booking->postBookCalendar($request);
    }
    
    /**
        * 
        * Bring information booking sessions of expert
        * 
        * @param NULL
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success if successfully retrieved booked sessions 
        * 
    */
    public function getBookingListUser(Request $request) {
        return $this->booking->getBookingList($request);
    }
    
    /**
        * 
        * Does booking canceling of expert
        * 
        * @param $data which contains information of booking which needs to be cancel
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success if booked session canceled successfully otherwise failure 
        * 
    */
    public function putCancelBookingUser(CancelBookingRequest $request) {
        return $this->booking->putCancelBooking($request);
    }
    
    /**
        * 
        * Does move booking of expert
        * 
        * @param $data which contains information of booking which needs to be move
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success if booked session canceled successfully otherwise failure 
        * 
    */
    public function putMoveBookingUser(MoveBookingRequest $request) {
        return $this->booking->putMoveBooking($request);
    }
    
    public function postExpertBookingFeedBack(BookingFeedbackRequest $request) {
        return $this->booking->postExpertBookingFeedBack($request);
    }
   
}
