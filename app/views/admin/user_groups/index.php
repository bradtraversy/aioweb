 <div class="row">
  <div class="col-lg-12">
    <!--Display Messages-->
    <?php if($this->session->flashdata('group_added')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('group_added') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('group_deleted')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('group_deleted') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('group_updated')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('group_updated') . '</p>'; ?>
<?php endif; ?>
  </div>
</div><!-- /.row -->
 <div class="row">
          <div class="col-lg-6">
            <h1>User Groups <small>Manage User Groups</small></h1>
          </div>
            <div class="col-lg-6">
              <?php $attributes = array('class' => 'group_form', 'onsubmit' => '
                if(checkDelete){
                  if(!confirm(\'Are you sure you want to delete this group?\')){
                    return false;
                  }
                }
              '); ?>
                <?php echo form_open('admin/user_groups/router',$attributes); ?>
                <div class="btn-group pull-right">
                   <input type="submit" name="add" id="add" class="btn btn-default" value="New" />
                    <input type="submit" name="edit" id="edit" class="btn btn-default" value="Edit" />
     
                    <input type="submit" name="delete" id="delete" class="btn btn-default" value="Delete" onclick="checkDelete=true"/>
				</div>
          </div>
        </div><!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
              <li><a href="<?php echo base_url(); ?>admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
			  <li class="active"><i class="fa fa-user"></i> User Groups</li>
            </ol>
            </div>  
        </div>
          <div class="row">
          <div class="col-lg-12">
            <?php if($user_groups) : ?>
            <div class="table-responsive">
			<fieldset>
              <table class="table table-hover table-striped tablesorter">
                <thead>
                  <tr>
                    <td width="50"><div><input type="checkbox" class="checkall"></div></td>
                    <th width="70">ID <i class="fa fa-sort"></i></th>
                    <th>User Group<i class="fa fa-sort"></i></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($user_groups as $group) : ?>
                    <tr>
                    <td><div><input type="checkbox" name="group_id[]" id="check_list[]" value="<?php echo $group->id; ?>" /></div></td>
                    <td><?php echo $group->id; ?></td>
                    <td><a href="<?php echo base_url(); ?>admin/user_groups/edit/<?php echo $group->id; ?>"><?php echo $group->title; ?></a></td>
                   
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
			  </fieldset>
            </div>
			      <?php echo $this->pagination->create_links(); ?>
             <?php else : ?>
            No Groups to Display
        <?php endif; ?>
      <?php echo form_close(); ?>
          </div>
        </div><!-- /.row -->