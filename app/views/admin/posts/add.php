<div class="row">
  <div class="col-lg-12">
    <!--Display form validation errors-->
    <?php echo validation_errors('<p class="alert alert-dismissable alert-danger">'); ?>
    <?php if($this->session->flashdata('image_errors')) : ?> 
      <?php echo '<p class="alert alert-dismissable alert-danger">' .$this->session->flashdata('image_errors') . '</p>'; ?>
    <?php endif; ?>
  </div>
</div><!-- /.row -->
<!--Start Form-->
<?php $attributes = array('id' => 'add_post_form'); ?>
<?php echo form_open_multipart('admin/posts/add',$attributes); ?>
<div class="row">
          <div class="col-lg-6">
            <h1>Add New Post <small></small></h1>
          </div>
            <div class="col-lg-6">
                <div class="btn-group pull-right">
                    <input type="submit" name="submit" id="post_submit" class="btn btn-default" value="Save" />
                    <a href="<?php echo base_url(); ?>admin/posts" class="btn btn-default">Close</a>
      </div>
          </div>
        </div><!-- /.row -->
    <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
              <li><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
              <li><a href="<?php echo base_url(); ?>admin/posts"><i class="fa fa-thumb-tack"></i> Posts</a></li>
        <li class="active"><i class="fa fa-plus-square-o"></i> New Post</li>
            </ol>
            </div>  
        </div>
    <form role="form">  
          <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
            <label for="post_title">Post Title</label>
            <input class="form-control" type="text" name="post_title" id="post_title" placeholder="Enter Post Title" value="<?php echo set_value('post_title'); ?>" />
            <p class="help-block">This is the page heading</p>
          </div>
          <div class="form-group">
            <label for="post_slug">Post Slug</label>
            <input class="form-control" type="text" name="post_slug" id="post_slug" placeholder="Enter Post Slug" value="<?php echo set_value('post_slug'); ?>" />
            <p class="help-block">URL friendly version of title. No caps or spaces, only hyphens</p>
          </div>
          <div class="form-group">
            <label for="post_body">Post Body</label>
            <textarea class="form-control" type="text" name="post_body" id="post_body" placeholder="Enter Post Body" rows="10"><?php echo set_value('post_body'); ?></textarea>
          </div>
           <div class="form-group">
                    <label for="post_category">Post Category</label>
                            <select name="post_category" class="form-control">
                              <option value="uncategorized">Choose Category</option>
                              <?php foreach ($categories as $category) : ?>
                                <option value="<?php echo $category->id; ?>"><?php echo $category->title; ?></option>
                              <?php endforeach; ?>
                            </select>
                  </div>
           <div class="form-group">
                    <label for="post_author">Author</label>
                            <select name="post_author" class="form-control">
                                <?php foreach ($authors as $author) : ?>
                                <option value="<?php echo $author->id; ?>"><?php echo $author->first_name; ?> <?php echo $author->last_name; ?></option>
                              <?php endforeach; ?>
                            </select>
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
                    <label>Publish Post</label><br>   
                    <label for="is_published" class="radio-inline">
                      <input type="radio" name="is_published" id="is_published" value="1" checked> yes
                    </label>
                    <label class="radio-inline">
                      <input type="radio" name="is_published" id="is_published" value="0"> No
                    </label>
                  </div>
                </div>
   
          <div class="col-lg-6">
          <h3>Media Options</h3>
          <div class="form-group">
              <label for="userfile">Main Image</label>
              <input type="file" name="userfile" size="20" />
              <p class="help-block">This image will show in the main blog roll, not in the post itself</p>
            </div>
                <h3>SEO Options</h3>
          <div class="form-group">
            <label for="seo_page_title">SEO Page Title</label>
            <input class="form-control" type="text" name="seo_page_title" id="seo_page_title" placeholder="Browser Page Title" value="<?php echo set_value('seo_page_title'); ?>" />
            <p class="help-block">This is the browser page title</p>

          </div>
          <div class="form-group">
            <label for="keywords">Keywords/Tags</label>
            <input class="form-control" type="text" name="keywords" id="keywords" placeholder="Enter keywords" value="<?php echo set_value('keywords'); ?>"/>
            <p class="help-block">Enter comma separated values</p>
          </div>
          <div class="form-group">
            <label for="post_description">Description</label>
            <textarea class="form-control" type="text" name="post_description" id="post_description" placeholder="Enter Post Description" rows="4"><?php echo set_value('post_description'); ?></textarea>
          </div>
              </div>
          </div><!-- /.row -->
     <?php echo form_close(); ?>