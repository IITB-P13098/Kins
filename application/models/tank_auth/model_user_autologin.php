<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model_user_Autologin
 *
 * This model represents user autologin data. It can be used
 * for user verification when user claims his autologin passport.
 *
 * @package   Tank_auth
 * @author    Ilya Konyukhov (http://konyukhov.com/soft/)
 */
class Model_user_autologin extends CI_Model
{
  private $user_autologin_table = 'user_autologin';
  private $user_table           = 'user';

  /**
   * Get user data for auto-logged in user.
   *
   * @param  int
   * @param  string
   * @return  object
   */
  function get($user_id, $autologin_key)
  {
    $this->db->select($this->user_table.'.user_id');
    $this->db->select($this->user_table.'.username');
    $this->db->from($this->user_table);
    $this->db->join($this->user_autologin_table, $this->user_autologin_table.'.user_id = '.$this->user_table.'.user_id');
    $this->db->where($this->user_autologin_table.'.user_id', $user_id);
    $this->db->where($this->user_autologin_table.'.autologin_key', $autologin_key);
    $query = $this->db->get();
    return $query->row_array();
  }

  /**
   * Save data for user's autologin
   *
   * @param  int
   * @param  string
   * @return  bool
   */
  function set($user_id, $autologin_key)
  {
    return $this->db->insert($this->user_autologin_table, array(
      'user_id'       => $user_id,
      'autologin_key' => $autologin_key,
      'user_agent'    => substr($this->input->user_agent(), 0, 149),
      'last_ip'       => $this->input->ip_address(),
    ));
  }

  /**
   * Delete user's autologin data
   *
   * @param  int
   * @param  string
   * @return  void
   */
  function delete($user_id, $autologin_key)
  {
    $this->db->where('user_id', $user_id);
    $this->db->where('autologin_key', $autologin_key);
    $this->db->delete($this->user_autologin_table);
  }

  /**
   * Delete all autologin data for given user
   *
   * @param  int
   * @return  void
   */
  function clear($user_id)
  {
    $this->db->where('user_id', $user_id);
    $this->db->delete($this->user_autologin_table);
  }

  /**
   * Purge autologin data for given user and login conditions
   *
   * @param  int
   * @return  void
   */
  function purge($user_id)
  {
    $this->db->where('user_id', $user_id);
    $this->db->where('user_agent', substr($this->input->user_agent(), 0, 149));
    $this->db->where('last_ip', $this->input->ip_address());
    $this->db->delete($this->user_autologin_table);
  }
}
/* End of file model_user_autologin.php */
/* Location: ./application/models/auth/model_user_autologin.php */