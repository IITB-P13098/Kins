<?php
$nav_links = array(
  'account'           => array('Basic'        , 'settings/account'),
  'username'          => array('Username'     , 'settings/username'),
  'email'             => array('Email'        , 'settings/email'),
  'password'          => array('Password'     , 'settings/password'),
);
?>

<div class="col-sm-4">
  <?php
  if (empty($selected_nav)) $selected_nav = strtolower($this->uri->segment(2));
  if (empty($selected_nav)) $selected_nav = NULL;

  if (!empty($nav_links))
  {
    ?>
    <ul class="nav nav-pills nav-stacked">
      <?php
      foreach ($nav_links as $nav_key => $nav)
      {
        ?>
        <li <?php if ($selected_nav === $nav_key) echo 'class="active"';?> ><?php echo anchor($nav[1], $nav[0]); ?></li>
        <?php
      }
      ?>
    </ul>
    <br>
    <br>
    <?php
  }
  ?>
</div>

<div class="col-sm-8">
  <h1><?php echo $page_title; ?></h1>

  <div class="settings">
  <?php
  if (!empty($this->session->flashdata('alert')))
  {
    $alert = $this->session->flashdata('alert');
  }

  if (!empty($alert))
  {
    ?>
    <div class="alert alert-warning alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <?php echo $alert; ?>
    </div>
    <?php
  }
  ?>
  
  <?php echo $main_content; ?>
  </div>

</div>