<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model_user
 *
 * This model represents user authentication data. It operates the following tables:
 * - user account data,
 * - user profiles
 *
 * @package   Tank_auth
 * @author    Ilya Konyukhov (http://konyukhov.com/soft/)
 */
class Model_user extends CI_Model
{
  private $user_table = 'user';  // user accounts
  private $people_graph_table = 'people_graph';

  function get_user_by_id($user_id)
  {
    $this->db->where('user_id', $user_id);

    $query = $this->db->get($this->user_table);
    return $query->row_array();
  }

  function get_user_by_username($username, $visit_user_id = 0)
  {
    $this->db->select($this->user_table.'.*');
    
    if (!empty($visit_user_id))
    {
      $this->db->select($this->people_graph_table.'.activity_id AS is_following');

      // not required
      // $this->db->join($this->people_graph_table, $this->people_graph_table.'.follow_user_id = '.$this->user_table.'.user_id AND '.$this->people_graph_table.'.user_id = '.$visit_user_id.' AND '.$this->people_graph_table.'.follow_user_id != '.$this->people_graph_table.'.user_id', 'LEFT');
      
      $this->db->join($this->people_graph_table, $this->people_graph_table.'.follow_user_id = '.$this->user_table.'.user_id AND '.$this->people_graph_table.'.user_id = '.$visit_user_id, 'LEFT');
    }
    $this->db->where('LOWER(username)=', strtolower($username));

    $query = $this->db->get($this->user_table);
    return $query->row_array();
  }

  function get_user_batch_by_id($user_id_list, $visit_user_id = 0)
  {
    $this->db->select($this->user_table.'.*');

    if (!empty($visit_user_id))
    {
      $this->db->select($this->people_graph_table.'.activity_id AS is_following');

      // not required
      // $this->db->join($this->people_graph_table, $this->people_graph_table.'.follow_user_id = '.$this->user_table.'.user_id AND '.$this->people_graph_table.'.user_id = '.$visit_user_id.' AND '.$this->people_graph_table.'.follow_user_id != '.$this->people_graph_table.'.user_id', 'LEFT');
      
      $this->db->join($this->people_graph_table, $this->people_graph_table.'.follow_user_id = '.$this->user_table.'.user_id AND '.$this->people_graph_table.'.user_id = '.$visit_user_id, 'LEFT');
    }
    $this->db->where_in($this->user_table.'.user_id', $user_id_list);

    $query = $this->db->get($this->user_table);
    return $query->result_array();
  }

  function get_user_batch_by_username($username_list)
  {
    $this->db->where_in('LOWER(username)', $username_list);

    $query = $this->db->get($this->user_table);
    return $query->result_array();
  }

  // function get_user_by_email($email)
  // {
  //   $this->db->where('LOWER(email)=', strtolower($email));

  //   $query = $this->db->get($this->user_table);
  //   return $query->row_array();
  // }

  // function is_username_available($username)
  // {
  //   $this->db->where('LOWER(username)=', strtolower($username));

  //   $query = $this->db->get($this->user_table);
  //   return $query->num_rows() == 0;
  // }

  function create($data)
  {
    // $this->db->set('created', 'CURRENT_TIMESTAMP()', FALSE);

    $this->db->insert($this->user_table, $data);    
    return $this->db->insert_id();
  }

  function delete_user($user_id)
  {
    $this->db->where('user_id', $user_id);
    $this->db->delete($this->user_table);
    if ($this->db->affected_rows() > 0) {
      $this->delete($user_id);
      return TRUE;
    }
    return FALSE;
  }

  function update_username($user_id, $new_username)
  {
    $this->db->set('username', $new_username);
    $this->db->where('user_id', $user_id);
    
    $this->db->update($this->user_table);
    return $this->db->affected_rows() > 0;
  }

  function update($user_id, $data)
  {
    $this->db->where('user_id', $user_id);
    $this->db->update($this->user_table, $data);
  }

  function update_profile_image_url($user_id, $profile_image_url)
  {
    $this->db->set('profile_image_url', $profile_image_url);

    $this->db->where('user_id', $user_id);
    // $this->db->where('profile_image_url IS NULL');

    $this->db->update($this->user_table);
  }

  function update_stats_posts_count($user_id, $posts_count)
  {
    $this->db->set('posts_count', $posts_count);
    $this->db->where('user_id', $user_id);

    $this->db->update($this->user_table);
  }
}
/* End of file model_user.php */
/* Location: ./application/models/auth/model_user.php */