 <div class="row">
  <div class="col-lg-12">
    <!--Display Messages-->
    <?php if($this->session->flashdata('position_added')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('position_added') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('position_deleted')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('position_deleted') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('position_published')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('position_published') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('position_unpublished')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('position_unpublished') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('position_updated')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('position_updated') . '</p>'; ?>
<?php endif; ?>
  </div>
</div><!-- /.row -->
 <div class="row">
          <div class="col-lg-6">
            <h1>Module Positions <small>Manage Positions</small></h1>
          </div>
            <div class="col-lg-6">
              <?php $attributes = array('class' => 'position_form', 'onsubmit' => '
                if(checkDelete){
                  if(!confirm(\'Are you sure you want to delete this position?\')){
                    return false;
                  }
                }
              '); ?>
                <?php echo form_open('admin/modules/position_router',$attributes); ?>
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
			  <li class="active"><i class="fa fa-folder"></i> Positions</li>
            </ol>
            </div>  
        </div>
          <div class="row">
          <div class="col-lg-12">
            <?php if($positions) : ?>
            <div class="table-responsive">
			<fieldset>
              <table class="table table-hover table-striped tablesorter">
                <thead>
                  <tr>
                    <td><div><input type="checkbox" class="checkall"></div></td>
                    <th>ID <i class="fa fa-sort"></i></th>
                    <th>Position Title<i class="fa fa-sort"></i></th>
                    <th>Status <i class="fa fa-sort"></i></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($positions as $position) : ?>
                    <tr>
                    <td><div><input type="checkbox" name="position_id[]" id="check_list[]" value="<?php echo $position->id; ?>" /></div></td>
                    <td><?php echo $position->id; ?></td>
                    <td><a href="<?php echo base_url(); ?>admin/modules/edit_position/<?php echo $position->id; ?>"><?php echo $position->title; ?></a></td>
                    <td>
                      <?php if($position->is_published) :?>
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