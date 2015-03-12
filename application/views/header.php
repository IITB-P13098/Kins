<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<header>
  <nav class="navbar navbar-default" role="navigation"> <!-- navbar-fixed-top -->
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo base_url(); ?>">
          <!-- <img src="http://placehold.it/142x35&text=logo"> -->
          <?php echo $this->config->item('website_name', 'tank_auth'); ?>
        </a>
      </div>

      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
          <li>
            <?php
            if (!empty($logged_in_user)) echo anchor('settings', $logged_in_user['username']);
            ?>
          </li>
          <li>
            <?php
            if (!empty($logged_in_user)) echo anchor('auth/signout', 'Sign out');
            else echo anchor('auth/signin', 'Sign in');
            ?>
          </li>
        </ul>
      </div>
      
    </div>
  </nav>
</header>