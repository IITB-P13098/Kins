<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!doctype html>
<html lang="en">

  <head>
    <?php
    $website_name = $this->config->item('website_name', 'tank_auth');
    if (empty($heading)) $page_title = ''; else $page_title = $heading.' - ';
    $page_title .= $website_name;
    ?>
    <title><?php echo $page_title; ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
  </head>

  <body>
    <section class="main">
      <div class="container">
        <div class="row">
          <div class="col-sm-push-4 col-sm-4">
            
            <div class="logo">
              <a href="<?php echo base_url(); ?>">Home</a>
            </div>
            
            <h1><?php if (!empty($heading)) echo $heading; ?></h1>
            <?php if (!empty($content)) echo $content; ?>
            
          </div>
        </div>
      </div>
    </section>
  </body>

</html>