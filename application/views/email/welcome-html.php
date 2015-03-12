<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <title>Welcome to <?php echo $site_name; ?>!</title>
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
                          <p>Hi <?php echo $full_name; ?> (<?php echo anchor('@'.$username, '@'.$username, 'style="color: #DA2E75;" target="_blank"');?>), welcome to <?php echo $site_name; ?>!</p>

                          <p>We listed your sign in details below, make sure you keep them safe.</p>

                          <p>
                            Username: <?php echo $username; ?><br />
                            Email address: <?php echo $email; ?>
                          </p>

                          <p>
                            Have fun!<br />
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