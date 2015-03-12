<?php
$this->load->config('form_input', TRUE);

if (empty($value)) $value = NULL;

$email = array(
  'name'          => 'email',
  'id'            => 'email',
  'value'         => set_value('email', $value),
  'maxlength'     => $this->config->item('email_max_length', 'form_input'),
  
  'class'         => 'form-control',

  // html5 tag - not supported in Internet Explorer 9 and earlier versions.
  'placeholder'   => 'What\'s your email address? Email will not be publicly displayed.',
  'required'      => NULL,
  'type'          => 'email',
);

$form_error = form_error($email['name']);
if (!empty($form_error)) $error[$email['name']] = $form_error;
if (!empty($error[$email['name']])) $email['id'] = 'inputError';
?>

<div class="form-group <?php if (!empty($error[$email['name']])) echo 'has-error'; ?>">
  <?php echo form_label('Email Address', $email['id'], array('class' => 'control-label')); ?>
  <?php echo form_input($email); ?>
  <?php if (!empty($error[$email['name']])) { ?><span class="help-block"><?php echo $error[$email['name']]; ?></span><?php } ?>
</div>
