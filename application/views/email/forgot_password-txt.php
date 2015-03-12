Hi <?php echo $full_name; ?> (<?php echo '@'.$username;?>),

Forgot your password, huh? No big deal.
You can set a new password here:
<?php echo base_url('auth/reset_password/'.$user_id.'/'.$password_key); ?>


If you did not request a new password then please ignore this message.

Thanks!
- The <?php echo $site_name; ?> Team