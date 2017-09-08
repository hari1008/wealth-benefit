<?php

return [
   
  /* Master health data categories */
    
    'attributeType'=>array(
        'healthProvider'=>1,
        'healthInsurance'=>2
    ),
    /* Image type enum */
    "imageType" => array(
       
        "healthDataImagePath"=> 2,
        "workImagePath"=> 4,
        "rewardImagePath"=> 5,
        "ecosystemImagePath"=> 6,
      
    ),
    /**
     *
     * CSV Health Insurance $ Provider Report headers
     */
    "healthDataHeaders" => array('User Name','Email'),
    /**
     *
     * activationStatus for UI
     */
    'activationStatus'=>array(
        'active'=>"Active",
        'inactive'=>"Inactive",
        'private_type'=>'Y',
        'not_for_private'=>'N'

    ),
    'weekArray' => array(
        'Sunday' => 1,
        'Monday' => 2,
        'Tuesday' => 3, 
        'Wednesday' => 4,
        'Thursday' => 5,
        'Friday' => 6,
        'Saturday' => 7
    ),
    'weekDay' => array(
        1=>'Sunday', 
        2=>'Monday', 
        3=>'Tuesday', 
        4=>'Wednesday', 
        5=>'Thursday', 
        6=>'Friday',
        7=>'Saturday' 
    ),
    'timings' => array(
      '12:00 AM'=>'12:00 AM',
      '12:30 AM'=>'12:30 AM',
      '01:00 AM'=>'01:00 AM',
      '01:30 AM'=>'01:30 AM',
      '02:00 AM'=>'02:00 AM',
      '02:30 AM'=>'02:30 AM',
      '03:00 AM'=>'03:00 AM',
      '03:30 AM'=>'03:30 AM',
      '04:00 AM'=>'04:00 AM',
      '04:30 AM'=>'04:30 AM',
      '05:00 AM'=>'05:00 AM',
      '05:30 AM'=>'05:30 AM',  
      '06:00 AM'=>'06:00 AM',
      '06:30 AM'=>'06:30 AM',
      '07:00 AM'=>'07:00 AM',
      '07:30 AM'=>'07:30 AM',
      '08:00 AM'=>'08:00 AM',
      '08:30 AM'=>'08:30 AM',
      '09:00 AM'=>'09:00 AM',
      '09:30 AM'=>'09:30 AM',
      '10:00 AM'=>'10:00 AM',
      '10:30 AM'=>'10:30 AM',
      '11:00 AM'=>'11:00 AM',
      '11:30 AM'=>'11:30 AM',
      '12:00 PM'=>'12:00 PM',
      '12:30 PM'=>'12:30 PM',  
      '01:00 PM'=>'01:00 PM',
      '01:30 PM'=>'01:30 PM',
      '02:00 PM'=>'02:00 PM',
      '02:30 PM'=>'02:30 PM',
      '03:00 PM'=>'03:00 PM',
      '03:30 PM'=>'03:30 PM',
      '04:00 PM'=>'04:00 PM',
      '04:30 PM'=>'04:30 PM',
      '05:00 PM'=>'05:00 PM',
      '05:30 PM'=>'05:30 PM',
      '06:00 PM'=>'06:00 PM', 
      '06:30 PM'=>'06:30 PM',   
      '07:00 PM'=>'07:00 PM',
      '07:30 PM'=>'07:30 PM',
      '08:00 PM'=>'08:00 PM',
      '08:30 PM'=>'08:30 PM',
      '09:00 PM'=>'09:00 PM',
      '09:30 PM'=>'09:30 PM',
      '10:00 PM'=>'10:00 PM',
      '10:30 PM'=>'10:30 PM',
      '11:00 PM'=>'11:00 PM',
      '11:30 PM'=>'11:30 PM',  
    ),

    'interestedToBecomeExpert'=>1,
    
    'activationIsUsed'=>array(
        0=>'No',
        1=>'Yes'

    ),
    'setting'=>array(
        'terms'=>1,
        'privacy'=>2,
        'introductory'=>3
    ),
    // activation code csv headers
    'activationHeader'=>array(
        'mail'=>'mail',
        'name'=>'name',
        'surname'=>'surname',
        'company'=>'company',
        'department'=>'department',
        'designation'=>'designation'
    ),
    
    // delivery
    "delivery"=>array(
        1=>'Y',
        0=>'N'
    ),
    
    "work_type" => ['1'=>'Gym','2'=>'Medical Group','3'=>'Hotel','4'=>'Government'],
    
    "tiers" => ['1'=>'Blue','2'=>'Silver','3'=>'Gold'],
    
    "is_interested_for_expert"=>['expert_interested'=>'1','expert_confirm'=>'2'],
    
    "expert_type" => ['0'=>'Non Expert','1'=>'Health Professional','2'=>'Personal Trainer']
    
];
