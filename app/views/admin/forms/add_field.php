 <div class="row">
  <div class="col-lg-12">
    <!--Display form validation errors-->
    <?php echo validation_errors('<p class="alert alert-dismissable alert-danger">'); ?>
  </div>
</div><!-- /.row -->
<?php $form_id = $this->uri->segment(4); //Get form id from url ?>
<?php $attributes = array('id' => 'add_field_form'); ?>
<?php echo form_open('admin/forms/add_field/'.$form_id,$attributes); ?>
 <div class="row">
          <div class="col-lg-6">
            <h1>Add a Field <small></small></h1>
          </div>
            <div class="col-lg-6">
                <div class="btn-group pull-right">
                    <input type="submit" name="submit" id="field_submit" class="btn btn-default" value="Save" />
                    <a href="<?php echo base_url(); ?>admin/forms/fields/<?php echo $form_id; ?>" class="btn btn-default">Close</a>
			</div>
          </div>
        </div><!-- /.row -->
		<div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
              <li><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
              <li><a href="<?php echo base_url(); ?>admin/forms/fields/<?php echo $form_id; ?>"><i class="fa fa-envelope"></i> Forms</a></li>
			  <li class="active"><i class="fa fa-pencil"></i> New Field</li>
            </ol>
            </div>  
        </div>
		<form role="form">	
        	<div class="row">
          		<div class="col-lg-6">
          			<div class="form-group">
						<label for="field_label">Field Label</label>
						<input class="form-control" type="text" name="field_label" id="field_label" placeholder="Enter Label" value="<?php echo set_value('field_label'); ?>" />
						<p class="help-block">&lt;label&gt; tag for this field</p>
					</div>
      				
      				<div class="form-group">
						<label for="field_name">Field Name</label>
						<input class="form-control" type="text" name="field_name" id="field_name" placeholder="Enter Name" value="<?php echo set_value('field_name'); ?>" />
						<p class="help-block">The "name" attribute for this field. Should be all lowercase and no spaces</p>
					</div>

					<div class="form-group">
						<label for="field_type">Field Type</label>
						<select id="field_type" name="field_type" class="form-control" onchange="OnChange(this.form.type);">
    						<option value="text" <?php echo set_select('type','text'); ?>>Text</option>
    						<option value="textarea" <?php echo set_select('type','textarea'); ?>>Textarea</option>
    						<option value="select" <?php echo set_select('type','select'); ?>>Select List</option>
    						<option value="email" <?php echo set_select('type','email'); ?>>Email</option>
    						<option value="checkbox" <?php echo set_select('type','checkbox'); ?>>Checkbox</option>
    						<option value="radio" <?php echo set_select('type','radio'); ?>>Radio</option>
						</select>
					</div>

					<div class="form-group">
						<label for="field_options">Field Options</label>
						<input class="form-control" type="text" name="field_options" id="field_options" placeholder="Enter Options" />
						<p class="help-block">Select list options - Separate options with a comma</p>
					</div>	

					<div class="form-group">
						<label for="field_width">Field Width</label>
						<input class="form-control" type="text" name="field_width" id="field_width" placeholder="Enter Width in Pixels" value="200" />
						<p class="help-block">Optinal: Choose the width. Default is 200</p>
					</div>

					<div class="form-group">
						<label for="field_height">Field Height</label>
						<input class="form-control" type="text" name="field_height" id="field_height" placeholder="Enter Height in Pixels" value="auto" />
						<p class="help-block">Optinal: Choose the height. Default is auto</p>
					</div>				
		
					<div class="form-group">
                		<label>Publish Field</label><br>		
                		<label for="is_published" class="radio-inline">
                  		<input type="radio" name="is_published" id="is_published" value="1" checked> yes
                		</label>
                		<label class="radio-inline">
                  		<input type="radio" name="is_published" id="is_published" value="0"> No
                		</label>
                	</div>
              	</div>
   
		  		<div class="col-lg-6">
		  			<div class="form-group">
						<label for="validation">Validation</label>
						<select name="validation[]" multiple class="form-control">
  							<option value="required">Required</option>
							<option value="valid_email">Valid Email</option>
							<option value="alpha">Alpha</option>
							<option value="alpha_numeric">Alpha Numeric</option>
							<option value="numeric">Numeric</option>
						</select>
                		<p class="help-block">Choose the validations for this field</p>
					</div>

					<div class="form-group">
						<label for="order">Order</label>
						<input class="form-control" type="text" name="order" id="order" value="0" style="width:50px;" />
						<p class="help-block">Optional: Add a value for the order of this field</p>

					</div>
          		</div>
        	</div><!-- /.row -->
    <?php echo form_close(); ?>