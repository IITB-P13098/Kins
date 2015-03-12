<?php
$this->load->config('form_input', TRUE);

if (empty($value)) $value = NULL;

$full_name = array(
  'name'          => 'full_name',
  'id'            => 'full_name',
  'value'         => set_value('full_name', $value),
  'maxlength'     => $this->config->item('full_name_max_length', 'form_input'),
  
  'class'         => 'form-control',
  
  // html5 tag - not supported in Internet Explorer 9 and earlier versions.
  'placeholder'   => 'Enter your real name, so people you know can recognize you.',
  'required'      => NULL,
);

$form_error = form_error($full_name['name']);
if (!empty($form_error)) $error[$full_name['name']] = $form_error;
if (!empty($error[$full_name['name']])) $full_name['id'] = 'inputError';
?>

<div class="form-group <?php if (!empty($error[$full_name['name']])) echo 'has-error'; ?>">
  <?php echo form_label('Full Name', $full_name['id'], array('class' => 'control-label')); ?>
  <?php echo form_input($full_name); ?>
  <?php if (!empty($error[$full_name['name']])) { ?><span class="help-block"><?php echo $error[$full_name['name']]; ?></span><?php } ?>
</div>
