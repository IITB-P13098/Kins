<script type="text/javascript">
 var RecaptchaOptions = {
    theme : 'white',
 };
</script>

<div class="form-group <?php if (!empty($error['captcha'])) echo 'has-error'; ?>">
  <?php
  if (isset($recaptcha_html))
  {
    echo $recaptcha_html;
  }
  ?>
  <?php if (!empty($error['captcha'])) { ?><span class="help-block"><?php echo $error['captcha']; ?></span><?php } ?>
</div>