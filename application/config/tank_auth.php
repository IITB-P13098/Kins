<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Website details
|
| These details are used in emails sent by authentication library.
|--------------------------------------------------------------------------
*/
$config['website_name']     = 'Kins';
$config['webmaster_email']  = 'no-reply@kins.email';

/*
|--------------------------------------------------------------------------
| Registration settings
|
| 'allow_registration'    = Registration is enabled or not
| 'captcha_registration'  = Registration uses CAPTCHA
| 'email_activation'      = Requires user to activate their account using email after registration.
| 'use_username'          = Username is required or not.
|
| 'username_max_length'   = Max length of user's username.
| 'password_min_length'   = Min length of user's password.
| 'password_max_length'   = Max length of user's password.
|--------------------------------------------------------------------------
*/
$config['allow_registration']   = TRUE;
$config['captcha_registration'] = TRUE;
$config['email_activation']     = TRUE;
$config['use_username']         = TRUE;

/*
|--------------------------------------------------------------------------
| Security settings
|
| The library uses PasswordHash library for operating with hashed passwords.
| 'phpass_hash_portable' = Can passwords be dumped and exported to another server. If set to FALSE then you won't be able to use this database on another server.
| 'phpass_hash_strength' = Password hash strength.
|--------------------------------------------------------------------------
*/
$config['phpass_hash_portable'] = FALSE;
$config['phpass_hash_strength'] = 8;

/*
|--------------------------------------------------------------------------
| Login settings
|
| 'login_by_username'     = Username can be used to login.
| 'login_by_email'        = Email can be used to login.
| You have to set at least one of 2 settings above to TRUE.
| 'login_by_username' makes sense only when 'use_username' is TRUE.
|
| 'login_count_attempts'  = Count failed login attempts.
| 'login_max_attempts'    = Number of failed login attempts before CAPTCHA will be shown.
| 'login_attempt_expire'  = Time to live for every attempt to login. Default is 24 hours (60*60*24).
|--------------------------------------------------------------------------
*/
$config['login_by_username']    = TRUE;
$config['login_by_email']       = TRUE;
$config['login_count_attempts'] = TRUE;
$config['login_max_attempts']   = 3;
$config['login_attempt_expire'] = 60*60*24;

/*
|--------------------------------------------------------------------------
| Auto login settings
|
| 'autologin_cookie_name' = Auto login cookie name.
| 'autologin_cookie_life' = Auto login cookie life before expired. Default is 2 months (60*60*24*31*2).
|--------------------------------------------------------------------------
*/
$config['autologin_cookie_name']  = 'autologin';
$config['autologin_cookie_life']  = 60*60*24*31*2;

/*
|--------------------------------------------------------------------------
| reCAPTCHA
|
| 'use_recaptcha' = Use reCAPTCHA for 'captcha_registration'
| You can get reCAPTCHA keys by registering at http://recaptcha.net
|--------------------------------------------------------------------------
*/
$config['use_recaptcha']          = FALSE;
$config['recaptcha_site_key']     = '';
$config['recaptcha_secret_key']   = '';

/* End of file tank_auth.php */
/* Location: ./application/config/tank_auth.php */