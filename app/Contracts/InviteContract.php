<?php

/*
 * File: InviteContract.php
 */

namespace App\Contracts;

interface InviteContract {

    
    public function postSendInvitation($request);
    public function getRecievedInvitation();
    public function getSentInvitation();
    public function getAllInvitation();
    public function getAllAcceptedInvitationUser($request);
    public function putWithdrawInvitation($request);
    public function putUpdateInvitationStatus($request);
    
}
