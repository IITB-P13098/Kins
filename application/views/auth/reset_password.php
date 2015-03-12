<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php echo form_open(uri_string()); ?>

<?php 
$this->view('form/password');
$this->view('form/password_confirm');
?>

<div class="row">
  <div class="col-sm-5">
    <button type="submit" class="btn btn-primary btn-block">Change Password</button>
  </div>
</div>

<?php echo form_close(); ?>