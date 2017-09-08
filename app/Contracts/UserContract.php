<?php

/*
 * File: UserContract.php
 */

namespace App\Contracts;

interface UserContract {

    public function postSignUp($request);
    public function putChangePassword($request);
    public function putSignout();
    public function getCodeStatus($request);
    public function postSignIn($request);
    public function putForgotPassword($request);
    public function getCheckEmailVerification($request);
    public function postUserImages($request);
    public function putExpertProfile($request);
    public function getProfile();
    public function getProfileWithAvailability($request);
    public function getExpertList($request);
    public function getExpertInfo($request);
    public function postUpdateProfile($request);
    public function postUpdateActivationCode($request);
    public function postCreateCalendar($request);
    public function deleteCalendarSlot($request);
    public function getCalendarSlots();
    public function putUpdateWellnessAnswer($request);
    public function getSendNotification($request);
    public function postExpertHeathCategory($request);
    public function postHelp($request);
    public function getUserWithGoals($request);
    public function putRemoveExpertProfile();
    public function postMailActivationCode($request);
}
