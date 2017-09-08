<?php

/*
 * File: Constant.php
 */


namespace App\Codes;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Constant {
    
    public static $NUMERIC = 1;
    public static $ALPHA_NUMERIC = 2;
    
    public static $YES = 1;
    public static $NO = 0;
    
    public static $ACTIVE = 1;
    public static $DELETED_NULL= NULL;
    public static $ADMIN = 4;
    public static $SUB_ADMIN = 5;
    public static $APP_USER = 2;
    public static $RADIUS = 100;
    public static $ORGANISATIONNAME = "Benefit Wellness";
    public static $NotBlocked = 0;
    public static $Blocked = 1;
    public static $genericTypeQuestion = 1;
    public static $ageGroupTypeQuestion = 2;
    public static $codeActive =1;
    public static $codeInactive =2;
    public static $TIME_DURATION_FOR_REOCCUR = 90;
    public static $TIME_DURATION_FOR_SLOTS = 90;

    public static $NotVerified = 0;
    public static $Verified = 1;
    public static $NotUsed = 0;
    public static $Used = 1;
    
    public static $INVITE_PENDING = 0;
    public static $INVITE_ACCEPTED = 1;
    public static $INVITE_REJECTED = 2;
    public static $INVITE_CANCELED = 3;
    public static $INVITE_WITHDRAW_NO = 0;
    public static $INVITE_WITHDRAW_YES = 1;
    
    public static $HEIGHT_IN_FEET = 2;
    public static $WEIGHT_IN_LBS = 2;
    

    public static $userType = 3;
    public static $MAX_GET_HELP_COUNT = 2;
    public static $MAX_FORGOT_COUNT = 5;
    public static $MAX_SIGNIN_COUNT = 5;
    public static $TIME_IN_MINUTES_TO_REACTIVE_BLOCKED_ACCOUNT = 30;
    public static $COORPORATE_USER = 1;
    public Static $NULLLATLONG = 0.000000;
    public static $userUnreadNotification =0;
    public static $userReadNotification =1;
    public static $notificationSendInvitation =1;
    public static $REGULAR_USER = 1;
    public static $PLUS_USER = 2;
    public static $EXPERT_USER = 3;
    
    public static $BOOKING_CANCEL_PENALTY_PERCENT = 10;
    public static $BOOKING_CONFIRM_STATUS = 1;
    public static $BOOKING_CANCELED_STATUS = 2;
    public static $PAST_BOOKINGS = 1;
    public static $CANCEL_BOOKINGS = 2;
    public static $NOT_INTERESTED = 0;
    public static $INTERESTED = 1;
    public static $EXPERT_CONFIRM = 2;
    public static $EXPERT_REJECT = 3;
    
    
    // Activation Type
    public static $COORPORATE_ACTIVATION_TYPE_USER = 1;
    public static $INSURANCE_ACTIVATION_TYPE_USER = 2;
    public static $PRIVATE_ACTIVATION_TYPE_USER = 3;
    
    
    // pagination constants
    public static $SESSION_BOOKING_PAGINATE = 10;
    public static $EXPERT_LISTING_PAGINATE = 4;
    public static $NOTIFICATION_LISTING_PAGINATE = 10;
    public static $HEALTH_PROVIDER_PAGINATE = 10;
    public static $INSURANCE_PROVIDER_PAGINATE = 20;
    public static $REWARD_PAGINATE = 10;
    public static $WALLET_PAGINATE = 10;
    public static $MESSAGE_PAGINATE = 10;
    
    //
    public static $HEALTH_PROVIDER = 1;
    public static $INSURANCE_PROVIDER = 2;
    
    // sorting constants
    public static $SORT_BY_DISTANCE = 1;
    public static $SORT_BY_RATING = 2;
    
    
    /* ---------- Goals starts ---------- */
    
    public static $TOTAL_NUMBER_WEEK_FOR_CALCULATION = 12;
    
    // Tiers 
    public static $TIERS = ['1'=>'Blue','2'=>'Silver','3'=>'Gold'];
    public static $BLUE = 1;
    public static $SILVER = 2;
    public static $GOLD = 3;
    
    // Tier wise daily goals
    public static $DAILY_GOALS_FOR_BLUE = 2;
    public static $DAILY_GOALS_FOR_SILVER = 3;
    public static $DAILY_GOALS_FOR_GOLD = 5;
    
    public static $WEEKLY_GOALS = ['1'=>'2','2'=>'3','3'=>'5'];
    
    
    
    // Daily Goals 
    public static $STEP_COUNT = 10000;
    public static $GYM_VISIT_COUNT = 1;
    public static $PT_SESSION_COUNT = 1;
    
    // Points
    public static $POINTS_FOR_EACH_DAILY_GOAL = 100;
    public static $BONUS_POINT_IN_BLUE = 0;
    public static $BONUS_POINT_IN_SILVER = 100;
    public static $BONUS_POINT_IN_GOLD = 200;
    
    // Weekly Goals for Upgrade and downgrade
    public static $WEEKLY_GOALS_FOR_UPGRADE = 10;
    public static $WEEKLY_GOALS_FOR_RENEWAL = 8;
    public static $WEEKLY_GOALS_FOR_DOWNGRADE = 7;
    
    
    /* ---------- Goals ends ---------- */
    
    
    
    // Radius for Expert Search
    public static $EXPERT_SEARCH_RADIUS = 200;
    
    // Type of Expert
    public static $NON_EXPERT = 0;
    public static $PERSONAL_TRAINER = 1;
    public static $HEALTH_PROFESSIONAL = 2;
    
    // Delete Type Of Expert Slot
    public static $SINGLE_SLOT = 1;
    
    
    // Payment Status
    public static $PAYMENT_INITIATED = 1;
    public static $PAYMENT_SUCCESS = 2;
    public static $PAYMENT_FAILURE = 3;
    public static $PAYMENT_ABORTED = 4;
    // Type of Notifications
    public static $INVITE_NOTIFICATION = 0;
    public static $HIGHFIVE_NOTIFICATION = 1;
    public static $BOOK_EXPERT_NOTIFICATION = 2;
    public static $CANCEL_BOOKING_NOTIFICATION = 3;
    public static $UPCOMING_BOKING_NOTIFICATION = 4;
    public static $EXPERT_APPROVED_NOTIFICATION = 5;
    public static $EXPERT_DISAPPROVED_NOTIFICATION = 6;
    public static $ACCEPT_REJECT_INVITE_NOTIFICATION = 7;
    public static $MOVE_BOOKING_NOTIFICATION = 8;
    public static $ACHIEVED_DAILY_GOAL_NOTIFICATION = 9;
    public static $ACHIEVED_WEEKLY_GOAL_NOTIFICATION = 10;
    public static $SESSION_COMPLETE_NOTIFICATION = 11;
    public static $NEW_MESSAGE_NOTIFICATION = 12;
    
    // UpdateInviteType
    public static $BY_INVITE_ID = 1;
    public static $BY_NOTIFICATION_ID = 2;
    
    
    // Image upload constants
    public static $USER_PROFILE_IMAGE = 1;
    public static $HEALTH_DATA_IMAGE = 2;
    public static $USER_QUALIFICATION_IMAGE = 3;
    public static $WORK_IMAGE = 4;
    
    
    // Age Wellness Constants
    public static $DIABETES_NO = 0;
    public static $DIABETES_YES = 1;
    
    public static $IN_APP_USER_INVITE = 1;
    public static $ADD_SESSIONS = 1;
    public static $REDUCE_SESSIONS = 2;
    
    public static $AVAILABLE = 1;
    public static $NOT_AVAILABLE = 0;
    
    public static $ZERO = 0;
    public static $ONE = 1;
    
    public static $MIN_TIME_FOR_GYM_VISIT = 20;
    public static $MERCHANT_CODE_LENGTH = 6;
    public static $ACTIVATION_CODE_LENGTH = 6;
    public static $USER_BAR_CODE_LENGTH = 12;
    public static $TRANSACTION_ID_LENGTH = 20;
    
    public static $EXPIRY_DAYS_OF_WALLET_REWARD = 2;
    
    public static $CREDIT = 1;
    public static $DEBIT = 2;
    
    public static $PARTNERS_TYPE = [    'Gyms'=>1,
                                        'HealthGroups'=>2,
                                        'Ecosystem'=>3,
                                        'HealthProvider'=>4,
                                        'InsuranceProvider'=>5,
                                        'Merchants'=>6,
                                        'Others'=>7,
                                        'Hotels'=>8,
                                        'Government'=>9,
                                    ];
    
    public static $GARMIN_SIGNATURE_TYPE = ['RequestToken'=>1,'AccessToken'=>2,'DailiesData'=>3];
    
    public static $MESSAGE_LIST_TYPE = ['Next'=>1,'Previous'=>2];
}
