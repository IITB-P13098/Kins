<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_user
{
  private $error = array();
  
  function __construct()
  {
    $this->ci =& get_instance();
        
    $this->ci->load->model('tank_auth/model_user');
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

  function get_by_id($user_id, $visit_user_id = 0, $fill_more = FALSE)
  {
    $user = $this->ci->model_user->get_user_by_id($user_id);
    if (empty($user))
    {
      $this->error = array('message' => 'invalid user id');
      return NULL;
    }
    
    return $this->_fill_common($user, $visit_user_id);
  }
  
  function get_by_username($username, $visit_user_id = 0, $fill_more = FALSE)
  {
    $user = $this->ci->model_user->get_user_by_username($username, $visit_user_id);
    if (empty($user))
    {
      $this->error = array('message' => 'invalid username');
      return NULL;
    }

    return $this->_fill_common($user, $visit_user_id);
  }

  function _fill_common($user = array(), $visit_user_id = 0, $fill_more = FALSE)
  {
    $user['is_following'] = !empty($user['is_following']) ? TRUE : FALSE;

    if ($user['user_id'] == $visit_user_id) $user['is_following'] = 'you';

    $this->ci->load->library('social/lib_text_process');
    $user['bio_html'] = $this->ci->lib_text_process->output($user['bio']);

    return $user;

    // if (!$fill_more) return $user;
    
    // $this->ci->load->library('social/lib_text_process');
    // $user['bio_text_data'] = $this->ci->lib_text_process->output($user['bio']);
  }
  
  function _get_batch_by_id($user_id_list, $visit_user_id = 0)
  {
    $this->ci->load->library('social/lib_text_process');

    $user_list = $this->ci->model_user->get_user_batch_by_id($user_id_list, $visit_user_id);
    
    $t_user_list = array();
    foreach ($user_list as $user)
    {
      $user = $this->_fill_common($user, $visit_user_id);
      $t_user_list[ $user['user_id'] ] = $user;
    }

    return $t_user_list;
  }

  function fill_user($list = array(), $visit_user_id = 0)
  {
    // var_dump($visit_user_id); die();

    // get user from user_id
    $user_id_list = array();
    foreach ($list as $f) if (!empty($f['user_id'])) $user_id_list[$f['user_id']] = $f['user_id'];

    if (empty($user_id_list)) return $list;

    $user_list = $this->_get_batch_by_id($user_id_list, $visit_user_id);

    foreach ($list as $key => $f)
    {
      if (!empty($f['user_id'])) $list[$key]['user'] = $user_list[$f['user_id']];
    }

    return $list;
  }

  function update($user_id, $full_name, $bio, $location)
  {
    // $this->ci->load->library('social/lib_text_process');
    // $text_data = $this->ci->lib_text_process->input($bio);
    
    $data = array(
      'full_name'         => $full_name,
      'bio'               => $bio,
      'location'          => $location,
    );
    
    $this->ci->model_user->update($user_id, $data);
    return TRUE;
  }

  function update_username($user_id, $new_username)
  {
    $this->ci->model_user->update_username($user_id, $new_username);
    return TRUE;
  }

  function update_profile_image_url($user_id, $profile_image_url)
  {
    if (!empty($profile_image_url))
    {
      $this->ci->model_user->update_profile_image_url($user_id, $profile_image_url);
    }
  }
  
  public function update_steps_completed($user_id, $percent_progress)
  {
    $this->ci->model_user->update($user_id, array('steps_completed' => $percent_progress));
  }

  public function update_stats_posts_count($user_id)
  {
    $this->ci->load->library('social/lib_post_feed');
    $posts_count = $this->ci->lib_post_feed->get_posts_count($user_id);

    $this->ci->model_user->update_stats_posts_count($user_id, $posts_count);
  }
}