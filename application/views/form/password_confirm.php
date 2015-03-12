<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
$this->load->config('form_input', TRUE);

$confirm_password = array(
  'name'          => 'confirm_password',
  'id'            => 'confirm_password',
  'value'         => set_value('confirm_password'),
  'maxlength'     => $this->config->item('password_max_length', 'form_input'),

  'class'         => 'form-control',

  // html5 tag - not supported in Internet Explorer 9 and earlier versions.
  'placeholder'   => 'Retype that again!',
  'required'      => NULL,
);

$form_error = form_error($confirm_password['name']);
if (!empty($form_error)) $error[$confirm_password['name']] = $form_error;
if (!empty($error[$confirm_password['name']])) $confirm_password['id'] = 'inputError';
?>

<div class="form-group <?php if (!empty($error[$confirm_password['name']])) echo 'has-error'; ?>">
  <?php echo form_label('Confirm Password', $confirm_password['id'], array('class' => 'control-label')); ?>
  <?php echo form_password($confirm_password); ?>
  <?php if (!empty($error[$confirm_password['name']])) { ?><span class="help-block"><?php echo $error[$confirm_password['name']]; ?></span><?php } ?>
</div>
