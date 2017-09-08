<?php

/*
 * File: InviteController.php
 */


namespace App\Http\Controllers;

use App\Contracts\InviteContract;
use Illuminate\Http\Request;
use App\Http\Requests\User\InviteUserRequest;
use App\Http\Requests\User\WithdrawInvitationRequest;
use App\Http\Requests\User\UpdateInvitationStatusRequest;




class InviteController extends BaseController {
    protected $invite;
    public function __construct(InviteContract $invite) {
        parent::__construct();
        $this->invite = $invite;
        $this->middleware('jsonvalidate',['except' => ['getListRecievedInvitationUser','getListSentInvitationUser',
            'postSendNotitifcation','getListInvitationUser','getListInvitationAcceptedUser','getListUserToInvite']]);
    }
    
    
    
    public function postSendInvitationUser(InviteUserRequest $request) {
       
        return $this->invite->postSendInvitation($request);
    }
    public function getListRecievedInvitationUser(Request $request) {
       
        return $this->invite->getRecievedInvitation($request);
    }
    
    public function getListInvitationUser(Request $request) {
       
        return $this->invite->getAllInvitation();
    }
    
    public function getListInvitationAcceptedUser(Request $request) {
       
        return $this->invite->getAllAcceptedInvitationUser($request);
    }
    
    public function getListSentInvitationUser(Request $request) {
       
        return $this->invite->getSentInvitation($request);
    }
    
    public function putWithdrawInvitationUser(WithdrawInvitationRequest $request) {
       
        return $this->invite->putWithdrawInvitation($request);
    }
    
    public function putUpdateInvitationStatusUser(UpdateInvitationStatusRequest $request) {
       
        return $this->invite->putUpdateInvitationStatus($request);
    }
    
    public function getListUserToInvite(Request $request) {
       
        return $this->invite->listUserToInvite($request);
    }
    
}
