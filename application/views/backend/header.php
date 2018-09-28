<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8">
    <title>
    <?php //echo $pageTitle; ?>
    </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- FontAwesome 4.3.0 -->
    <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <link rel="icon" href="<?php echo base_url();?>assets/favicon.ico">
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/datatables/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/datatables/css/dataTables.bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/datatables/css/dataTables.tableTools.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/summernote/summernote.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/bootstrap-datepicker/css/bootstrap-datetimepicker.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/summernote/summernote.css">

    <style>
.error {
	color: red;
	font-weight: normal;
}
</style>
    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
    <script type="text/javascript">
        var baseURL = "<?php echo base_url(); ?>";
    </script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    </head>
    <body class="skin-blue sidebar-mini">
<div class="wrapper">
<header class="main-header"> 
      <!-- Logo --> 
      <a href="<?php echo base_url(); ?>" class="logo"> 
  <!-- mini logo for sidebar mini 50x50 pixels --> 
  <span class="logo-mini"><b>LMS</b>P</span> 
  <!-- logo for regular state and mobile devices --> 
  <span class="logo-lg"><b>Lead Manager</b></span> </a> 
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top" role="navigation"> 
    <!-- Sidebar toggle button--> 
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"> <span class="sr-only">Toggle navigation</span> </a>
    <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <img src="<?php echo base_url(); ?>assets/dist/img/avatar.png" class="user-image" alt="User Image"/> </a>
              <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header"> <img src="<?php echo base_url(); ?>assets/dist/img/avatar.png" class="img-circle" alt="User Image" /> </li>
            <!-- Menu Footer-->
            <li class="user-footer">
                  <div class="pull-left"> <a href="<?php echo base_url(); ?>admin/dashboard/loadChangePass" class="btn btn-default btn-flat"><i class="fa fa-key"></i> Change Password</a> </div>
                  <div class="pull-right"> <a href="<?php echo base_url(); ?>admin/dashboard/logout" class="btn btn-default btn-flat"><i class="fa fa-sign-out"></i> Sign out</a> </div>
                </li>
          </ul>
            </li>
      </ul>
        </div>
  </nav>
    </header>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar"> 
<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar"> 
<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu" style="font-size:13px;">
<li class="treeview"> <a href="<?php echo base_url(); ?>admin/dashboard"> 
<i class="fa fa-tachometer" aria-hidden="true"></i> <span>Dashboard</span></i> </a></li>
<li class="treeview"> <a href="<?php echo base_url(); ?>admin/companies"> 
<i class="fa fa-file-image-o" aria-hidden="true"></i> <span>Add Companies </span> </a> </li>
<li class="treeview"> <a href="<?php echo base_url(); ?>admin/projects"> 
<i class="fa fa-file-image-o" aria-hidden="true"></i> <span> Add Services </span> </a> </li>

<li class="treeview"> <a href="<?php echo base_url(); ?>admin/enquiry"> 
<i class="fa fa-group" aria-hidden="true"></i> <span> Services Type Enquiry </span> </a> </li>

<li class="treeview"> <a href="<?php echo base_url(); ?>admin/enq_list"> 
<i class="fa fa-group" aria-hidden="true"></i> <span> All Enquiries  </span> </a> </li>


<li class="treeview"> <a href="<?php echo base_url(); ?>admin/dashboard/loadChangePass"> 
<i class="fa fa-key"></i><span> Change Password </span> </a> </li>
<li class="treeview"> <a href="<?php echo base_url(); ?>admin/dashboard/db_backup"> 
<i class="fa fa-database" aria-hidden="true"></i> <span> DB backup </span></a> 
</li>
<li class="treeview"> <a href="<?php echo base_url(); ?>admin/dashboard/logout"> 
<i class="fa fa-sign-out" aria-hidden="true"></i> <span> Logout </span> </a> 
</li>
</ul>
</section>
<!-- /.sidebar --> 
</aside>
