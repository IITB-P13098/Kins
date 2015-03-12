<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('phpass-0.1/PasswordHash.php');

/**
 * Lib_user_login
 *
 * Authentication library for Code Igniter.
 *
 * @package   Tank_auth
 * @author    Ilya Konyukhov (http://konyukhov.com/soft/)
 * @version   1.0.9
 * @based on  DX Auth by Dexcell (http://dexcell.shinsengumiteam.com/dx_auth)
 * @license   MIT License Copyright (c) 2008 Erick Hartanto
 */
class Lib_user_login
{
  private $error = array();
  
  function __construct()
  {
    $this->ci =& get_instance();
    
    $this->ci->load->config('tank_auth', TRUE);
    
    $this->ci->load->library('session');

    $this->ci->load->model(array('tank_auth/model_user', 'tank_auth/model_user_login'));
    
    // Try to autologin
    $this->_autologin();
  }
  
  /**
   * Save data for user's autologin
   *
   * @param  int
   * @return  bool
   */
  private function _create_autologin($user_id)
  {
    $this->ci->load->helper('cookie');
    $key = substr(md5(uniqid(rand().get_cookie($this->ci->config->item('sess_cookie_name')))), 0, 16);
    
    $this->ci->load->model('tank_auth/model_user_autologin');
    $this->ci->model_user_autologin->purge($user_id);
    
    if ($this->ci->model_user_autologin->set($user_id, md5($key)))
    {
      set_cookie(array(
        'name'    => $this->ci->config->item('autologin_cookie_name', 'tank_auth'),
        'value'   => serialize(array('user_id' => $user_id, 'key' => $key)),
        'expire'  => $this->ci->config->item('autologin_cookie_life', 'tank_auth'),
      ));
      return TRUE;
    }
    return FALSE;
  }
  
  /**
   * Clear user's autologin data
   *
   * @return  void
   */
  private function _delete_autologin()
  {
    $this->ci->load->helper('cookie');
    if ($cookie = get_cookie($this->ci->config->item('autologin_cookie_name', 'tank_auth'), TRUE))
    {
      $cookie_data = unserialize($cookie);
      
      $this->ci->load->model('tank_auth/model_user_autologin');
      $this->ci->model_user_autologin->delete($cookie_data['user_id'], md5($cookie_data['key']));
      
      delete_cookie($this->ci->config->item('autologin_cookie_name', 'tank_auth'));
    }
  }
  
  /**
   * Login user automatically if he/she provides correct autologin verification
   *
   * @return  void
   */
  private function _autologin()
  {
    if (!$this->is_logged_in()) // not logged in (as any user)
    {
      $this->ci->load->helper('cookie');
      
      if ($cookie = get_cookie($this->ci->config->item('autologin_cookie_name', 'tank_auth'), TRUE))
      {
        $cookie_data = unserialize($cookie);
        
        if (isset($cookie_data['key']) AND isset($cookie_data['user_id']))
        {
          $this->ci->load->model('tank_auth/model_user_autologin');
          
          $user = $this->ci->model_user_autologin->get($cookie_data['user_id'], md5($cookie_data['key']));
          if (!empty($user))
          {
            // Login user
            $this->ci->session->set_userdata(array(
              'user_id'   => $user['user_id'],
              'status'    => '1',
            ));
            
            // Renew users cookie to prevent it from expiring
            set_cookie(array(
              'name'      => $this->ci->config->item('autologin_cookie_name', 'tank_auth'),
              'value'     => $cookie,
              'expire'    => $this->ci->config->item('autologin_cookie_life', 'tank_auth'),
            ));
            
            $this->ci->model_user_login->update_login_info($user['user_id']);
            
            return TRUE;
          }
        }
      }
    }
    return FALSE;
  }
  
  /**
   * Get error message.
   * Can be invoked after any failed operation such as login or register.
   *
   * @return  string
   */
  function get_error_message()
  {
    return $this->error;
  }
  
  /**
   * Check if user logged in.
   *
   * @return  bool
   */
  public function is_logged_in()
  {
    return $this->ci->session->userdata('status');
  }
  
  /**
   * Get user_id
   *
   * @return  string
   */
  function get_user_id()
  {
    return $this->ci->session->userdata('user_id');
  }

  /**
   * Get username
   *
   * @return  string
   */
  function get_username()
  {
    $user_id = $this->get_user_id();
    if (!empty($user_id))
    {
      $user = $this->ci->model_user->get_user_by_id($user_id);
      return $user['username'];
    }
    return NULL;
  }
  
  function get_user()
  {
    $user_id = $this->get_user_id();
    if (!empty($user_id))
    {
      $user = $this->ci->model_user->get_user_by_id($user_id);
      return $user;
    }
    return NULL;
  }

  function get_email_by_id($user_id)
  {
    $user_email = $this->ci->model_user_login->get_email_by_id($user_id);

    if (empty($user_email))
    {
      $this->error = array('message' => 'Invalid user id');
      return NULL;
    }
    else return $user_email;
  }

  function _verify_captcha()
  {
    $this->ci->load->helper('recaptchalib');
    $this->ci->load->config('tank_auth', TRUE);
    
    $privatekey = $this->ci->config->item('recaptcha_secret_key', 'tank_auth');
    return recaptcha_check_answer($privatekey);
  }
  
  /**
   * Create new user on the site and return some data about it:
   * user_id, username, password, email, new_email_key (if any).
   *
   * @param  string
   * @param  string
   * @param  string
   * @param  bool
   * @return  array
   */
  function create_user($full_name, $username, $email, $password)
  {
    if (!$this->_verify_captcha())
    {
      $this->error = array('captcha' => 'incorrect captcha');
      return NULL;
    }

    // Hash password using phpass
    $hasher = new PasswordHash(
        $this->ci->config->item('phpass_hash_strength', 'tank_auth'),
        $this->ci->config->item('phpass_hash_portable', 'tank_auth'));
    $hashed_password = $hasher->HashPassword($password);
    
    $user_data = array(
      'username'    => $username,
      'full_name'   => $full_name,
    );

    $user_login_data = array(
      'password'    => $hashed_password,
      'email'       => $email,
      'last_ip'     => $this->ci->input->ip_address(),
      'email_key'   => md5(rand().microtime()),
    );
    

    $this->ci->db->trans_start();

    $user_id = $this->ci->model_user->create($user_data);

    $this->ci->model_user_login->create($user_id, $user_login_data);
        
    $this->ci->db->trans_complete();

    // Login
    $this->login($username, $password, TRUE, FALSE); // $remember = TRUE, $verify_captcha = FALSE

    return array(
      'username'    => $username,
      'full_name'   => $full_name,
      'user_id'     => $user_id,
      'email'       => $user_login_data['email'],
      'email_key'   => $user_login_data['email_key'],
    );
  }
  
  /**
   * Login user on the site. Return TRUE if login is successful
   * (user exists and activated, password is correct), otherwise FALSE.
   *
   * @param  string  (username or email or both depending on settings in config file)
   * @param  string
   * @param  bool
   * @return  bool
   */
  function login($login, $password, $remember, $verify_captcha = TRUE)
  {
    if ($verify_captcha AND !$this->_verify_captcha())
    {
      $this->error = array('captcha' => 'incorrect captcha');
      return NULL;
    }

    $user = $this->ci->model_user_login->get_user_by_login($login);
    if (empty($user))
    {
      // fail - wrong login
      $this->increase_login_attempt($login);
      $this->error = array('login' => 'incorrect login');
      return NULL;
    }

    if ($user['banned'] == 1)
    {
      // fail - banned
      $this->error = array('banned' => $user['ban_reason']);
      return NULL;
    }
    
    // Does password match hash in database?
    $hasher = new PasswordHash(
      $this->ci->config->item('phpass_hash_strength', 'tank_auth'),
      $this->ci->config->item('phpass_hash_portable', 'tank_auth'));
    
    if ($hasher->CheckPassword($password, $user['password']))
    {
      // password ok
      
      // login ok
      $this->ci->session->set_userdata(array(
        'user_id'   => $user['user_id'],
        'status'    => '1',
      ));

      if ($remember)
      {
        $this->_create_autologin($user['user_id']);
      }
      
      $this->clear_login_attempts($login);

      $this->ci->model_user_login->update_login_info($user['user_id']);
      return TRUE;
    }
    else
    {
      // fail - wrong password
      $this->increase_login_attempt($login);
      $this->error = array('password' => 'incorrect password');
      return NULL;
    }
  }

  function verify_email($user_id, $email_key)
  {
    if ($this->ci->model_user_login->verify_email($user_id, $email_key))
    {
      return TRUE;
    }
    else
    {
      $this->error = array('message' => 'Email verification failed. Due to key mismatch.');
      return NULL;
    }
  }

  function update_email($user_id, $email)
  {
    $email_key = md5(rand().microtime());
    $this->ci->model_user_login->update_email($user_id, $email, $email_key);

    return $email_key;
  }

  function resend_email_key($user_id)
  {
    $email_key = md5(rand().microtime());
    if ($this->ci->model_user_login->update_email_key($user_id, $email_key))
    {
      return $email_key;
    }
  }
  
  function forgot_password($login)
  {
    $user = $this->ci->model_user_login->get_user_by_login($login);

    if (!empty($user))
    {
      $password_key = md5(rand().microtime());
      $this->ci->model_user_login->update_password_key($user['user_id'], $password_key);

      return array(
        'user_id'       => $user['user_id'],
        'username'      => $user['username'],
        'full_name'     => $user['full_name'],
        'email'         => $user['email'],
        'password_key'  => $password_key,
      );
    }
    else
    {
      $this->error = array('login' => 'incorrect email or username');
      return NULL;
    }
  }
  
  /**
   * Replace user password (forgotten) with a new one (set by user)
   * and return some data about it: user_id, username, password, email.
   *
   * @param  string
   * @param  string
   * @return  bool
   */
  function reset_password($user_id, $password, $email_key)
  {
    // Hash password using phpass
    $hasher = new PasswordHash(
      $this->ci->config->item('phpass_hash_strength', 'tank_auth'),
      $this->ci->config->item('phpass_hash_portable', 'tank_auth'));
    $hashed_password = $hasher->HashPassword($password);
    
    if ($this->ci->model_user_login->reset_password($user_id, $hashed_password, $email_key))
    {
      // Clear all user's autologins
      $this->ci->load->model('tank_auth/model_user_autologin');
      $this->ci->model_user_autologin->clear($user_id);

      return TRUE;
    }
    else
    {
      $this->error = array('message' => 'Error in verification code.');
    }

    return NULL;
  }
  
  function update_password($user_id, $old_password, $password)
  {
    $user = $this->ci->model_user_login->get_user_by_id($user_id);

    // Hash password using phpass
    $hasher = new PasswordHash(
      $this->ci->config->item('phpass_hash_strength', 'tank_auth'),
      $this->ci->config->item('phpass_hash_portable', 'tank_auth')
    );
    
    if ($hasher->CheckPassword($old_password, $user['password']))
    {
      // password ok
      $hashed_password = $hasher->HashPassword($password);
      $this->ci->model_user_login->update_password($user_id, $hashed_password);
      
      return TRUE;
    }
    else
    {
      // fail - wrong password
      $this->error = array('old_password' => 'incorrect password');
      return NULL;
    }
  }
  
  /**
   * Logout user from the site
   *
   * @return  void
   */
  function logout()
  {
    $this->_delete_autologin();
    
    // See http://codeigniter.com/forums/viewreply/662369/ as the reason for the next line
    $this->ci->session->set_userdata(array('user_id' => '', 'status' => ''));
    
    $this->ci->session->sess_destroy();
    
    //destroy cookies
  }
  
  /**
   * Check if login attempts exceeded max login attempts (specified in config)
   *
   * @param  string
   * @return  bool
   */
  function is_max_login_attempts_exceeded($login)
  {
    if ($this->ci->config->item('login_count_attempts', 'tank_auth'))
    {
      $this->ci->load->model('tank_auth/model_login_attempt');
      return $this->ci->model_login_attempt->get_attempts_num($this->ci->input->ip_address(), $login) >= $this->ci->config->item('login_max_attempts', 'tank_auth');
    }
    return FALSE;
  }
  
  /**
   * Increase number of attempts for given IP-address and login
   * (if attempts to login is being counted)
   *
   * @param  string
   * @return  void
   */
  private function increase_login_attempt($login)
  {
    if ($this->ci->config->item('login_count_attempts', 'tank_auth'))
    {
      if (!$this->is_max_login_attempts_exceeded($login))
      {
        $this->ci->load->model('tank_auth/model_login_attempt');
        $this->ci->model_login_attempt->increase_attempt($this->ci->input->ip_address(), $login);
      }
    }
  }
  
  /**
   * Clear all attempt records for given IP-address and login
   * (if attempts to login is being counted)
   *
   * @param  string
   * @return  void
   */
  private function clear_login_attempts($login)
  {
    if ($this->ci->config->item('login_count_attempts', 'tank_auth'))
    {
      $this->ci->load->model('tank_auth/model_login_attempt');
      $this->ci->model_login_attempt->clear_attempts(
        $this->ci->input->ip_address(),
        $login,
        $this->ci->config->item('login_attempt_expire', 'tank_auth')
      );
    }
  }
}