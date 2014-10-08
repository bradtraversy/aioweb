<script src="<?php echo base_url().''.APPPATH; ?>views/admin/templates/aioadmin/js/jquery-1.10.2.js"></script>
 <div class="row">
  <div class="col-lg-12">
    <!--Display form validation errors-->
    <?php echo validation_errors('<p class="alert alert-dismissable alert-danger">'); ?>
  </div>
</div><!-- /.row -->
<?php $attributes = array('id' => 'add_item_form'); ?>
<?php echo form_open('admin/menus/add_item',$attributes); ?>
 <div class="row">
          <div class="col-lg-6">
            <h1>Add Menu Item <small></small></h1>
          </div>
            <div class="col-lg-6">
                <div class="btn-group pull-right">
                    <input type="submit" name="submit" id="item_submit" class="btn btn-default" value="Save" />
                    <a href="<?php echo base_url(); ?>admin/menus/items" class="btn btn-default">Close</a>
			</div>
          </div>
        </div><!-- /.row -->
		<div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
              <li><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
              <li><a href="<?php echo base_url(); ?>admin/menus/items"><i class="fa fa-list"></i> Menus</a></li>
			  <li class="active"><i class="fa fa-plus-square-o"></i> New Menu Item</li>
            </ol>
            </div>  
        </div>
		<form role="form">	
        	<div class="row">
          	<div class="col-lg-6">
          	<div class="form-group">
				<label for="item_title">Item Title</label>
				<input class="form-control" type="text" name="item_title" id="item_title" placeholder="Enter Title/Anchor" value="<?php echo set_value('item_title'); ?>" />
				<p class="help-block">This will be the display name for this menu item</p>
			</div>
			<div class="form-group">
				<label for="item_alias">Item Alias</label>
				<input class="form-control" type="text" name="item_alias" id="item_alias" value="<?php echo set_value('item_alias'); ?>" placeholder="Enter Item Alias" />
				<p class="help-block">Use all lowercase and hyphens instead of spaces</p>
			</div>
			<div class="form-group menu_select">
				<label for="menu">Select Menu</label>
				<select name="menu" class="form-control menu">
					<option value="0">Select Menu</option>
					<?php foreach ($menus as $menu) : ?>
						<option value="<?php echo $menu->id; ?>"><?php echo $menu->title; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="form-group">
				<label for="item_type">Item Type</label>
				<select name="item_type" class="form-control item_type">
					<option value="0">Select Type</option>
  					<option value="page">Page</option>
  					<option value="form">Form</option>
  					<option value="url">External URL</option>
				</select>
			</div>
			<div class="form-group page_select">
				<label for="page_item">Select Page</label>
				<select name="page_item" class="form-control">
					<option value="0">Select Page</option>
					<?php foreach ($pages as $page) : ?>
						<option value="<?php echo $page->id; ?>"><?php echo $page->title; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="form-group form_select">
				<label for="form_item">Select Form</label>
				<select name="form_item" class="form-control">
					<option value="0">Select Form</option>
					<?php foreach ($forms as $form) : ?>
						<option value="<?php echo $form->id; ?>"><?php echo $form->title; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="form-group url_select">
				<label for="url_item">URL</label>
				<input class="form-control" type="text" name="url_item" id="url_item" placeholder="Enter URL" value="<?php echo set_value('url_item'); ?>" />
				<p class="help-block">Please include the 'http://'</p>
			</div>
			<div class="form-group parent_select">
				<label for="parent_item">Parent Menu Item</label>
				<select name="parent_item" class="form-control">
					<option value="0">No Parent</option>
					<?php foreach ($items as $item) : ?>
						<option value="<?php echo $item->id; ?>"><?php echo $item->title; ?></option>
					<?php endforeach; ?>
				</select>
				<p class="help-block">Optional: Make this a sub item</p>
			</div>
			<div class="form-group">
                <label>Publish Item</label><br>		
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
                <label for="item_access">Item Access</label>
                <select name="access" class="form-control">
                	<option value="0">Everyone</option>
                    <?php foreach($user_groups as $group) : ?>
    				<option value="<?php echo $group->id; ?>"><?php echo $group->title; ?></option>
					<?php endforeach; ?>
                </select>
				<p class="help-block">Choose who will be able to access this item</p>
             </div>
             <div class="form-group">
				<label for="order">Order</label>
				<input class="form-control" style="width:40px" type="text" name="order" id="order" placeholder="" value="<?php echo set_value('order'); ?>" />
				<p class="help-block">Add Numeric Value</p>
			</div>
          </div>
        	</div><!-- /.row -->
    <?php echo form_close(); ?>