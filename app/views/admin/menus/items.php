 <script>
 //Menu Item Order
$(document).ready(function(eq){
  $('.update_order').focusout(function(){
    var position = (eq(this).val());
    var item_id = $(this).data('id');
    $.post( "change_order",{ 'position': position,'item_id':item_id },function(data){
      $('.result').html(data);
    })
  });
});
</script>
 <div class="row">
  <div class="col-lg-12">
    <!--Display Messages-->
    <?php if($this->session->flashdata('menu_item_added')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('menu_item_added') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('menu_item_deleted')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('menu_item_deleted') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('menu_item_published')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('menu_item_published') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('menu_item_unpublished')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('menu_item_unpublished') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('menu_item_updated')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('menu_item_updated') . '</p>'; ?>
<?php endif; ?>
  </div>
</div><!-- /.row -->
 <div class="row">
          <div class="col-lg-6">
            <h1>Menu Items <small>Manage Menu Items</small></h1>
          </div>
            <div class="col-lg-6">
              <?php $attributes = array('class' => 'menu_item_form', 'onsubmit' => '
                if(checkDelete){
                  if(!confirm(\'Are you sure you want to delete this menu item?\')){
                    return false;
                  }
                }
              '); ?>
                <?php echo form_open('admin/menus/items_router',$attributes); ?>
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
              <li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			  <li class="active"><i class="fa fa-list"></i> Menu Items</li>
            </ol>
            </div>  
        </div>
          <div class="row">
          <div class="col-lg-12">
            <?php if($menu_items) : ?>
            <div class="table-responsive">
			<fieldset>
              <table class="table table-hover table-striped tablesorter">
                <thead>
                  <tr>
                    <td><div><input type="checkbox" class="checkall"></div></td>
                    <th>ID <i class="fa fa-sort"></i></th>
                    <th>Menu Item Title<i class="fa fa-sort"></i></th>
                    <th>Menu <i class="fa fa-sort"></i></th>
                    <th>Resource <i class="fa fa-sort"></i></th>
                    <th>Order<i class="fa fa-sort"></i></th>
                    <th>Access <i class="fa fa-sort"></i></th>
                    <th>Published <i class="fa fa-sort"></i></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($menu_items as $menu_item) : ?>
                    <tr>
                    <td><div><input type="checkbox" name="menu_item_id[]" id="check_list[]" value="<?php echo $menu_item->id; ?>" /></div></td>
                    <td><?php echo $menu_item->id; ?></td>
                    <td><a href="<?php echo base_url(); ?>admin/menus/edit_item/<?php echo $menu_item->id; ?>"><?php echo $menu_item->title; ?></a></td>
                     <td><?php echo get_title('menus',$menu_item->menu_id); ?></td>
                    <td><?php echo get_resource($menu_item->id); ?></td>
                    <td class="order_field">
                        <input type="text" name="update_order" data-id="<?php echo $menu_item->id; ?>" id="update_order" style="width:30px;text-align:center;" class="update_order" value="<?php echo $menu_item->order; ?>" />
                    </td>
                    <td><?php echo get_title('user_groups',$menu_item->access,'Everyone'); ?></td>
                    <td>
                      <?php if($menu_item->is_published) :?>
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
      <div class="result"></div>
          </div>
        </div><!-- /.row -->