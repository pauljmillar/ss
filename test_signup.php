<?php

require_once("MailChimp.php");

$MailChimp = new \drewm\MailChimp('ef17632f27493eedd396c8be4ce03c4e-us3');
$result = $MailChimp->call('lists/subscribe', array(
                'id'                => '7fb212e7c1',
                'email'             => array('email'=>'paul.millar@gmail.com'),
//                'merge_vars'        => array('FNAME'=>'Paul', 'LNAME'=>'Millar'),
                'double_optin'      => true,
                'update_existing'   => true,
                'replace_interests' => false,
                'send_welcome'      => true,
            ));
print_r($result);
?>