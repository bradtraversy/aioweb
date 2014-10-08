 <script>
 //Menu Item Order
$(document).ready(function(eq){
  $('.update_order').focusout(function(){
    var position = (eq(this).val());
    var item_id = $(this).data('id');
    $.post( "modules/change_order",{ 'position': position,'item_id':item_id },function(data){
      $('.result').html(data);
    })
  });
});
</script>
<div class="row">
  <div class="col-lg-12">
<?php if($this->session->flashdata('module_added')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('module_added') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('module_deleted')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('module_deleted') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('module_published')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('module_published') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('module_unpublished')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('module_unpublished') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('module_global')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('module_global') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('module_remove_global')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('module_remove_global') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('module_updated')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('module_updated') . '</p>'; ?>
<?php endif; ?>
  </div>
</div>
<div class="row">
          <div class="col-lg-5">
            <h1>Modules <small>Manage Website Modules</small></h1>
          </div>
            <div class="col-lg-7">
                 <?php $attributes = array('class' => 'module_form', 'onsubmit' => '
                if(checkDelete){
                  if(!confirm(\'Are you sure you want to delete this module?\')){
                    return false;
                  }
                }
              '); ?>
                <?php echo form_open('admin/modules/router',$attributes); ?>
                <div class="btn-group pull-right">
                    <input type="submit" name="add" id="add" class="btn btn-default" value="New" />
                    <input type="submit" name="edit" id="edit" class="btn btn-default" value="Edit" />
                    <input type="submit" name="publish" id="publish" class="btn btn-default" value="Publish" />
                    <input type="submit" name="unpublish" id="unpublish" class="btn btn-default" value="Unpublish" />
                    <input type="submit" name="make_global" id="make_global" class="btn btn-default" value="Make Global" />
                    <input type="submit" name="remove_global" id="remove_global" class="btn btn-default" value="Remove Global" />
                    <input type="submit" name="delete" id="delete" class="btn btn-default" value="Delete" onclick="checkDelete=true"/>
        </div>
          </div>
        </div><!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
              <li><a href="<?php echo base_url(); ?>admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
              <li class="active"><i class="fa fa-bars"></i> Modules</li>
            </ol>
            </div>  
        </div>

        <div class="row">
          <div class="col-lg-12">
             <?php if($modules) : ?>
            <div class="table-responsive">
			<fieldset>
              <table class="table table-hover table-striped tablesorter">
                <thead>
                  <tr>
                    <td><div><input type="checkbox" class="checkall"></div></td>
                    <th>ID <i class="fa fa-sort"></i></th>
                    <th>Module Name<i class="fa fa-sort"></i></th>
                    <th>Position <i class="fa fa-sort"></i></th>
                    <th>Order <i class="fa fa-sort"></i></th>
                    <th>Editable <i class="fa fa-sort"></i></th>
                    <th>Global <i class="fa fa-sort"></i></th>
                    <th>Published <i class="fa fa-sort"></i></th>
                  </tr>
                </thead>
                <tbody>
                 <?php foreach($modules as $module) : ?>
                    <tr>
                    <td><div><input type="checkbox" name="module_id[]" id="check_list[]" value="<?php echo $module->id; ?>" /></div></td>
                    <td><?php echo $module->id; ?></td>
                    <td><a href="<?php echo base_url(); ?>admin/modules/edit/<?php echo $module->id; ?>"><?php echo ucwords($module->title); ?></a></td>
                    <td><?php echo get_title('module_positions',$module->position); ?></td>
                    <td class="order_field">
                        <input type="text" name="update_order" data-id="<?php echo $module->id; ?>" id="update_order" style="width:30px;text-align:center;" class="update_order" value="<?php echo $module->order; ?>" />
                    </td>
                    <td>
                        <?php if($module->is_editable) :?>
                            <img src="<?php echo base_url(); ?>assets/images/admincheck.png" alt="Yes" />
                        <?php else : ?>
                            <img src="<?php echo base_url(); ?>assets/images/adminxmark.png" alt="No" />
                        <?php endif; ?>
                    </td> <td>
                        <?php if($module->is_global) :?>
                            <img src="<?php echo base_url(); ?>assets/images/admincheck.png" alt="Yes" />
                        <?php else : ?>
                            <img src="<?php echo base_url(); ?>assets/images/adminxmark.png" alt="No" />
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($module->is_published) :?>
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
              No Modules to Display
          <?php endif; ?>
      <?php echo form_close(); ?>
          </div>
        </div><!-- /.row -->