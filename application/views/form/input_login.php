<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
$this->load->config('form_input', TRUE);

$login = array(
  'name'          => 'login',
  'id'            => 'login',
  'value'         => set_value('login'),
  'maxlength'     => max($this->config->item('username_max_length', 'form_input'), $this->config->item('email_max_length', 'form_input')),

  'class'         => 'form-control',

  // html5 tag - not supported in Internet Explorer 9 and earlier versions.
  'placeholder'   => 'Enter your login.',
  'required'      => NULL,
);

// $login_label = $this->config->item('use_username', 'tank_auth') ? 'Username / Email' : 'Email';

$form_error = form_error($login['name']);
if (!empty($form_error)) $error[$login['name']] = $form_error;
if (!empty($error[$login['name']])) $login['id'] = 'inputError';
?>

<div class="form-group <?php if (!empty($error[$login['name']])) echo 'has-error'; ?>">
  <?php echo form_label('Username / Email', $login['id'], array('class' => 'control-label')); ?>
  <?php echo form_input($login); ?>
  <?php if (!empty($error[$login['name']])) { ?><span class="help-block"><?php echo $error[$login['name']]; ?></span><?php } ?>
</div>