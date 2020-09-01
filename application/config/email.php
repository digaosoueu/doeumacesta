<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config = array();
$config['protocol']  = 'smtp';
$config['charset'] 	 = 'utf-8';
$config['smtp_host'] = "smtp.doeumacesta.com.br";
$config['smtp_user'] = 'noreply@doeumacesta.com.br';
$config['smtp_pass'] = 'norepla2015';
$config['smtp_port'] = '587';
$config['mailtype']  = "html";

//$this->email->initialize($config);