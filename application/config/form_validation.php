<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Form Validation Settings
| -------------------------------------------------------------------------
|
*/

include_once "form_input.php";

$common_config = array(

  // input
  'username' => array(
    'field'   => 'username',
    'label'   => 'Username',
    'rules'   => 'strtolower|max_length['.$config['username_max_length'].']|trim|alpha_dash|required|is_unique[user.username]',
  ),
  'email' => array(
    'field'   => 'email',
    'label'   => 'New Email',
    'rules'   => 'strtolower|max_length['.$config['email_max_length'].']|valid_email|trim|required|is_unique[user_login.email]'
  ),
  'login' => array(
    'field'   => 'login',
    'label'   => 'Login',
    'rules'   => 'max_length['.max($config['email_max_length'], $config['username_max_length']).']|strip_tags|trim|required',
  ),
  'full_name' => array(
    'field'   => 'full_name',
    'label'   => 'Full Name',
    'rules'   => 'max_length['.$config['full_name_max_length'].']|strip_tags|trim|required',
  ),
  'bio' => array(
    'field'   => 'bio',
    'label'   => 'Bio',
    'rules'   => 'max_length['.$config['bio_max_length'].']|htmlspecialchars|trim'
  ),
  'location' => array(
    'field'   => 'location',
    'label'   => 'Location',
    'rules'   => 'max_length['.$config['location_max_length'].']|strip_tags|trim'
  ),
  
  // input password
  'password' => array(
    'field'   => 'password',
    'label'   => 'Password',
    'rules'   => 'min_length['.$config['password_min_length'].']|max_length['.$config['password_max_length'].']|required', // trim
  ),
  'old_password' => array(
    'field'   => 'old_password',
    'label'   => 'Old Password',
    'rules'   => 'min_length['.$config['password_min_length'].']|max_length['.$config['password_max_length'].']|required', // trim
  ),
  'confirm_password' => array(
    'field'   => 'confirm_password',
    'label'   => 'Confirm Password',
    'rules'   => 'matches[password]|required', // trim
  ),

  // check box
  'remember' => array(
    'field'   => 'remember',
    'label'   => 'Remember me',
    'rules'   => 'integer'
  ),
);

$config = array(
  // 'controller/method'     => array($common_config['value1'], $common_config['value2']),
  
  'auth/signin'               => array($common_config['login'], $common_config['password'], $common_config['remember']),
  'auth/create_account'       => array($common_config['full_name'], $common_config['username'], $common_config['email'], $common_config['password']),
  'auth/forgot_password'      => array($common_config['login']),
  'auth/reset_password'       => array($common_config['password'], $common_config['confirm_password']),


  'settings/username'         => array($common_config['username']),
  'settings/email'            => array($common_config['email']),
  'settings/password'         => array($common_config['old_password'], $common_config['password'], $common_config['confirm_password']),

  'settings/account'          => array($common_config['full_name'], $common_config['bio'], $common_config['location']),
);

/* End of file form_validation.php */
/* Location: ./application/config/form_validation.php */