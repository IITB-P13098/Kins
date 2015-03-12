<?php
$this->load->config('form_input', TRUE);

if (empty($value)) $value = NULL;

$username = array(
  'name'          => 'username',
  'id'            => 'username',
  'value'         => set_value('username', $value),
  'maxlength'     => $this->config->item('username_max_length', 'form_input'),

  'class'         => 'form-control',

  // html5 tag - not supported in Internet Explorer 9 and earlier versions.
  'placeholder'   => 'Don\'t worry, you can change it later.',
  'required'      => NULL,
);

$form_error = form_error($username['name']);
if (!empty($form_error)) $error[$username['name']] = $form_error;
if (!empty($error[$username['name']])) $username['id'] = 'inputError';
?>

<div class="form-group <?php if (!empty($error[$username['name']])) echo 'has-error'; ?>">
  <?php echo form_label('Username', $username['id'], array('class' => 'control-label')); ?>
  <div class="input-group">
    <span class="input-group-addon">@</span>
    <?php echo form_input($username); ?>
  </div>
  <?php if (!empty($error[$username['name']])) { ?><span class="help-block"><?php echo $error[$username['name']]; ?></span><?php } ?>
</div>