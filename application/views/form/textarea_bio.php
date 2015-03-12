<?php
$this->load->config('form_input', TRUE);

if (empty($value)) $value = NULL;

$bio = array(
  'name'          => 'bio',
  'id'            => 'bio',
  'value'         => set_value('bio', html_entity_decode($value), FALSE),
  'maxlength'     => $this->config->item('bio_max_length', 'form_input'),
  'style'         => 'resize: none',
  'rows'          => 4,

  'class'         => 'form-control',

  // html5 tag - not supported in Internet Explorer 9 and earlier versions.
  'placeholder'   => 'About yourself in '.$this->config->item('bio_max_length', 'form_input').' characters or less.',
);

$form_error = form_error($bio['name']);
if (!empty($form_error)) $error[$bio['name']] = $form_error;
if (!empty($error[$bio['name']])) $bio['id'] = 'inputError';
?>

<div class="form-group <?php if (!empty($error[$bio['name']])) echo 'has-error'; ?>">
  <?php echo form_label('Bio', $bio['id'], array('class' => 'control-label')); ?>
  <?php echo form_textarea($bio); ?>
  <?php if (!empty($error[$bio['name']])) { ?><span class="help-block"><?php echo $error[$bio['name']]; ?></span><?php } ?>
</div>