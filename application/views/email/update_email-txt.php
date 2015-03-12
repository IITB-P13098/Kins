<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
Hi <?php echo $full_name; ?> (<?php echo '@'.$username;?>),

You have changed your email address for <?php echo $site_name; ?>.
Your new email: <?php echo $email; ?>


If you didn't make this change, please let us know:
<?php echo base_url('home/faq'); ?>


Thanks!
- The <?php echo $site_name; ?> Team