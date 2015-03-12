<?php
$this->load->config('form_input', TRUE);

$password = array(
  'name'          => 'password',
  'id'            => 'password',
  'value'         => set_value('password'),
  'maxlength'     => $this->config->item('password_max_length', 'form_input'),

  'class'         => 'form-control',

  // html5 tag - not supported in Internet Explorer 9 and earlier versions.
  'placeholder'   => $this->config->item('password_min_length', 'form_input').' characters or more! Be tricky.',
  'required'      => NULL,
);

$form_error = form_error($password['name']);
if (!empty($form_error)) $error[$password['name']] = $form_error;
if (!empty($error[$password['name']])) $password['id'] = 'inputError';
?>

<div class="form-group <?php if (!empty($error[$password['name']])) echo 'has-error'; ?>">
  <?php echo form_label('Password', $password['id'], array('class' => 'control-label')); ?>
  <?php echo form_password($password); ?>
  <?php if (!empty($error[$password['name']])) { ?><span class="help-block"><?php echo $error[$password['name']]; ?></span><?php } ?>
</div>