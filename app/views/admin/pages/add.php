<div class="row">
	<div class="col-lg-12">
		<!--Display form validation errors-->
		<?php echo validation_errors('<p class="alert alert-dismissable alert-danger">'); ?>
	</div>
</div><!-- /.row -->
<!--Start Form-->
<?php $attributes = array('id' => 'add_page_form'); ?>
<?php echo form_open('admin/pages/add',$attributes); ?>
	<div class="row">
          <div class="col-lg-6">
            <h1>Add New Page <small></small></h1>
          </div>
            <div class="col-lg-6">
                <div class="btn-group pull-right">
                    <input type="submit" name="submit" id="page_submit" class="btn btn-default" value="Save" />
                    <a href="<?php echo base_url(); ?>admin/pages" class="btn btn-default">Close</a>
			</div>
          </div>
        </div><!-- /.row -->
		<div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
              <li><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
              <li><a href="<?php echo base_url(); ?>admin/pages"><i class="fa fa-pencil"></i> Pages</a></li>
			  <li class="active"><i class="fa fa-plus-square-o"></i> New Page</li>
            </ol>
            </div>  
        </div><!-- /.row -->
        	<div class="row">
          		<div class="col-lg-6">
            		<div class="form-group">
						<label for="page_title">Page Title</label>
						<input class="form-control" type="text" name="page_title" id="page_title" value="<?php echo set_value('page_title'); ?>" placeholder="Enter Page Title" />
					</div>
					<div class="form-group">
						<label for="page_slug">Page Slug</label>
						<input class="form-control" type="text" name="page_slug" id="page_slug" value="<?php echo set_value('page_slug'); ?>" placeholder="Enter Page Slug" />
						<p class="help-block">URL friendly version of title. No caps or spaces, only hyphens</p>
					</div>
					<div class="form-group">
						<label for="page_body">Page Body</label>
						<textarea class="form-control" type="text" name="page_body" id="page_body" rows="10"><?php echo set_value('page_body'); ?></textarea>
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
                		<label for="access_groups">Page Access</label>
                		<select name="access" class="form-control">
                			 <option value="0">Everyone</option>
                    <?php foreach($group_selection as $group) : ?>
    							     <option value="<?php echo $group->id; ?>"><?php echo $group->title; ?></option>
							       <?php endforeach; ?>
                		</select>
						<p class="help-block">Choose who will be able to access this page</p>
              		</div>
					 <div class="form-group">
                		<label>Feature Page</label><br>		
                		<label for="is_featured" class="radio-inline">
                  		<input type="radio" name="is_featured" id="is_featured" value="1"> Yes
                		</label>
                		<label class="radio-inline">
                  		<input type="radio" name="is_featured" id="is_featured" value="0" checked> No
                		</label>
                	</div>
					<div class="form-group">
                		<label>Publish Page</label><br>		
                		<label for="is_published" class="radio-inline">
                  		<input type="radio" name="is_published" id="is_published" value="1" checked> yes
                		</label>
                		<label class="radio-inline">
                  		<input type="radio" name="is_published" id="is_published" value="0"> No
                		</label>
                		</div>
              		</div>
   
		  		<div class="col-lg-6">
            		<h3>SEO Options</h3>
					<div class="form-group">
						<label for="seo_page_title">SEO Page Title</label>
						<input class="form-control" type="text" name="seo_page_title" id="seo_page_title" placeholder="Browser Page Title" value="<?php echo set_value('seo_page_title'); ?>"/>
					</div>
					<div class="form-group">
						<label for="keywords">Keywords/Tags</label>
						<input class="form-control" type="text" name="keywords" id="keywords" placeholder="Enter keywords separated by a comma" value="<?php echo set_value('keywords'); ?>" />
					</div>
					<div class="form-group">
						<label for="page_description">Description</label>
						<textarea class="form-control" type="text" name="page_description" id="page_description" placeholder="Enter Page Description" rows="4"><?php echo set_value('page_description'); ?></textarea>
					</div>
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
						<input class="form-control" type="text" name="menu_item_title" id="menu_item_title" placeholder="Browser Menu Item Title" value="<?php echo set_value('menu_item_title'); ?>"/>
					</div>
					<div class="form-group">
						<label for="order">Order</label>
						<input class="form-control" type="text" name="order" id="order" style="width:50px;" value="<?php echo set_value('order'); ?>"/>
						<p class="help-block">Optional: Add a value for the order of this menu item</p>
					</div>
          		</div>
        	</div><!-- /.row -->
		<?php echo form_close(); ?>