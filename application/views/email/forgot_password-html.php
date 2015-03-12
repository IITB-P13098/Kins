<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <title>Create a new password on <?php echo $site_name; ?></title>
  </head>
  <body>
    <center>
      <table border="0" cellpadding="8" cellspacing="0" style="background-color:#ffffff;background:#ffffff;width:100% !important;padding:0;">
        <tbody>
          <tr>
            <td valign="top">
            <table align="center" border="0" cellpadding="0" cellspacing="0" style="border:1px #DDD solid;">
              <tbody>
                
                <?php $this->load->view('email/base_header_glyph_html'); ?>

                <tr>
                  <td>
                  <table align="center" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                      <tr>
                        <td colspan="3" height="36">&nbsp;</td>
                      </tr>
                      <tr>
                        <td width="36">&nbsp;</td>
                        <td align="left" style="font-size:14px;color:#444444;font-family: Verdana, sans-serif;border-collapse:collapse;" valign="top" width="454">
                          <p>Hi <?php echo $full_name; ?> (<?php echo anchor('user/'.$username, 'user/'.$username, 'style="color: #337AB7;" target="_blank"'); ?>),</p>
                          
                          <p>
                          Forgot your password, huh? No big deal.<br />
                          You can set a new password <a href="<?php echo base_url('auth/reset_password/'.$user_id.'/'.$password_key); ?>" style="color: #337AB7;" target="_blank">here</a>:
                          </p>

                          <p>
                            <center>
                              <a href="<?php echo base_url('auth/reset_password/'.$user_id.'/'.$password_key); ?>" style="font-size:16px;color:white;width:180px;font-weight:600;background-color:#337AB7;padding:14px 7px 14px 7px;max-width:180px;font-family: Verdana, sans-serif;text-align:center;text-decoration:none;display:block;" target="_blank">
                                Reset password
                              </a>
                            </center>
                          </p>

                          <p>If you did not request a new password then please ignore this message.</p>
                          
                          <p>
                            Thanks!<br />
                            &mdash; The <?php echo $site_name; ?> Team
                          </p>
                        </td>
                        <td width="36">&nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="3" height="36">&nbsp;</td>
                      </tr>
                    </tbody>
                  </table>
                  </td>
                </tr>
              </tbody>
            </table>

            <?php $this->load->view('email/base_footer_html'); ?>
            </td>
          </tr>
        </tbody>
      </table>
    </center>
  </body>
</html>