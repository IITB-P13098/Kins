<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
Hi <?php echo $full_name; ?> (<?php echo '@'.$username;?>),

Verify your email address, here:
<?php echo base_url('auth/verify_email/'.$user_id.'/'.$email_key); ?>


Thanks for joining.
- The <?php echo $site_name; ?> Team