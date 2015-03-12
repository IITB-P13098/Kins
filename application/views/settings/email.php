<p>Primary email: <strong><?php echo $user_email; ?></strong></p>

<?php echo form_open(uri_string()); ?>

<?php
$this->view('form/input_email', array('value' => $email_value));
?>

<div class="row">
  <div class="col-sm-5">
    <button type="submit" class="btn btn-primary btn-block">Update</button>
  </div>
</div>

<?php echo form_close(); ?>