<?php
if (empty($checkbox_remeber_value)) $checkbox_remeber_value = NULL;

$remember = array(
  'name'          => 'remember',
  'id'            => 'remember',
  'value'         => $checkbox_remeber_value,
  'checked'       => set_value('remember', $checkbox_remeber_value),
);
?>

<div class="checkbox">
  <label class="control-label">
  <?php echo form_checkbox($remember); ?> Remember me
  </label>
</div>