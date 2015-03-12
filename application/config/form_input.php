<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Form Validation Settings
| -------------------------------------------------------------------------
|
*/

// form types
// input:
// 'username', 'email', 'login', 'full_name', 'location',

// textarea: 
// 'bio', 'comment', 'feedback',

// password:
// 'password', 'old_password', 'confirm_password',

// checkbox:
// 'remember',

$config['username_max_length']    =   20;
$config['password_min_length']    =    5;
$config['password_max_length']    =   20;

$config['email_max_length']       =   80;

$config['full_name_max_length']   =   30;
$config['bio_max_length']         =  200;
$config['location_max_length']    =   30;

/* End of file form_input.php */
/* Location: ./application/config/form_input.php */