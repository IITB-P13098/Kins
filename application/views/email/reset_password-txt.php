<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
Hi <?php echo $full_name; ?> (<?php echo 'user/'.$username; ?>),

You have changed your password.
Please, keep it in your records so you don't forget it.

If you didn't make this change, please let us know:
<?php echo base_url('home/faq'); ?>.

Thanks!
- The <?php echo $site_name; ?> Team