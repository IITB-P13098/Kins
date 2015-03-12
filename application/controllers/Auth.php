<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
  public function index()
  {
    redirect('auth/signin');
  }
  
  function _show_message($content, $heading = 'Success')
  {
    // $logged_in_user = $this->lib_user_login->get_user();
    // $data['logged_in_user'] = $logged_in_user;

    $local_data = array('heading' => $heading, 'content' => $content);

    $this->load->view('auth/base', $local_data);

    // $data['main_content'] = $this->load->view('auth/base', $local_data, TRUE);
    // $this->load->view('base', $data);
  }
  
  function _create_recaptcha()
  {
    $this->load->helper('recaptchalib');
    $this->load->config('tank_auth', TRUE);
    
    // Get reCAPTCHA HTML
    $html = recaptcha_get_html($this->config->item('recaptcha_site_key', 'tank_auth'));
    
    return $html;
  }
  
  public function signin()
  {
    $redirect_url = !empty($_GET['redirect']) ? $_GET['redirect'] : '';

    if ($this->lib_user_login->is_logged_in()) 
    {
      redirect($redirect_url);
    }
    
    $this->load->helper(array('form'));
    $this->load->library(array('form_validation'));
    
    $data['error'] = array();
    
    if ($this->form_validation->run())
    {
      if ($this->lib_user_login->login(
        $this->form_validation->set_value('login'),
        $this->form_validation->set_value('password'),
        $this->form_validation->set_value('remember')
        ))
      {
        redirect($redirect_url);
      }
      else
      {
        $data['error'] = $this->lib_user_login->get_error_message();
        if (isset($data['error']['banned'])) 
        {
          // banned user
          show_error('User Banned: '.$data['error']['banned']);
        }
      }
      
      if ($this->lib_user_login->is_max_login_attempts_exceeded($this->form_validation->set_value('login'))
        AND $this->config->item('use_recaptcha', 'tank_auth'))
      {
        $data['recaptcha_html'] = $this->_create_recaptcha();
      }
    }
    
    $this->_show_message($this->load->view('auth/signin', $data, TRUE), 'Sign In');
  }
  
  /**
   * Logout user
   *
   * @return void
   */
  function signout()
  {
    // header ("Expires: ".gmdate("D, d M Y H:i:s", time())." GMT");  
    // header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  
    header ("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
    header ("Cache-Control: no-cache, must-revalidate");  
    header ("Pragma: no-cache");

    $this->lib_user_login->logout();
    
    $this->_show_message('You have been successfully signed out. '.anchor('auth/signin', 'Sign in again!'), 'Signed Out');
  }
  
  function create_account()
  {
    if ($this->lib_user_login->is_logged_in()) 
    {
      redirect();
    }
    
    $this->load->helper(array('form'));
    $this->load->library('form_validation');
    
    $data['error'] = array();
    
    if ($this->form_validation->run())
    {
      if (!is_null($result = $this->lib_user_login->create_user(
        $this->form_validation->set_value('full_name'),
        $this->form_validation->set_value('username'),
        $this->form_validation->set_value('email'),
        $this->form_validation->set_value('password')
      )))
      {
        $url_query = !empty($_GET['redirect']) ? '?redirect='.rawurlencode($_GET['redirect']) : '';
        
        $this->load->library('lib_send_email');

        $this->lib_send_email->general('Welcome', $result['email'], 'welcome', $result);
        
        $this->lib_send_email->general('Verify your email address', $result['email'], 'verify_email', $result);

        redirect(!empty($_GET['redirect']) ? $_GET['redirect'] : '');
      }
      else
      {
        $data['error'] = $this->lib_user_login->get_error_message();
      }
    }
    
    // $data['use_username']
    // $data['captcha_registration']
    if ($this->config->item('captcha_registration', 'tank_auth') AND $this->config->item('use_recaptcha', 'tank_auth'))
    {
      $data['recaptcha_html'] = $this->_create_recaptcha();
    }
    
    $this->_show_message($this->load->view('auth/create_account', $data, TRUE), 'Create an account');
  }

  /**
   * Verify email address
   *
   * @return void
   */
  function verify_email($user_id = NULL, $email_key = NULL)
  {
    if (is_null($this->lib_user_login->verify_email($user_id, $email_key)))
    {
      show_error($this->lib_user_login->get_error_message());
    }
    
    $this->_show_message('Your email is successfully verified. '.anchor('', 'Home'), 'Email Verified');
  }
  
  /**
   * Generate reset code (to change password) and send it to user
   *
   * @return void
   */
  function forgot_password()
  {
    if ($this->lib_user_login->is_logged_in())
    {
      redirect();
    }
    
    $this->load->helper(array('form'));
    $this->load->library(array('form_validation'));
    
    $data['error'] = array();
    
    if ($this->form_validation->run())
    {
      // validation ok
      if (!is_null($result = $this->lib_user_login->forgot_password(
          $this->form_validation->set_value('login'))))
      {
        // Send email with new password
        $this->load->library('lib_send_email');
        $this->lib_send_email->general('Change your password', $result['email'], 'forgot_password', $result);
        
        $this->_show_message('Check mail to reset password. '.anchor(uri_string(), 'Reset again'), 'Check Mail');
        return;
      }
      else
      {
        $data['error'] = $this->lib_user_login->get_error_message();
      }
    }
    
    $this->_show_message($this->load->view('auth/forgot_password', $data, TRUE), 'Forgot Password');
  }
  
  /**
   * Replace user password (forgotten) with a new one (set by user).
   * User is verified by user_id and authentication code in the URL.
   * Can be called by clicking on link in mail.
   *
   * @return void
   */
  function reset_password($user_id = NULL, $email_key = NULL)
  {
    $this->load->helper(array('form'));
    $this->load->library(array('form_validation'));
    
    $data['error'] = array();
    
    if ($this->form_validation->run('auth/reset_password'))
    {
      // validation ok
      if (!is_null($result = $this->lib_user_login->reset_password(
        $user_id,
        $this->form_validation->set_value('password'),
        $email_key
      )))
      {
        $this->_show_message('Hurray got your new password. '.anchor('auth/signin', 'Sign in'), 'Reset Success');
        return;
      }
      else
      {
        show_error($this->lib_user_login->get_error_message());
      }
    }
    
    $this->_show_message($this->load->view('auth/reset_password', $data, TRUE), 'Reset Password');
  }
}