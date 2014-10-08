<div class="row">
  <div class="col-lg-12">
    <!--Display Messages-->
    <?php if($this->session->flashdata('page_routes_writable')) : ?> 
    <?php echo '<p class="alert alert-dismissable alert-danger">' .$this->session->flashdata('page_routes_writable') . '</p>'; ?>
    <?php endif; ?>
    <?php if($this->session->flashdata('page_added')) : ?>
    <?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('page_added') . '</p>'; ?>
    <?php endif; ?>
    <?php if($this->session->flashdata('page_deleted')) : ?>
    <?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('page_deleted') . '</p>'; ?>
    <?php endif; ?>
    <?php if($this->session->flashdata('page_published')) : ?>
    <?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('page_published') . '</p>'; ?>
    <?php endif; ?>
    <?php if($this->session->flashdata('page_unpublished')) : ?>
    <?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('page_unpublished') . '</p>'; ?>
    <?php endif; ?>
    <?php if($this->session->flashdata('page_featured')) : ?>
    <?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('page_featured') . '</p>'; ?>
    <?php endif; ?>
    <?php if($this->session->flashdata('page_unfeatured')) : ?>
    <?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('page_unfeatured') . '</p>'; ?>
    <?php endif; ?>
    <?php if($this->session->flashdata('page_updated')) : ?>
    <?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('page_updated') . '</p>'; ?>
    <?php endif; ?>
  </div>
</div><!-- /.row -->
<div class="row">
          <div class="col-lg-6">
            <h1>Pages <small>Manage Your Website Pages</small></h1>
          </div>
            <div class="col-lg-6">
              <?php $attributes = array('class' => 'page_form', 'onsubmit' => '
                if(checkDelete){
                  if(!confirm(\'Are you sure you want to delete this page?\')){
                    return false;
                  }
                }
              '); ?>
                <?php echo form_open('admin/pages/router',$attributes); ?>
                <div class="btn-group pull-right">
                    <input type="submit" name="add" id="add" class="btn btn-default" value="New" />
                    <input type="submit" name="edit" id="edit" class="btn btn-default" value="Edit" />
                     <input type="submit" name="publish" id="publish" class="btn btn-default" value="Publish" />
                    <input type="submit" name="unpublish" id="unpublish" class="btn btn-default" value="Unpublish" />
                    <input type="submit" name="feature" id="feature" class="btn btn-default" value="Feature" />
                    <input type="submit" name="unfeature" id="unfeature" class="btn btn-default" value="Unfeature" />
                    <input type="submit" name="delete" id="delete" class="btn btn-default" value="Delete" onclick="checkDelete=true"/>
              </div>
          </div>
        </div><!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
              <li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
              <li class="active"><i class="fa fa-pencil"></i> Pages</li>
            </ol>
            </div>  
        </div>
        <div class="row">
          <div class="col-lg-12">
            <?php if($pages) : ?>
            <div class="table-responsive">
			       <fieldset>
              <table class="table table-hover table-striped tablesorter">
                <thead>
                  <tr>
                    <td><div><input type="checkbox" class="checkall"></div></td>
                    <th>ID <i class="fa fa-sort"></i></th>
                    <th>Page Title<i class="fa fa-sort"></i></th>
                    <th>Date Created <i class="fa fa-sort"></i></th>
                     <th>Access <i class="fa fa-sort"></i></th>
                    <th>Featured <i class="fa fa-sort"></i></th>
                    <th>Status <i class="fa fa-sort"></i></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($pages as $page): ?>
                    <tr>
                    <td><div><input type="checkbox" name="page_id[]" id="check_list[]" value="<?php echo $page->id; ?>" /></div></td>
                    <td><?php echo $page->id; ?></td>
                    <td><a href="<?php echo base_url(); ?>admin/pages/edit/<?php echo $page->id; ?>"><?php echo $page->title; ?></a></td>
                    <td><?php echo date("n-j-Y",strtotime($page->create_date)); ?></td>
                    <td><?php echo get_access_group($page->access); ?></td>
                    <td>
                      <?php if($page->is_featured) :?>
                        <img src="<?php echo base_url(); ?>assets/images/admincheck.png" alt="Yes" />
                      <?php else : ?>
                        <img src="<?php echo base_url(); ?>assets/images/adminxmark.png" alt="No" />
                      <?php endif; ?>
                    </td>
                    <td>
                      <?php if($page->is_published) :?>
                        <img src="<?php echo base_url(); ?>assets/images/admincheck.png" alt="Yes" />
                      <?php else : ?>
                        <img src="<?php echo base_url(); ?>assets/images/adminxmark.png" alt="No" />
                      <?php endif; ?>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
			  </fieldset>
            </div>
     <?php echo $this->pagination->create_links(); ?>
          <?php else : ?>
            No Pages to Display
        <?php endif; ?>
      <?php echo form_close(); ?>
          </div>
        </div><!-- /.row -->