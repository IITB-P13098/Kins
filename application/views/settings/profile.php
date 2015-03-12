<?php // $this->view('settings/profile_image'); ?>

<br>

<?php echo form_open(uri_string()); ?>

<?php
$this->view('form/input_full_name', array('value' => $full_name));
$this->view('form/textarea_bio',    array('value' => $bio));
$this->view('form/input_location',  array('value' => $location));
?>

<div class="row">
  <div class="col-sm-5">
    <button type="submit" class="btn btn-primary btn-block">Update</button>
  </div>
</div>

<?php echo form_close(); ?>