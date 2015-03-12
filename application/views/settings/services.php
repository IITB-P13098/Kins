<?php
if (!empty($this->session->flashdata('oauth_id')))
{
  $this->view('settings/add_actor_modal');
}
else
{
  $min_invites = $this->config->item('min_invites', 'social');
  if (FALSE) // ($invites_count < $min_invites)
  {
    ?>
    <p>
      <strong><?php echo anchor('promo/invite', 'Invite'); ?> <?php echo $min_invites; ?> or more to add more than one service</strong><br/>
      Add Facebook, Google or Microsoft account to sync contacts
    </p>
    <?php
  }
  else
  {
    $this->view('settings/add_service_modal');
  }
}
?>

<?php
if (!empty($actor_oauth_list))
{
  // var_dump($actor_oauth_list);
  $this->view('settings/actor_list', array('actor_oauth_list' => $actor_oauth_list));
}
?>