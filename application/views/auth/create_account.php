<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php echo form_open(uri_string()); ?>

<?php 
$this->view('form/input_full_name');
$this->view('form/input_username');
$this->view('form/input_email');
$this->view('form/password');

$this->view('form/html_captcha');
?>

<div class="row">
  <div class="col-sm-5">
    <button type="submit" class="btn btn-primary btn-block">Create Account</button>
  </div>
</div>

<?php echo form_close(); ?>

<br>
<p>If you already have an account, use that account to <?php echo anchor('auth/signin', 'sign in'); ?>.</p>