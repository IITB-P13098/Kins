<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<header>
  <nav class="navbar navbar-default" role="navigation"> <!-- navbar-fixed-top -->
    <div class="container">
      <?php
      if (!empty($logged_in_user)) echo $logged_in_user['username'].' ('.anchor('auth/signout', 'Sign out').')';
      else echo anchor('auth/signin', 'Sign in');
      ?>
    </div>
  </nav>
</header>