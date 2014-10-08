 <div class="row">
  <div class="col-lg-12">
    <!--Display form validation errors-->
    <?php echo validation_errors('<p class="alert alert-dismissable alert-danger">'); ?>
  </div>
</div><!-- /.row -->
<?php $attributes = array('id' => 'edit_menu_form'); ?>
<?php echo form_open('admin/menus/edit/'.$this_menu->id,$attributes); ?>
<div class="row">
          <div class="col-lg-6">
            <h1>Edit Menu <small><?php echo $this_menu->title; ?></small></h1>
          </div>
            <div class="col-lg-6">
                <div class="btn-group pull-right">
                    <input type="submit" name="submit" id="menu_submit" class="btn btn-default" value="Save" />
                    <a href="<?php echo base_url(); ?>admin/menus" class="btn btn-default">Close</a>
			</div>
          </div>
        </div><!-- /.row -->
		<div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
              <li><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
              <li><a href="<?php echo base_url(); ?>admin/menus"><i class="fa fa-list"></i> Menus</a></li>
			  <li class="active"><i class="fa fa-plus-square-o"></i> Edit Menu</li>
            </ol>
            </div>  
        </div>

        	<div class="row">
          		<div class="col-lg-6">
            		<div class="form-group">
						<label for="menu_title">Menu Title</label>
						<input class="form-control" type="text" name="menu_title" id="menu_title" value="<?php echo $this_menu->title; ?>" placeholder="Enter Menu Title" />
					</div>
					<div class="form-group">
                		<label>Show Title/Heading</label><br>		
                		<label for="show_title" class="radio-inline">
                  		<input type="radio" name="show_title" id="show_title" value="1" <?php echo ($this_menu->show_title== 1) ? 'checked' : ''; ?>> yes
                		</label>
                		<label class="radio-inline">
                  		<input type="radio" name="show_title" id="show_title" value="0" <?php echo ($this_menu->show_title== 0) ? 'checked' : ''; ?>> No
                		</label>
                		</div>
              	
					 <div class="form-group">
                		<label for="module_position">Module Position</label>
                		<select name="module_position" multiple class="form-control">
                       <?php foreach($positions as $position) : ?>
                            <option value="<?php echo $position->id; ?>"
                              <?php if($position->id == $this_menu->module_position) : ?>
                                selected
                              <?php endif; ?>
                              ><?php echo $position->title; ?></option>
                        <?php endforeach; ?>
                		</select>
           </div>
           <div class="form-group">
            <label for="access">Access</label>
            <select name="access" class="form-control">
                         <option value="0" <?php if($this_menu->access == 0) : ?>
                          selected
                        <?php endif; ?>>Everyone</option>
                    <?php foreach($user_groups as $group) : ?>
                       <option value="<?php echo $group->id; ?>"
                        <?php if($group->id == $this_menu->access) : ?>
                          selected
                        <?php endif; ?>
                        ><?php echo $group->title; ?></option>
                     <?php endforeach; ?>
            </select>
          </div>
					 <div class="form-group">
                		<label>Set Global</label><br>		
                		<label for="is_global" class="radio-inline">
                  		<input type="radio" name="is_global" id="is_global" value="1" <?php echo ($this_menu->is_global== 1) ? 'checked' : ''; ?>> Yes
                		</label>
                		<label class="radio-inline">
                  		<input type="radio" name="is_global" id="is_global" value="0" <?php echo ($this_menu->is_global== 0) ? 'checked' : ''; ?>> No
                		</label>
            <p class="help-block">If global, this module will show on all pages</p>
                	</div>
					<div class="form-group">
                		<label>Publish Module</label><br>		
                		<label for="is_published" class="radio-inline">
                  		<input type="radio" name="is_published" id="is_published" value="1" <?php echo ($this_menu->is_published= 1) ? 'checked' : ''; ?>> yes
                		</label>
                		<label class="radio-inline">
                  		<input type="radio" name="is_published" id="is_published" value="0" <?php echo ($this_menu->is_published== 0) ? 'checked' : ''; ?>> No
                		</label>
                		</div>
              		</div>
   
		  		<div class="col-lg-6">
            		<h3>Optional</h3>
					<div class="form-group">
						<label for="class_suffix">Class Suffix</label>
						<input class="form-control" type="text" name="class_suffix" id="class_suffix" value="<?php echo $this_menu->class_suffix; ?>" placeholder="Add Class Suffix" />
						<p class="help-block">Add a custom CSS suffix to style individual menus</p>

					</div>
					
					<div class="form-group">
						<label for="order">Order</label>
						<input class="form-control" type="text" name="order" id="order" style="width:50px;" value="<?php echo $this_menu->order; ?>" />
						<p class="help-block">Optional: Add a value for the order of this menu</p>

					</div>
          		</div>
        	</div><!-- /.row -->
<?php echo form_close(); ?>