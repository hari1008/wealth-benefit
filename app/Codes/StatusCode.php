<?php

/*
 * File: StatusCode.php
 * Benefil Wellness
 */


namespace App\Codes;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class StatusCode {
   public static $USER_DELETED = 601;
   public static $USER_NOT_FOUND = 610;
    public static $EMAIL_NOT_EXISTS = 616;
   public static $USER_SUSPENDED = 612;

   public static $CSV_HEADERS_INCORRECT = 613;
 
   public static $EXCEPTION = 615;

   public static $USER_ALREADY_CHECKEDIN = 602;
   public static $USER_ALREADY_CHECKEDIN_OTHER_VENUE = 603;
   public static $USER_ALREADY_CHECKEDIN_OTHER_EVENT = 604;
   public static $USER_CHECKEDIN_EVENT = 605;
   public static $USER_CHECKEDIN_VENUE = 606;
   public static $USER_ALREADY_CHECKOUT = 607;
   public static $FACEBOOK_ID_NOT_EXIST = 608;
   public static $PARAMETER_MISSING = 611;
   
}
