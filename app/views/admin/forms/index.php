 <div class="row">
  <div class="col-lg-12">
    <!--Display Messages-->
    <?php if($this->session->flashdata('form_added')) : ?>
    <?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('form_added') . '</p>'; ?>
    <?php endif; ?>
    <?php if($this->session->flashdata('form_deleted')) : ?>
    <?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('form_deleted') . '</p>'; ?>
    <?php endif; ?>
    <?php if($this->session->flashdata('form_published')) : ?>
    <?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('form_published') . '</p>'; ?>
    <?php endif; ?>
    <?php if($this->session->flashdata('form_unpublished')) : ?>
    <?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('form_unpublished') . '</p>'; ?>
    <?php endif; ?>
    <?php if($this->session->flashdata('form_updated')) : ?>
    <?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('form_updated') . '</p>'; ?>
    <?php endif; ?>
     <?php if($this->session->flashdata('form_data_not_inserted')) : ?>
    <?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('form_data_not_inserted') . '</p>'; ?>
    <?php endif; ?>
  </div>
</div><!-- /.row -->
 <div class="row">
          <div class="col-lg-6">
            <h1>Forms <small>Manage Your Website Forms</small></h1>
          </div>
            <div class="col-lg-6">
            	 <?php $attributes = array('class' => 'form_form', 'onsubmit' => '
                if(checkDelete){
                  if(!confirm(\'Are you sure you want to delete this form?\')){
                    return false;
                  }
                }
              '); ?>
                <?php echo form_open('admin/forms/router',$attributes); ?>
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
              <li><a href="index.html"><i class="fa fa-dashboard"></i> Dashboard</a></li>
              <li class="active"><i class="fa fa-envelope-o"></i> Forms</li>
            </ol>
            </div>  
        </div>

        <div class="row">
          <div class="col-lg-12">
            <?php if($forms) : ?>
            <div class="table-responsive">
			<fieldset>
              <table class="table table-hover table-striped tablesorter">
                <thead>
                  <tr>
                   <td><div><input type="checkbox" class="checkall"></div></td>
                    <th>ID <i class="fa fa-sort"></i></th>
                    <th>Form Name<i class="fa fa-sort"></i></th>
                    <th>Type <i class="fa fa-sort"></i></th>
                    <th>Status <i class="fa fa-sort"></i></th>
                    <th>Form Fields <i class="fa fa-sort"></i></th>
                  </tr>
                </thead>
                <tbody>
                   <?php foreach ($forms as $form): ?>
                    <tr>
                    	<td><div><input type="checkbox" name="form_id[]" id="check_list[]" value="<?php echo $form->id; ?>" /></div></td>
                    	<td><?php echo $form->id; ?></td>
                    <td><a href="<?php echo base_url(); ?>admin/forms/edit/<?php echo $form->id; ?>"><?php echo $form->title; ?></a></td>
                    	<td><?php echo $form->type; ?></td>
                    	<td>
                      <?php if($form->is_published) :?>
                        <img src="<?php echo base_url(); ?>assets/images/admincheck.png" alt="Yes" />
                      <?php else : ?>
                        <img src="<?php echo base_url(); ?>assets/images/adminxmark.png" alt="No" />
                      <?php endif; ?>
                    </td>
                    	<td><a href="<?php echo base_url(); ?>admin/forms/fields/<?php echo $form->id; ?>">Manage Fields</a></td>
                  	</tr>
              		<?php endforeach; ?>
                </tbody>
              </table>
			  </fieldset>
            </div>
             <?php echo $this->pagination->create_links(); ?>
          <?php else : ?>
            No Forms to Display
        <?php endif; ?>
      <?php echo form_close(); ?>
          </div>
        </div><!-- /.row -->