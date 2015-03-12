<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<!--
Page rendered in {elapsed_time} seconds, {memory_usage} size.
<?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version ' . CI_VERSION . '' : ''; ?>.
-->
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Welcome to CodeIgniter</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
  </head>
  <body>
    <?php $this->load->view('header'); ?>
    <section class="main">
      <div class="container">
        <div class="row">
          <?php echo $main_content; ?>
        </div>
      </div>
    </section>
  </body>
</html>