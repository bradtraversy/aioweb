 <div class="row">
  <div class="col-lg-12">
    <!--Display form validation errors-->
    <?php echo validation_errors('<p class="alert alert-dismissable alert-danger">'); ?>
  </div>
</div><!-- /.row -->
<?php $attributes = array('id' => 'add_form_form'); ?>
<?php echo form_open('admin/forms/add',$attributes); ?>
 <div class="row">
          <div class="col-lg-6">
            <h1>Add New Form <small></small></h1>
          </div>
            <div class="col-lg-6">
                <div class="btn-group pull-right">
                    <input type="submit" name="submit" id="form_submit" class="btn btn-default" value="Save" />
                    <a href="<?php echo base_url(); ?>admin/forms" class="btn btn-default">Close</a>
			</div>
          </div>
        </div><!-- /.row -->
		<div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
              <li><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
              <li><a href="<?php echo base_url(); ?>admin/forms"><i class="fa fa-envelope-o"></i> Forms</a></li>
			  <li class="active"><i class="fa fa-plus-square-o"></i> New Form</li>
            </ol>
            </div>  
        </div>
        	<div class="row">
          		<div class="col-lg-6">
            		<div class="form-group">
						<label for="form_title">Form Title</label>
						<input class="form-control" type="text" name="form_title" id="form_title" value="<?php echo set_value('form_title'); ?>" placeholder="Enter Form Title" />
					</div>
					<div class="form-group">
						<label for="to_email">To Email</label>
						<input class="form-control" type="text" name="to_email" id="to_email" value="<?php echo set_value('to_email'); ?>" placeholder="Enter Email" />
						<p class="help-block">Email the form will go to</p>
					</div>
					 <div class="form-group">
						<label for="subject">Email Subject</label>
						<input class="form-control" type="text" name="subject" id="subject" value="<?php echo set_value('subject'); ?>" placeholder="Enter Subject" />
						<p class="help-block">Subject in the email</p>
					</div>
          <div class="form-group">
                    <label for="page_modules">Page Modules</label>
                    <select name="page_modules[]" multiple class="form-control">
                      <?php foreach($mod_selection as $module) : ?>
                       <option value="<?php echo $module->id; ?>" <?php echo set_select('page_modules',$module->id); ?>><?php echo $module->title; ?></option>
                     <?php endforeach; ?>
                    </select>
            <p class="help-block">Choose which modules will show on this page</p>
                  </div>
					<div class="form-group">
                		<label>Publish Form</label><br>		
                		<label for="is_published" class="radio-inline">
                  		<input type="radio" name="is_published" id="is_published" value="1" checked> yes
                		</label>
                		<label class="radio-inline">
                  		<input type="radio" name="is_published" id="is_published" value="0"> No
                		</label>
                	</div>
              	</div>
   
		  		<div class="col-lg-6">
					<h3>Menu Options</h3>
					<div class="form-group">
                		<label for="page_menu">Menu</label>
                		<select name="page_menu" class="form-control">
                  		 <option value="0">No Menu</option>
                      <?php foreach($menu_selection as $menu) : ?>
                        <option value="<?php echo $menu->id; ?>" <?php echo set_select('page_menu',$menu->id); ?>><?php echo $menu->title; ?></option>
                      <?php endforeach; ?>
                		</select>
              		</div>
					<div class="form-group">
                		<label for="parent_item">Parent Item</label>
                		<select class="form-control" name="parent_item">
                  			<option value="0">None</option>
                  			<option value="1">Home</option>
                		</select>
              		</div>
					<div class="form-group">
						<label for="menu_item_title">Menu Item Title</label>
						<input class="form-control" type="text" name="menu_item_title" id="menu_item_title" value="<?php echo set_value('menu_item_title'); ?>" placeholder="Browser Menu Item Title" />
					</div>

					<div class="form-group">
						<label for="order">Order</label>
						<input class="form-control" type="text" name="order" id="order" style="width:50px;" value="<?php echo set_value('order'); ?>" />
						<p class="help-block">Optional: Add a value for the order of this menu item</p>

					</div>
          <div class="form-group">
                    <label>Add to Messages</label><br>    
                    <label for="is_message" class="radio-inline">
                      <input type="radio" name="is_message" id="is_message" value="1" checked> yes
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="is_message" id="is_message" value="0"> No
                    </label>
                    <p class="help-block">If yes, submissions for this form will be stored in the messages table</p>

          </div>
            	</div>
        	</div><!-- /.row -->
		<?php echo form_close(); ?>