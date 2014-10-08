<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AIO | Dashboard</title>

    <!-- Bootstrap core CSS -->
     <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url().''.APPPATH; ?>views/admin/templates/aiologin/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url().''.APPPATH; ?>views/admin/templates/aiologin/css/custom.css" rel="stylesheet">
  </head>

  <body>
  <nav class="navbar navbar-inverse" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="<?php echo base_url(); ?>admin">AIO Web Management</a>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav">
     
    </ul>

    <ul class="nav navbar-nav navbar-right">
      
    </ul>
  </div><!-- /.navbar-collapse -->
</nav>

  <div class="login-wrapper">
<div class="container">
    <!--Main page content-->
    <?php $this->load->view($main); ?>
    </div> <!-- /container -->
</div><!--logn wrapper-->
    <!-- JavaScript -->
    <script src="<?php echo base_url().''.APPPATH; ?>views/admin/templates/aiologin/js/jquery-1.10.2.js"></script>
    <script src="<?php echo base_url().''.APPPATH; ?>views/admin/templates/aiologin/js/bootstrap.js"></script>

  </body>
</html>