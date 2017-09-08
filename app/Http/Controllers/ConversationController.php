<?php

/*
 * File: ConversationController.php
 */


namespace App\Http\Controllers;
use App\Contracts\ConversationContract;
use App\Http\Requests\Conversation\MessageListRequest;
use App\Http\Requests\Conversation\MessageSendRequest;

class ConversationController extends BaseController {
    protected $conversation;
    public function __construct(ConversationContract $conversation) {
        parent::__construct();
        $this->conversation = $conversation;
        $this->middleware('jsonvalidate',['except' => ['getConversationList']]);
    }
   
    /**
        * 
        * Provide list of messages of the behalf of user and timestamp
        * 
        * @param $request contains type of data required (1 - next , 2 - Previous) 
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success with messages objects if retrieved device data successfully
        * 
    */
    public function getConversationList(MessageListRequest $request) {
        return $this->conversation->getConversations($request);
    }
    
    /**
        * 
        * Send Message in database
        * 
        * @param $request contains message and receiver id
        * 
        * @throws Exception If something happens during the process
        * 
        * @return success with message objects if data inserted successfully
        * 
    */
    public function postUserMessage(MessageSendRequest $request) {
        return $this->conversation->postSendMessage($request);
    }
    
}
