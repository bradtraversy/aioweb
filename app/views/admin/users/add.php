<div class="row">
  <div class="col-lg-12">
    <!--Display form validation errors-->
    <?php echo validation_errors('<p class="alert alert-dismissable alert-danger">'); ?>
  </div>
</div><!-- /.row -->
<!--Start Form-->
<?php $attributes = array('id' => 'add_user_form'); ?>
<?php echo form_open_multipart('admin/users/add',$attributes); ?>
<div class="row">
          <div class="col-lg-6">
            <h1>Add New User <small></small></h1>
          </div>
            <div class="col-lg-6">
                <div class="btn-group pull-right">
                    <input type="submit" name="submit" id="user_submit" class="btn btn-default" value="Save" />
                    <a href="<?php echo base_url(); ?>admin/users" class="btn btn-default">Close</a>
			</div>
          </div>
        </div><!-- /.row -->
		<div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
              <li><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
              <li><a href="<?php echo base_url(); ?>admin/users; ?>"><i class="fa fa-user"></i> Users</a></li>
			  <li class="active"><i class="fa fa-plus-square-o"></i> New User</li>
            </ol>
            </div>  
        </div>
		<form role="form">	
        	<div class="row">
          		<div class="col-lg-6">
            		<div class="form-group">
						<label for="first_name">First Name</label>
						<input class="form-control" type="text" name="first_name" id="first_name" value="<?php echo set_value('first_name'); ?>"placeholder="Enter First Name" />
					</div>
					<div class="form-group">
						<label for="last_name">Last Name</label>
						<input class="form-control" type="text" name="last_name" id="last_name" value="<?php echo set_value('last_name'); ?>" placeholder="Enter Last Name" />
					</div>
					<div class="form-group">
						<label for="email">Email Address</label>
						<input class="form-control" type="email" name="email" id="email" value="<?php echo set_value('email_address'); ?>"placeholder="Enter Email Address" />
					</div>
					<div class="form-group">
						<label for="username">Username</label>
						<input class="form-control" type="text" name="username" id="username" value="<?php echo set_value('username'); ?>" placeholder="Enter Username" />
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input class="form-control" type="password" name="password" id="password" value="<?php echo set_value('password'); ?>" placeholder="Enter Password" />
					</div>
					<div class="form-group">
						<label for="password2">Confirm Password</label>
						<input class="form-control" type="password" name="password2" id="password2" value="<?php echo set_value('password2'); ?>" placeholder="Confirm Password" />
					</div>
					 <div class="form-group">
                		<label for="user_group">Choose User Group</label>
                		<select name="user_group" class="form-control">
                            <?php foreach($groups as $group) : ?>
                                <option value="<?php echo $group->id; ?>"
                                    <?php if($group->id == 1) : ?>
                                    selected
                                    <?php endif; ?>
                                    ><?php echo $group->title; ?></option>
                            <?php endforeach; ?>
                		</select>
              		</div>
					<div class="form-group">
                		<label>Activate User</label><br>		
                		<label for="is_activated" class="radio-inline">
                  		<input type="radio" name="is_activated" id="is_activated" value="1" checked> yes
                		</label>
                		<label class="radio-inline">
                  		<input type="radio" name="is_activated" id="is_activated" value="0"> No
                		</label>
                		</div>
              		</div>
   
		  		<div class="col-lg-6">
            		<h3>Optional</h3>
					<div class="form-group">
    					<label for="userfile">Upload Avatar</label>
    					<input type="file" name="userfile" size="20" />
              <p class="help-block">Select an avatar to personalize your profile</p>
            </div>
					<div class="form-group">
						<label for="phone">Phone Number</label>
						<input class="form-control" type="text" name="phone" id="phone" placeholder="Enter Phone Number" value="<?php echo set_value('phone'); ?>"/>
					</div>
					<div class="form-group">
						<label for="address">Address</label>
						<input class="form-control" type="text" name="address" id="address" placeholder="Enter Address" value="<?php echo set_value('address'); ?>" />
					</div>
					<div class="form-group">
						<label for="city">City</label>
						<input class="form-control" type="text" name="city" id="city" placeholder="Enter City" value="<?php echo set_value('city'); ?>" />
					</div>
					<div class="form-group">
						<label for="state">state</label>
						<select name="state" class="form-control">
                            <?php foreach($states as $state) : ?>
                                <option value="<?php echo $state; ?>" ><?php echo $state; ?></option>
                            <?php endforeach; ?>
                        </select>
			</div>
			<div class="form-group">
				<label for="postal_code">Postal Code</label>
				<input class="form-control" type="text" name="postal_code" id="postal_code" value="<?php echo set_value('postal_code'); ?>" placeholder="Enter Postal Code" />
			</div>
        </div>
    </div><!-- /.row -->
<?php echo form_close(); ?>