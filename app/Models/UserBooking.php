<?php

/*
 * File: UserBooking.php
 */

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Codes\Constant;
use App\Models\UserHealthDevices;
use App\Models\User;
use App\Helper\Utility\CommonHelper;
use App\Helper\Utility\UtilityHelper;
use Illuminate\Support\Facades\Log;

class UserBooking extends Authenticatable {

    use SoftDeletes;

    const PrimaryImage = 1;

    protected $table = 'user_bookings';
    protected $primaryKey = 'booking_id';
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at', 'user_id', 'expert_id'
    ];
    protected $casts = ['booking_status' => 'integer'];

    public function user() {
        return $this->hasOne('App\Models\User', 'user_id', 'user_id')->select(array('user_id', 'first_name', 'last_name', 'image'));
    }

    public function expert() {
        return $this->hasOne('App\Models\User', 'user_id', 'expert_id');
    }

    public function feedback() {
        return $this->belongsTo('App\Models\UserFeedback', 'booking_id', 'booking_id')->select('*');
    }

    /**
     * 
     * Checking for booked session from a bulk data 
     * 
     * @param $data contains description about multiple session that user need to book
     * 
     * @return an array of already booked session if any
     * 
     */
    public static function checkBookCalender($data) {
        $alreadyBooked = [];
        $query = '';
        foreach ($data['bookings'] as $sessionWiseData) {

            $startTime = $sessionWiseData['startTime'];
            $endTime = $sessionWiseData['endTime'];
            $date = $sessionWiseData['date'];
            $expertId = $sessionWiseData['expertId'];
            if (empty($query)) {
                $query = UserBooking::where(function($subQuery) use($startTime, $endTime, $date, $expertId) {
                            $subQuery->where('start_time', $startTime)
                                    ->where('expert_id', $expertId)
                                    ->where('date', $date)
                                    ->where('end_time', $endTime)
                                    ->where('booking_status', Constant::$BOOKING_CONFIRM_STATUS);
                        });
            } else {
                $query->orWhere(function($subQuery) use($startTime, $endTime, $date, $expertId) {
                    $subQuery->where('start_time', $startTime)
                            ->where('expert_id', $expertId)
                            ->where('date', $date)
                            ->where('end_time', $endTime)
                            ->where('booking_status', Constant::$BOOKING_CONFIRM_STATUS);
                });
            }
        }

        return $query->get();
    }

    /**
     * 
     * Booking sessions  
     * 
     * @param $data contains description about multiple session that user need to book
     * 
     * @return NULL
     * 
     */
    public static function postBookCalender($data) {
        foreach ($data['bookings'] as $sessionWiseData) {
            $userBooking[] = [
                'user_id' => Auth::user()->user_id,
                'expert_id' => $sessionWiseData['expertId'],
                'date' => $sessionWiseData['date'],
                'start_time' => $sessionWiseData['startTime'],
                'end_time' => $sessionWiseData['endTime']
            ];
        }
        UserBooking::insert($userBooking);
    }

    /**
     * 
     * getting booking list of logged in user
     * 
     * @param NULL
     * 
     * @return objects of booked session in a paginated form
     * 
     */
    public static function getBookingList($data) {
        $query = UserBooking::with(['user', 'expert.sessionPrices', 'expert.purchasedSessions', 'expert.works', 'expert.qualifications']);
        if (empty($data['expertid'])) {
            $query->where('user_id', Auth::user()->user_id);
        } else {
            $query->where('expert_id', $data['expertid']);
        }
        if ($data['type'] == Constant::$PAST_BOOKINGS) {
            $query->where(DB::raw("CONCAT(date,' ',end_time)"), '<=', date('Y-m-d H:i:s'));

            $query->where('booking_status', Constant::$BOOKING_CONFIRM_STATUS);
            $query->orderBy('date', 'desc');
            $query->orderBy('start_time', 'desc');
        } else if ($data['type'] == Constant::$CANCEL_BOOKINGS) {
            $query->where('booking_status', Constant::$BOOKING_CANCELED_STATUS);
            $query->orderBy('date', 'desc');
            $query->orderBy('start_time', 'desc');
        } else {
            $query->where(DB::raw("CONCAT(date,' ',end_time)"), '>=', date('Y-m-d H:i:s'));
            $query->where('booking_status', Constant::$BOOKING_CONFIRM_STATUS);
            $query->orderBy('date', 'asc');
            $query->orderBy('start_time', 'asc');
        }
        $userBooking = $query->paginate(Constant::$SESSION_BOOKING_PAGINATE);

        return $userBooking;
    }

    public static function getPastBookingList() {
        $query = UserBooking::with(['expert']);
        $query->where('user_id', Auth::user()->user_id);
        $query->where('is_feedback_recieved', Constant::$ZERO);
        $query->where(DB::raw("CONCAT(date,' ',end_time)"), '<=', date('Y-m-d H:i:s'));
        $query->where('booking_status', Constant::$BOOKING_CONFIRM_STATUS);
        $query->orderBy('updated_at', 'desc');
        $query->orderBy('booking_id', 'desc');
        $userBooking = $query->get();
        return $userBooking;
    }

    /**
     * 
     * Canceling booked session of user
     * 
     * @param $data contains description about session that user need to cancel
     * 
     * @return a booking session object on success and false otherwise
     * 
     */
    public static function putCancelBooking($userBooking) {

        $userBooking['booking_status'] = Constant::$BOOKING_CANCELED_STATUS;
        $userBooking->save();
        return $userBooking;
    }

    public static function putMoveBooking($userBooking, $data) {
        $userBooking['start_time'] = $data['startTime'];
        $userBooking['end_time'] = $data['endTime'];
        $userBooking['date'] = $data['date'];
        $userBooking->save();
        return $userBooking;
    }

    public static function updateFeedbackStatus($userBooking) {
        $userBooking->is_feedback_recieved = Constant::$ONE;
        $userBooking->save();
    }

    /**
     * 
     * get booked session of expert for limited period
     * 
     * @param NULL
     * 
     * @return a booking session object on success and NULL otherwise
     * 
     */
    public static function getAllExpertBooking() {
        $from = date("Y-m-d");
        $to = \Date('Y-m-d', strtotime("+" . Constant::$TIME_DURATION_FOR_SLOTS . " days"));
        $userBooking = UserBooking::select('expert_id', 'date', 'start_time', 'end_time')
                ->where('expert_id', Auth::user()->user_id)
                ->where('booking_status', Constant::$BOOKING_CONFIRM_STATUS)
                ->whereBetween('date', array($from, $to))
                ->get();
        if (is_object($userBooking)) {
            return $userBooking;
        } else {
            return NULL;
        }
    }

    /**
     * 
     * Checking for booked session from a bulk data 
     * 
     * @param $data contains description about multiple session that user need to book
     * 
     * @return an array of already booked session if any
     * 
     */
    public static function checkForAlreadyBook($data) {
        $alreadyBooked = [];
        foreach ($data as $sessionWiseData) {
            $userBooking = UserBooking::where('date', $sessionWiseData['date'])
                    ->where('start_time', $sessionWiseData['start_time'])
                    ->where('end_time', $sessionWiseData['end_time'])
                    ->where('expert_id', $sessionWiseData['expert_id'])
                    ->first();
            if (is_object($userBooking)) {
                $alreadyBooked[] = $userBooking;
            }
        }
        return $alreadyBooked;
    }

    public static function cronUpdateGoalAndPtBooking() {
        try {
            $now = new \DateTime('now');
            $current_date = $now->format('Y-m-d');
            $current_time = $now->format('H:i:s');
            $year = $now->format('Y');

            // send push before 1 hour
            $startTime1 = date('H:i:s', strtotime('now') + 59 * 60);
            $startTime2 = date('H:i:s', strtotime('now') + 60 * 60);
            $users = UserBooking::select('user_id', 'expert_id', 'start_time')
                    ->with(['expert'])
                    ->where('date', $current_date)
                    ->whereBetween('start_time', [$startTime1, $startTime2])
                    ->where('booking_status', Constant::$BOOKING_CONFIRM_STATUS)
                    ->get();

            foreach ($users as $booking) {
                $message = 'You have a PT session scheduled with ' . $booking['expert']['first_name'] . ' at ' . date('h:i A', strtotime($booking['start_time']));
                $type = Constant::$UPCOMING_BOKING_NOTIFICATION;
                $recieverUserId = $booking['user_id'];
                $senderUserId = $booking['expert_id'];
                self::sendBookingNotification($senderUserId, $recieverUserId, $message, $type);
            }

            // updating PT sessions
            $weekNumber = CommonHelper::getWeekNumber($current_date);
            $userBookings = UserBooking::select(DB::raw("CONCAT(date,' ',end_time) AS time"), 'user_id')
                            ->where('date', $current_date)
                            ->where('end_time', '<', $current_time)
                            ->where('booking_status', Constant::$BOOKING_CONFIRM_STATUS)
                            ->where('is_feedback_recieved', Constant::$NO)
                            ->pluck('user_id', 'time')->toArray();
            foreach ($userBookings as $time => $userId) {
                $hourKey = explode(':', $time)[0];
                UserHealthDevices::updatePtSession($hourKey, $userId, $current_date, $weekNumber, $time);
                $user = User::getUserById($userId);
                $points = Goal::updateGoals($user['user_id'], (int) $user['current_tier'], $user['reward_point'], $current_date, $weekNumber);
                User::updateUserTierInfoAndPoint($user, $weekNumber, $year, $points);
            }
        } catch (\Exception $e) {
            UtilityHelper::logExceptionWithObject(__METHOD__, $e);
        }
    }

    public static function sendBookingNotification($senderUserId, $recieverUserId, $message, $type) {
        $data = array(
            'type' => $type,
            'alert' => $message,
            'toUserId' => (array) $recieverUserId,
            'time' => time()
        );
        $deviceObj = new Device();
        $deviceObj->sendPush($data);
        $notificationData['reciever_user_id'] = $recieverUserId;
        $notificationData['sender_user_id'] = $senderUserId;
        $notificationData['type'] = $type;
        $notificationData['message'] = '<div style="font-family:AkkuratLight;font-size:16px;letter-spacing:1pt;color:rgb(109,111,125);">' .
                $message . '</div>';
        $notification = NotificationsLogs::createNotification($notificationData); // adding notification to the notification
    }

}
