<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model_login_attempt
 *
 * This model serves to watch on all attempts to login on the site
 * (to protect the site from brute-force attack to user database)
 *
 * @package   Tank_auth
 * @author    Ilya Konyukhov (http://konyukhov.com/soft/)
 */
class Model_login_attempt extends CI_Model
{
  private $login_attempt_table = 'login_attempt';

  function __construct()
  {
    parent::__construct();

    //$ci =& get_instance();
    //$this->login_attempt_table = $ci->config->item('db_table_prefix', 'tank_auth').$this->login_attempt_table;
  }

  /**
   * Get number of attempts to login occured from given IP-address or login
   *
   * @param  string
   * @param  string
   * @return  int
   */
  function get_attempts_num($ip_address, $login)
  {
    $this->db->where('ip_address', $ip_address);
    if (strlen($login) > 0) $this->db->or_where('login', $login);

    $qres = $this->db->get($this->login_attempt_table);
    return $qres->num_rows();
  }

  /**
   * Increase number of attempts for given IP-address and login
   *
   * @param  string
   * @param  string
   * @return  void
   */
  function increase_attempt($ip_address, $login)
  {
    $this->db->insert($this->login_attempt_table, array('ip_address' => $ip_address, 'login' => $login));
  }

  /**
   * Clear all attempt records for given IP-address and login.
   * Also purge obsolete login attempts (to keep DB clear).
   *
   * @param  string
   * @param  string
   * @param  int
   * @return  void
   */
  function clear_attempts($ip_address, $login, $expire_period = 86400)
  {
    $this->db->where(array('ip_address' => $ip_address, 'login' => $login));

    // Purge obsolete login attempts
    $this->db->or_where('TIMESTAMPDIFF(SECOND, time, CURRENT_TIMESTAMP()) > '.$expire_period);

    $this->db->delete($this->login_attempt_table);
  }
}
/* End of file login_attempts.php */
/* Location: ./application/models/auth/login_attempts.php */