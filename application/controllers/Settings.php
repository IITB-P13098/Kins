<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    
    $this->data = array();
    
    $this->load->library('tank_auth/lib_user_login');    
    $logged_in_user = $this->lib_user_login->get_user();
    
    if (empty($logged_in_user))
    {
      if (!$this->input->is_ajax_request())
      {
        redirect('auth/signin?redirect='.rawurlencode(uri_string()));
      }
      else show_error('user must sign in');
    }
    
    $this->data['page_title'] = 'Account Settings';
    
    $this->data['logged_in_user'] = $logged_in_user;

    //$this->load->library('lib_ip_location');
    //$this->data['footer']['country'] = $this->lib_ip_location->get_country();
  }
  
  public function index()
  {
    redirect('settings/account'); // $this->account();
  }

  public function account()
  {
    $local_data = array();
    
    $this->load->helper(array('form'));
    $this->load->library(array('form_validation', 'tank_auth/lib_user'));
    
    $local_data = $this->data['logged_in_user'];
    
    // $local_data['bio'] = $local_data['bio'];
    // var_dump($local_data);die();

    if ($this->form_validation->run())
    {
      if ($this->lib_user->update(
        $this->data['logged_in_user']['user_id'],
        $this->form_validation->set_value('full_name'),
        $this->form_validation->set_value('bio'),
        $this->form_validation->set_value('location')
        ))
      {
        $this->session->set_flashdata('alert', '<strong>Success:</strong> Your details are saved. <strong>'.anchor('user/'.$local_data['username'], 'Me', 'class="link-dark"').'</strong>');
        redirect(uri_string());
      }
      else
      {
        $local_data['error'] = $this->lib_user->get_error_message();
      }
    }
    
    $this->data['main_content'] = $this->load->view('settings/profile', $local_data, TRUE);
    $this->data['main_content'] = $this->load->view('settings/base', $this->data, TRUE);
    $this->load->view('base', $this->data);
  }
  
  public function username()
  {
    $local_data = array();
    
    $this->load->helper(array('form'));
    $this->load->library(array('form_validation', 'tank_auth/lib_user'));
    
    $this->load->config('tank_auth', TRUE);
    
    $local_data['username_value'] = $this->data['logged_in_user']['username'];

    if ($this->form_validation->run())
    {
      if (!is_null($this->lib_user->update_username(
        $this->data['logged_in_user']['user_id'],
        $this->form_validation->set_value('username')
        )))
      {
        $this->session->set_flashdata('alert', '<strong>Success</strong> Your username is updated.');
        redirect(uri_string());
      }
      else
      {
        $local_data['error'] = $this->lib_user->get_error_message();
      }
    }
    
    $this->data['main_content'] = $this->load->view('settings/username', $local_data, TRUE);
    $this->data['main_content'] = $this->load->view('settings/base', $this->data, TRUE);
    $this->load->view('base', $this->data);
  }
  
  public function email()
  {
    $local_data = array();
    
    $this->load->helper(array('form'));
    $this->load->library(array('form_validation'));
    
    $this->load->config('tank_auth', TRUE);
    
    $logged_in_user_email = $this->lib_user_login->get_email_by_id($this->data['logged_in_user']['user_id']);
    $old_email = $logged_in_user_email['email'];

    $local_data['user_email'] = $old_email;
    $local_data['email_value'] = '';
    
    if ($logged_in_user_email['verified'] == 0)
    {
      $local_data['alert'] = 'Email <strong>'.$old_email.'</strong> is not verified!<br>'.anchor('settings/resend_email_key', 'Resend verification', 'class="link-light small"');
    }
    
    if ($this->form_validation->run())
    {
      $new_email = $this->form_validation->set_value('email');

      if (!is_null($email_key = $this->lib_user_login->update_email(
        $this->data['logged_in_user']['user_id'],
        $new_email
      )))
      {
        $send_email_data                = $this->data['logged_in_user'];
        $send_email_data['old_email']   = $old_email;
        $send_email_data['email']       = $new_email;
        $send_email_data['email_key']   = $email_key;

        $this->load->library('lib_send_email');
        $this->lib_send_email->general('Verify your new email address', $new_email, 'verify_email', $send_email_data);

        $this->lib_send_email->general('Your email address is changed', $old_email, 'update_email', $send_email_data);

        $this->session->set_flashdata('alert', 'Check mail to verify <strong>'.$new_email.'</strong>');
        redirect(uri_string());
      }
      else
      {
        $local_data['error'] = $this->lib_user_login->get_error_message();
      }
    }
    
    $this->data['main_content'] = $this->load->view('settings/email', $local_data, TRUE);
    $this->data['main_content'] = $this->load->view('settings/base', $this->data, TRUE);
    $this->load->view('base', $this->data);
  }

  public function resend_email_key()
  {
    $user_id = $this->data['logged_in_user']['user_id'];

    $logged_in_user_email = $this->lib_user_login->get_email_by_id($user_id);

    if (!is_null($email_key = $this->lib_user_login->resend_email_key($user_id)))
    {
      $send_email_data                = $this->data['logged_in_user'];
      $send_email_data['email_key']   = $email_key;

      $this->load->library('lib_send_email');
      $this->lib_send_email->general('Verify your new email address', $logged_in_user_email['email'], 'verify_email', $send_email_data);

      $this->session->set_flashdata('alert', 'Check mail to verify <strong>'.$logged_in_user_email['email'].'</strong>');
    }
    redirect(base_url('settings/email'));
  }
  
  public function password()
  {
    $local_data = array();
    
    $this->load->helper(array('form'));
    $this->load->library(array('form_validation'));
    
    $this->load->config('tank_auth', TRUE);
    
    $logged_in_user_email = $this->lib_user_login->get_email_by_id($this->data['logged_in_user']['user_id']);

    if ($this->form_validation->run())
    {
      if (!is_null($this->lib_user_login->update_password(
        $this->data['logged_in_user']['user_id'],
        $this->form_validation->set_value('old_password'),
        $this->form_validation->set_value('password')
        )))
      {
        $send_email_data = $this->data['logged_in_user'];

        $this->load->library('lib_send_email');
        $this->lib_send_email->general('You have chaned your password', $logged_in_user_email['email'], 'reset_password', $send_email_data);

        $this->session->set_flashdata('alert', '<strong>Updated:</strong> Your password is updated successfully.');
        redirect(uri_string());
      }
      else
      {
        $local_data['error'] = $this->lib_user_login->get_error_message();
      }
    }
    
    $this->data['main_content'] = $this->load->view('settings/password', $local_data, TRUE);
    $this->data['main_content'] = $this->load->view('settings/base', $this->data, TRUE);
    $this->load->view('base', $this->data);
  }
}