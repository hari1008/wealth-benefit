<?php

// return array(
// 
//    'driver' => 'mail',
//    'host' => '',
//    'port' => 465,
//    'from' => array('address' => 'apptestman.wp@gmail.com', 'name' => 'Wealth Benefit'),
//    'encryption' => 'tls',
//    'username' => 'apptestman.wp@gmail.com',
//    'password' => 'Qwerty1',
//    //'sendmail' => '/usr/sbin/sendmail -bs',
//    'pretend' => false,
// 
//);

return array(
 
    'driver' => 'smtp',
    'host' => 'smtp.sendgrid.net',
    'port' => 587,
    'from' => array('address' => 'noreply@benefitwellness.com', 'name' => 'Wealth Benefit'),
    'encryption' => 'tls',
    'username' => 'rossmillar',
    'password' => 'benefit1234',
);
