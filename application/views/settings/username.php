<p><?php echo base_url().'<strong>'.'user/'.$username_value.'</strong>'; ?></p>

<?php echo form_open(uri_string()); ?>

<?php
$this->view('form/input_username', array('value' => $username_value));
?>

<div class="row">
  <div class="col-sm-5">
    <button type="submit" class="btn btn-primary btn-block">Change</button>
  </div>
</div>

<?php echo form_close(); ?>