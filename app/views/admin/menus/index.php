<div class="row">
  <div class="col-lg-12">
<?php if($this->session->flashdata('menu_added')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('menu_added') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('menu_deleted')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('menu_deleted') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('menu_published')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('menu_published') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('menu_unpublished')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('menu_unpublished') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('menu_updated')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('menu_updated') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('menu_global')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('menu_global') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('menu_remove_global')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('menu_remove_global') . '</p>'; ?>
<?php endif; ?>
  </div>
</div>
<div class="row">
          <div class="col-lg-5">
            <h1>Menus <small>Manage Website Menus</small></h1>
          </div>
            <div class="col-lg-7">
                 <?php $attributes = array('class' => 'menu_form', 'onsubmit' => '
                if(checkDelete){
                  if(!confirm(\'Are you sure you want to delete this menu?\')){
                    return false;
                  }
                }
              '); ?>
                <?php echo form_open('admin/menus/router',$attributes); ?>
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
              <li class="active"><i class="fa fa-list"></i> Menus</li>
            </ol>
            </div>  
        </div>

        <div class="row">
          <div class="col-lg-12">
             <?php if($menus) : ?>
            <div class="table-responsive">
			<fieldset>
              <table class="table table-hover table-striped tablesorter">
                <thead>
                  <tr>
                    <td><div><input type="checkbox" class="checkall"></div></td>
                    <th>ID <i class="fa fa-sort"></i></th>
                    <th>Menu Title<i class="fa fa-sort"></i></th>
                    <th>Position <i class="fa fa-sort"></i></th>
                    <th>Order <i class="fa fa-sort"></i></th>
                    <th>Access <i class="fa fa-sort"></i></th>
                    <th>Global <i class="fa fa-sort"></i></th>
                    <th>Published <i class="fa fa-sort"></i></th>
                  </tr>
                </thead>
                <tbody>
                 <?php foreach($menus as $menu) : ?>
                    <tr>
                    <td><div><input type="checkbox" name="menu_id[]" id="check_list[]" value="<?php echo $menu->id; ?>" /></div></td>
                    <td><?php echo $menu->id; ?></td>
                    <td><a href="<?php echo base_url(); ?>admin/menus/edit/<?php echo $menu->id; ?>"><?php echo $menu->title; ?></a></td>
                    <td><?php echo get_title('module_positions',$menu->module_position); ?></td>
                    <td><?php echo $menu->order; ?></td>
                    <td>
                       <?php echo get_title('user_groups',$menu->access,'Everyone'); ?>
                    </td> <td>
                        <?php if($menu->is_global) :?>
                            <img src="<?php echo base_url(); ?>assets/images/admincheck.png" alt="Yes" />
                        <?php else : ?>
                            <img src="<?php echo base_url(); ?>assets/images/adminxmark.png" alt="No" />
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($menu->is_published) :?>
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
         
      <?php else : ?>
              No menus to Display
          <?php endif; ?>
      <?php echo form_close(); ?>
          </div>
        </div><!-- /.row -->