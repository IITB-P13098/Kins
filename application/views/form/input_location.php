<?php
$this->load->config('form_input', TRUE);

if (empty($value)) $value = NULL;

$location = array(
  'name'          => 'location',
  'id'            => 'location',
  'value'         => set_value('location', $value),
  'maxlength'     => $this->config->item('location_max_length', 'form_input'),
  
  'class'         => 'form-control',

  // html5 tag - not supported in Internet Explorer 9 and earlier versions.
  'placeholder'   => 'Where in the world are you?',
);

$form_error = form_error($location['name']);
if (!empty($form_error)) $error[$location['name']] = $form_error;
if (!empty($error[$location['name']])) $location['id'] = 'inputError';
?>

<div class="form-group <?php if (!empty($error[$location['name']])) echo 'has-error'; ?>">
  <?php echo form_label('Location', $location['id'], array('class' => 'control-label')); ?>
  <?php echo form_input($location); ?>
  <?php if (!empty($error[$location['name']])) { ?><span class="help-block"><?php echo $error[$location['name']]; ?></span><?php } ?>
</div>