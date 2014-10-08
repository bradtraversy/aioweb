<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AIO</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url().''.APPPATH; ?>views/admin/templates/aioadmin/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url().''.APPPATH; ?>views/admin/templates/aioadmin/css/sb-admin.css" rel="stylesheet">
    <link href="<?php echo base_url().''.APPPATH; ?>views/admin/templates/aioadmin/css/custom.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url().''.APPPATH; ?>views/admin/templates/aioadmin/font-awesome/css/font-awesome.min.css">
    <!-- Page Specific CSS -->
    <link rel="stylesheet" href="http://cdn.oesmith.co.uk/morris-0.4.3.min.css">
    <script src="<?php echo base_url().''.APPPATH; ?>views/admin/templates/aioadmin/js/jquery-1.10.2.js"></script>
    <script src="<?php echo base_url().''.APPPATH; ?>views/admin/templates/aioadmin/js/bootstrap.js"></script>
  </head>

  <body>

    <div id="wrapper">
      <!-- Sidebar -->
      <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo base_url(); ?>admin">AIO Web Management</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav side-nav">
            <li <?php echo ($this->uri->segment('2') == 'dashboard') ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li <?php echo ($this->uri->segment('2') == 'pages') ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>admin/pages"><i class="fa fa-pencil"></i> Pages</a></li>
			      <li class="dropdown<?php echo ($this->uri->segment('2') == 'posts' || $this->uri->segment('2') == 'categories') ? ' active' : ''; ?>">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-comments"></i> Blog <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo base_url(); ?>admin/posts">Blog Posts</a></li>
                <li><a href="<?php echo base_url(); ?>admin/categories/index">Blog Categories</a></li>
                <li><a href="<?php echo base_url(); ?>admin/posts/comments">Comments</a></li>
              </ul>
            </li>
            <li class="dropdown<?php echo ($this->uri->segment('2') == 'menus') ? ' active' : ''; ?>">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-list"></i> Menus <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo base_url(); ?>admin/menus">Manage Menus</a></li>
                <li><a href="<?php echo base_url(); ?>admin/menus/items">Menu Items</a></li>
              </ul>
            </li>
            <li <?php echo ($this->uri->segment('2') == 'forms') ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>admin/forms"><i class="fa fa-envelope-o"></i> Forms</a></li>
            <li class="dropdown<?php echo ($this->uri->segment('2') == 'modules') ? ' active' : ''; ?>">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-comments"></i> Modules <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo base_url(); ?>admin/modules">Manage Modules</a></li>
                <li><a href="<?php echo base_url(); ?>admin/modules/positions">Module Positions</a></li>
              </ul>
            </li>
            <li class="dropdown<?php echo ($this->uri->segment('2') == 'users' || $this->uri->segment('2') == 'user_groups') ? ' active' : ''; ?>">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> Users <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo base_url(); ?>admin/users">Manage Users</a></li>
                <li><a href="<?php echo base_url(); ?>admin/user_groups">User Groups</a></li>
              </ul>
            </li>
           <li <?php echo ($this->uri->segment('2') == 'settings') ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>settings"><i class="fa fa-wrench"></i> Settings</a></li>
			<!--<li><a href="analytics.html"><i class="fa fa-bar-chart-o"></i> Analytics</a></li>-->
          </ul>

          <ul class="nav navbar-nav navbar-right navbar-user">
            <li class="dropdown messages-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> Messages <span class="badge">7</span> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li class="dropdown-header">7 New Messages</li>
                <li class="message-preview">
                  <a href="#">
                    <span class="avatar"><img src="http://placehold.it/50x50"></span>
                    <span class="name">John Smith:</span>
                    <span class="message">Hey there, I wanted to ask you something...</span>
                    <span class="time"><i class="fa fa-clock-o"></i> 4:34 PM</span>
                  </a>
                </li>
                <li class="divider"></li>
                <li class="message-preview">
                  <a href="#">
                    <span class="avatar"><img src="http://placehold.it/50x50"></span>
                    <span class="name">John Smith:</span>
                    <span class="message">Hey there, I wanted to ask you something...</span>
                    <span class="time"><i class="fa fa-clock-o"></i> 4:34 PM</span>
                  </a>
                </li>
                <li class="divider"></li>
                <li class="message-preview">
                  <a href="#">
                    <span class="avatar"><img src="http://placehold.it/50x50"></span>
                    <span class="name">John Smith:</span>
                    <span class="message">Hey there, I wanted to ask you something...</span>
                    <span class="time"><i class="fa fa-clock-o"></i> 4:34 PM</span>
                  </a>
                </li>
                <li class="divider"></li>
                <li><a href="#">View Inbox <span class="badge">7</span></a></li>
              </ul>
            </li>
            <li class="dropdown alerts-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> Alerts <span class="badge">3</span> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#">Default <span class="label label-default">Default</span></a></li>
                <li><a href="#">Primary <span class="label label-primary">Primary</span></a></li>
                <li><a href="#">Success <span class="label label-success">Success</span></a></li>
                <li><a href="#">Info <span class="label label-info">Info</span></a></li>
                <li><a href="#">Warning <span class="label label-warning">Warning</span></a></li>
                <li><a href="#">Danger <span class="label label-danger">Danger</span></a></li>
                <li class="divider"></li>
                <li><a href="#">View All</a></li>
              </ul>
            </li>
            <li class="dropdown user-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo users_full_name(); ?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#"><i class="fa fa-user"></i> Profile</a></li>
                <li><a href="#"><i class="fa fa-envelope"></i> Inbox <span class="badge">7</span></a></li>
                <li><a href="#"><i class="fa fa-gear"></i> Settings</a></li>
                <li class="divider"></li>
                <li><a href="<?php echo base_url();?>admin/logout"><i class="fa fa-power-off"></i> Log Out</a></li>
              </ul>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </nav>
      <div id="page-wrapper">
        <!--Load Main View-->
			 <?php $this->load->view($main); ?>
      </div><!-- /#page-wrapper -->
    </div><!-- /#wrapper -->

    <!-- Page Specific Plugins -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="http://cdn.oesmith.co.uk/morris-0.4.3.min.js"></script>
    <script src="<?php echo base_url().''.APPPATH; ?>views/admin/templates/aioadmin/js/morris/chart-data-morris.js"></script>
    <script src="<?php echo base_url().''.APPPATH; ?>views/admin/templates/aioadmin/js/tablesorter/jquery.tablesorter.js"></script>
    <script src="<?php echo base_url().''.APPPATH; ?>views/admin/templates/aioadmin/js/tablesorter/tables.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/site.js"></script>
  </body>
</html>
