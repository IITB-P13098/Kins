<?php
$this->load->config('form_input', TRUE);

$old_password = array(
  'name'          => 'old_password',
  'id'            => '',
  'value'         => set_value('old_password'),
  'maxlength'     => $this->config->item('password_max_length', 'form_input'),

  'class'         => 'form-control',

  // html5 tag - not supported in Internet Explorer 9 and earlier versions.
  'placeholder'   => 'What is your password?',
  'required'      => NULL,
);

$form_error = form_error($old_password['name']);
if (!empty($form_error)) $error[$old_password['name']] = $form_error;
if (!empty($error[$old_password['name']])) $old_password['id'] = 'inputError';
?>

<div class="form-group <?php if (!empty($error[$old_password['name']])) echo 'has-error'; ?>">
  <?php echo form_label('Old Password', $old_password['id'], array('class' => 'control-label')); ?>
  <?php echo form_password($old_password); ?>
  <?php if (!empty($error[$old_password['name']])) { ?><span class="help-block"><?php echo $error[$old_password['name']]; ?></span><?php } ?>
</div>