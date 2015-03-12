<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php echo form_open(uri_string()); ?>

<?php 
$this->view('form/input_login');
$this->view('form/password');

$this->view('form/checkbox_remember', array('checkbox_remeber_value' => 1));

$this->view('form/html_captcha');
?>

<div class="row">
  <div class="col-sm-5">
    <button type="submit" class="btn btn-primary btn-block">Sign in</button>
  </div>
</div>

<?php echo form_close(); ?>

<!-- <div style="margin-top: 20px">
  <?php echo anchor('/auth/forgot_password/', 'Forgot your password?'); ?>
</div> -->

<br><br>
<p><?php echo anchor('/auth/forgot_password/', 'Can&#39;t access your account?'); ?></p>
<p>Don't have an account? <strong><?php echo anchor('auth/create_account', 'Sign up now'); ?></strong></p>