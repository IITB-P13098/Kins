<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_user_login extends CI_Model
{
  private $user_table       = 'user';
  private $user_login_table = 'user_login';

  function get_user_by_login($login)
  {
    $this->db->join($this->user_login_table, $this->user_login_table.'.user_id = '.$this->user_table.'.user_id');
    
    $this->db->where('LOWER(username)=', strtolower($login));
    $this->db->or_where('LOWER(email)=', strtolower($login));
    
    $query = $this->db->get($this->user_table);
    return $query->row_array();
  }

  function get_user_by_id($user_id)
  {
    $this->db->join($this->user_login_table, $this->user_login_table.'.user_id = '.$this->user_table.'.user_id');
    $this->db->where($this->user_table.'.user_id', $user_id);

    $query = $this->db->get($this->user_table);
    return $query->row_array();
  }

  function get_email_by_id($user_id)
  {
    $this->db->select($this->user_login_table.'.email');
    $this->db->select($this->user_login_table.'.verified');

    $this->db->join($this->user_login_table, $this->user_login_table.'.user_id = '.$this->user_table.'.user_id');
    $this->db->where($this->user_table.'.user_id', $user_id);

    $query = $this->db->get($this->user_table);
    return $query->row_array();
  }

  // function is_email_available($email)
  // {
  //   $this->db->where('LOWER(email)=', strtolower($email));

  //   $query = $this->db->get($this->user_login_table);
  //   return $query->num_rows() == 0;
  // }

  function create($user_id, $login_data)
  {
    $login_data['user_id'] = $user_id;

    $this->db->insert($this->user_login_table, $login_data);    
    return $this->db->insert_id();
  }

  function update_password_key($user_id, $password_key)
  {
    $this->db->set('password_key', $password_key);
    $this->db->where('user_id', $user_id);

    $this->db->update($this->user_login_table);
    return $this->db->affected_rows() > 0;
  }

  function reset_password($user_id, $password, $password_key)
  {
    $this->db->set('password', $password);
    $this->db->set('password_key', NULL);

    $this->db->where('user_id', $user_id);
    $this->db->where('password_key', $password_key);

    $this->db->update($this->user_login_table);
    return $this->db->affected_rows() > 0;
  }

  function update_password($user_id, $password)
  {
    $this->db->set('password', $password);
    $this->db->where('user_id', $user_id);

    $this->db->update($this->user_login_table);
  }

  function update_email_key($user_id, $email_key)
  {
    $this->db->set('email_key', $email_key);
    $this->db->where('user_id', $user_id);
    $this->db->where('verified', 0);

    $this->db->update($this->user_login_table);
    return $this->db->affected_rows() > 0;
  }

  function update_email($user_id, $email, $email_key)
  {
    $this->db->set('email', $email);
    $this->db->set('email_key', $email_key);
    $this->db->set('verified', 0);

    $this->db->where('user_id', $user_id);

    $this->db->update($this->user_login_table);
  }

  function verify_email($user_id, $email_key)
  {
    $this->db->set('verified', 1);
    $this->db->set('email_key', NULL);

    $this->db->where('user_id', $user_id);
    $this->db->where('email_key', $email_key);

    $this->db->update($this->user_login_table);
    return $this->db->affected_rows() > 0;
  }

  // deprecated configs:
  // $this->ci->config->item('login_record_ip', 'tank_auth'),
  // $this->ci->config->item('login_record_time', 'tank_auth')
  function update_login_info($user_id)
  {
    $this->db->set('last_ip', $this->input->ip_address());
    $this->db->set('last_login', 'CURRENT_TIMESTAMP()', FALSE);

    $this->db->where('user_id', $user_id);
    $this->db->update($this->user_login_table);
  }

  function ban_user($user_id, $reason = NULL)
  {
    $this->db->where('user_id', $user_id);
    $this->db->update($this->user_login_table, array(
      'banned'      => 1,
      'ban_reason'  => $reason,
    ));
  }

  function unban_user($user_id)
  {
    $this->db->where('user_id', $user_id);
    $this->db->update($this->user_login_table, array(
      'banned'      => 0,
      'ban_reason'  => NULL,
    ));
  }
}