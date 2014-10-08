 <div class="row">
  <div class="col-lg-12">
    <!--Display form validation errors-->
    <?php echo validation_errors('<p class="alert alert-dismissable alert-danger">'); ?>
  </div>
</div><!-- /.row -->
<?php $attributes = array('id' => 'add_group_form'); ?>
<?php echo form_open('admin/user_groups/add',$attributes); ?>
 <div class="row">
          <div class="col-lg-6">
            <h1>Add New Group <small></small></h1>
          </div>
            <div class="col-lg-6">
                <div class="btn-group pull-right">
                    <input type="submit" name="submit" id="group_submit" class="btn btn-default" value="Save" />
                    <a href="<?php echo base_url(); ?>admin/user_groups" class="btn btn-default">Close</a>
			</div>
          </div>
        </div><!-- /.row -->
		<div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
              <li><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
              <li><a href="<?php echo base_url(); ?>admin/user_groups"><i class="fa fa-user"></i> User Groups</a></li>
			  <li class="active"><i class="fa fa-plus-square-o"></i> New User Group</li>
            </ol>
            </div>  
        </div>
		<form role="form">	
        	<div class="row">
          		<div class="col-lg-6">
          <div class="form-group">
						  <label for="group_title">Group Title</label>
						  <input class="form-control" type="text" name="group_title" id="group_title" placeholder="Enter Group Title" value="<?php echo set_value('group_title'); ?>" />
					</div>
              	</div>
		  		<div class="col-lg-6">					
          		</div>
        	</div><!-- /.row -->
    <?php echo form_close(); ?>