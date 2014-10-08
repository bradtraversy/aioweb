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
    <?php if($this->session->flashdata('field_added')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('field_added') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('field_deleted')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('field_deleted') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('field_published')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('field_published') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('field_unpublished')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('field_unpublished') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('field_updated')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('field_updated') . '</p>'; ?>
<?php endif; ?>
  </div>
</div><!-- /.row -->
 <div class="row">
          <div class="col-lg-6">
            <h1>Form Fileds <small></small></h1>
          </div>
            <div class="col-lg-6">
              <?php $attributes = array('class' => 'field_form', 'onsubmit' => '
                if(checkDelete){
                  if(!confirm(\'Are you sure you want to delete this field?\')){
                    return false;
                  }
                }
              '); ?>
                <?php echo form_open('admin/forms/fields_router/'.$form->id,$attributes); ?>
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
			         <li><a href="<?php echo base_url(); ?>admin/forms"><i class="fa fa-envelope"></i> Forms</a></li>
               <li class="active"><i class="fa fa-pencil"></i> Fields</li>
            </ol>
            </div>  
        </div>
          <div class="row">
          <div class="col-lg-12">
            <?php if($fields) : ?>
            <div class="table-responsive">
			<fieldset>
              <table class="table table-hover table-striped tablesorter">
                <thead>
                  <tr>
                    <td><div><input type="checkbox" class="checkall"></div></td>
                    <th>ID <i class="fa fa-sort"></i></th>
                    <th>Field Label<i class="fa fa-sort"></i></th>
                    <th>Type <i class="fa fa-sort"></i></th>
                    <th>Status <i class="fa fa-sort"></i></th>
                    <th>Order <i class="fa fa-sort"></i></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($fields as $field) : ?>
                    <tr>
                    <td><div><input type="checkbox" name="field_id[]" id="check_list[]" value="<?php echo $field->id; ?>" /></div></td>
                    <td><?php echo $field->id; ?></td>
                    <td><a href="<?php echo base_url(); ?>admin/forms/fields/edit/<?php echo $field->id; ?>"><?php echo $field->label; ?></a></td>
                    <td><?php echo $field->type; ?></td>
                    <td>
                      <?php if($field->is_published) :?>
                        <img src="<?php echo base_url(); ?>assets/images/admincheck.png" alt="Yes" />
                      <?php else : ?>
                        <img src="<?php echo base_url(); ?>assets/images/adminxmark.png" alt="No" />
                      <?php endif; ?>
                    </td>
                    <td class="order_field">
                        <input type="text" name="update_order" data-id="<?php echo $field->id; ?>" id="update_order" style="width:30px;text-align:center;" class="update_order" value="<?php echo $field->order; ?>" />
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
			  </fieldset>
            </div>
			      <?php echo $this->pagination->create_links(); ?>
             <?php else : ?>
            No Fields to Display
        <?php endif; ?>
      <?php echo form_close(); ?>
          </div>
        </div><!-- /.row -->