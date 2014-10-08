 <div class="row">
  <div class="col-lg-12">
    <!--Display form validation errors-->
    <?php echo validation_errors('<p class="alert alert-dismissable alert-danger">'); ?>
  </div>
</div><!-- /.row -->
<?php $attributes = array('id' => 'add_position_form'); ?>
<?php echo form_open('admin/modules/add_position',$attributes); ?>
 <div class="row">
          <div class="col-lg-6">
            <h1>Add New Position <small></small></h1>
          </div>
            <div class="col-lg-6">
                <div class="btn-group pull-right">
                    <input type="submit" name="submit" id="position_submit" class="btn btn-default" value="Save" />
                    <a href="<?php echo base_url(); ?>admin/modules/positions" class="btn btn-default">Close</a>
			</div>
          </div>
        </div><!-- /.row -->
		<div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
              <li><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
              <li><a href="<?php echo base_url(); ?>admin/modules/positions"><i class="fa fa-folder"></i> Module Positions</a></li>
			  <li class="active"><i class="fa fa-plus-square-o"></i> New Position</li>
            </ol>
            </div>  
        </div>
		<form role="form">	
        	<div class="row">
          		<div class="col-lg-6">
          <div class="form-group">
						  <label for="position_title">Position Title</label>
						  <input class="form-control" type="text" name="position_title" id="position_title" placeholder="Enter Position" value="<?php echo set_value('position_title'); ?>" />
					</div>
      
		
					<div class="form-group">
                		<label>Publish Position</label><br>		
                		<label for="is_published" class="radio-inline">
                  		<input type="radio" name="is_published" id="is_published" value="1" checked> yes
                		</label>
                		<label class="radio-inline">
                  		<input type="radio" name="is_published" id="is_published" value="0"> No
                		</label>
                	</div>
              	</div>
   
		  		<div class="col-lg-6">
					
          		</div>
        	</div><!-- /.row -->
    <?php echo form_close(); ?>