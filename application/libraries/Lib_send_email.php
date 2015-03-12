<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lib_send_email
{
  private $debug = FALSE;
  private $error = array();
  
  function __construct($options = array())
  {
    $this->ci =& get_instance();

    $this->ci->config->item('tank_auth');
    $this->ci->load->library('email');

    // var_dump($this->ci->config->item('email')); die();
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

  function general($subject, $email_to, $type, $data, $reply_to = '', $reply_to_name = '')
  {
    $data['site_name'] = $this->ci->config->item('website_name', 'tank_auth');
    
    $message = $this->ci->load->view('email/'.$type.'-html', $data, TRUE);
    $alt_message = $this->ci->load->view('email/'.$type.'-txt', $data, TRUE);
    
    $this->_direct($subject, $email_to, $message, $alt_message, $reply_to, $reply_to_name);
  }
  
  function _direct($subject, $email_to, $message = '', $alt_message = '', $reply_to = '', $reply_to_name = '')
  {
    $site_name = $this->ci->config->item('website_name', 'tank_auth');

    $from = $this->ci->config->item('webmaster_email', 'tank_auth');
    $from_name = (!empty($reply_to_name) ? $reply_to_name.' via ' : '').$site_name;
    
    $this->ci->email->from($from, $from_name);
    if (!empty($reply_to)) $this->ci->email->reply_to($reply_to, $reply_to_name);

    $this->ci->email->to($email_to);

    // $this->ci->email->subject(sprintf($this->lang->line('auth_subject_'.$type), $site_name));
    $this->ci->email->subject($subject);
    
    $this->ci->email->message($message);
    $this->ci->email->set_alt_message($alt_message);

    if (ENVIRONMENT === 'development')
    {
      if ($this->debug)
      {
        var_dump($from, $from_name);
        var_dump($email_to, $subject);
        echo($message);
        var_dump($alt_message);
        // die();
      }
    }
    else
    {
      $this->ci->email->send();
      // echo $this->ci->email->print_debugger(); // die();
    }
  }
}