<?php

/*
 * File: ConversationContract.php
 */

namespace App\Contracts;

interface ConversationContract {
    
    public function getConversations($request);
    public function postSendMessage($request);
}
