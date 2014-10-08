<div class="row">
  <div class="col-lg-12">
<?php if($this->session->flashdata('post_routes_writable')) : ?> 
<?php echo '<p class="alert alert-dismissable alert-danger">' .$this->session->flashdata('post_routes_writable') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('images_folder')) : ?> 
<?php echo '<p class="alert alert-dismissable alert-danger">' .$this->session->flashdata('images_folder') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('images_blog_folder')) : ?> 
<?php echo '<p class="alert alert-dismissable alert-danger">' .$this->session->flashdata('images_blog_folder') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('post_added')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('post_added') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('post_deleted')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('post_deleted') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('post_published')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('post_published') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('post_unpublished')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('post_unpublished') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('post_featured')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('post_featured') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('post_unfeatured')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('post_unfeatured') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('post_edited')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('post_edited') . '</p>'; ?>
<?php endif; ?>
  </div>
</div>
 <div class="row">
          <div class="col-lg-6">
            <h1>Posts <small>Manage Your Blog Posts</small></h1>
          </div>
            <div class="col-lg-6">
            	 <?php $attributes = array('class' => 'post_form', 'onsubmit' => '
                if(checkDelete){
                  if(!confirm(\'Are you sure you want to delete this post?\')){
                    return false;
                  }
                }
              '); ?>
                <?php echo form_open('admin/posts/router',$attributes); ?>
                <div class="btn-group pull-right">
                    <input type="submit" name="add" id="add" class="btn btn-default" value="New" />
                    <input type="submit" name="edit" id="edit" class="btn btn-default" value="Edit" />
                    <input type="submit" name="publish" id="publish" class="btn btn-default" value="Publish" />
                    <input type="submit" name="unpublish" id="unpublish" class="btn btn-default" value="Unpublish" />
                    <input type="submit" name="delete" id="delete" class="btn btn-default" value="Delete" onclick="checkDelete=true"/>
				</div>
          </div>
        </div><!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
              <li><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
              <li class="active"><i class="fa fa-thumb-tack"></i> Posts</li>
            </ol>
            </div>  
        </div>

        <div class="row">
          <div class="col-lg-12">
             <?php if($posts) : ?>
            <div class="table-responsive">
			<fieldset>
              <table class="table table-hover table-striped tablesorter">
			  <fieldset>
                <thead>
                  <tr>
                    <td><div><input type="checkbox" class="checkall"></div></td>
                    <th>ID <i class="fa fa-sort"></i></th>
                    <th>Post Title<i class="fa fa-sort"></i></th>
                    <th>Date Created <i class="fa fa-sort"></i></th>
                    <th>Category <i class="fa fa-sort"></i></th>
                    <th>Author <i class="fa fa-sort"></i></th>
                    <th>Status <i class="fa fa-sort"></i></th>
                  </tr>
                </thead>
                <tbody>
                	<?php foreach($posts as $post) : ?>
                		<tr>
                    <td><div><input type="checkbox" name="post_id[]" id="check_list[]" value="<?php echo $post->id; ?>" /></div></td>
                    		<td><?php echo $post->id; ?></td>
                    		<td><a href="<?php echo base_url(); ?>admin/posts/edit/<?php echo $post->id; ?>"><?php echo $post->title; ?></a></td>
                    		<td><?php echo date("n-j-Y",strtotime($post->create_date)); ?></td>
                    		<td><?php echo $post->category_title; ?></td>
                    		<td><?php echo $post->first_name.' '.$post->last_name; ?></td>
                    		<td>
                    			<?php if($post->is_published) :?>
                        			<img src="<?php echo base_url(); ?>assets/images/admincheck.png" alt="Yes" />
                      			<?php else : ?>
                        			<img src="<?php echo base_url(); ?>assets/images/adminxmark.png" alt="No" />
                      			<?php endif; ?>
                    		</td>
                  		</tr>
                	<?php endforeach; ?>
                </tbody>
              </table>
			  <fieldset>
            </div>
			<?php echo $this->pagination->create_links(); ?>
			<?php else : ?>
            	No Pages to Display
        	<?php endif; ?>
      <?php echo form_close(); ?>
          </div>
        </div><!-- /.row -->
        