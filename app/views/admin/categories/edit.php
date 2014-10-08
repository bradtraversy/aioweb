 <div class="row">
  <div class="col-lg-12">
    <!--Display form validation errors-->
    <?php echo validation_errors('<p class="alert alert-dismissable alert-danger">'); ?>
  </div>
</div><!-- /.row -->
<?php $attributes = array('id' => 'edit_category_form'); ?>
<?php echo form_open('admin/categories/edit/'.$this_category->id,$attributes); ?>
 <div class="row">
          <div class="col-lg-6">
            <h1>Add New Category <small><?php echo $this_category->title; ?></small></h1>
          </div>
            <div class="col-lg-6">
                <div class="btn-group pull-right">
                    <input type="submit" name="submit" id="category_submit" class="btn btn-default" value="Save" />
                    <a href="<?php echo base_url(); ?>admin/categories" class="btn btn-default">Close</a>
			</div>
          </div>
        </div><!-- /.row -->
		<div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
              <li><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
              <li><a href="<?php echo base_url(); ?>admin/categories"><i class="fa fa-folder"></i> Categories</a></li>
			  <li class="active"><i class="fa fa-plus-square-o"></i> New Category</li>
            </ol>
            </div>  
        </div>
		<form role="form">	
        	<div class="row">
          		<div class="col-lg-6">
          <div class="form-group">
						  <label for="category_title">Category Title</label>
						  <input class="form-control" type="text" name="category_title" id="category_title" placeholder="Enter Category" value="<?php echo $this_category->title; ?>" />
					</div>
          <div class="form-group">
              <label for="category_slug">Category Slug</label>
              <input class="form-control" type="text" name="category_slug" id="category_slug" placeholder="Enter Category Slug" value="<?php echo $this_category->slug; ?>" />
            <p class="help-block">URL friendly version of title. No caps or spaces, only hyphens</p>
          </div>
					<div class="form-group">
						<label for="category_description">Category Description</label>
						<textarea class="form-control" type="text" name="category_description" id="category_description" placeholder="Enter Category Description" rows="10"><?php echo $this_category->description; ?></textarea>
					</div>				
					<div class="form-group">
                		<label>Publish Category</label><br>		
                	 <label>Publish Page</label><br>   
                    <label for="is_published" class="radio-inline">
                      <input type="radio" name="is_published" id="is_published" value="1" <?php echo ($this_category->is_published== 1) ? 'checked' : ''; ?>> yes
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="is_published" id="is_published" value="0" <?php echo ($this_category->is_published == 0) ? 'checked' : ''; ?>> No
                    </label>
                	</div>
              	</div>
   
		  		<div class="col-lg-6">
					
          		</div>
        	</div><!-- /.row -->
    <?php echo form_close(); ?>