<div class="row">
  <div class="col-lg-12">
<?php if($this->session->flashdata('user_added')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('user_added') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('user_deleted')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('user_deleted') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('user_activated')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('user_activated') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('user_deactivated')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('user_deactivated') . '</p>'; ?>
<?php endif; ?>
<?php if($this->session->flashdata('user_updated')) : ?>
<?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('user_updated') . '</p>'; ?>
<?php endif; ?>
  </div>
</div>
<div class="row">
          <div class="col-lg-6">
            <h1>Users <small>Manage Registered Users</small></h1>
          </div>
            <div class="col-lg-6">
               <?php $attributes = array('class' => 'user_form', 'onsubmit' => '
                if(checkDelete){
                  if(!confirm(\'Are you sure you want to delete this user?\')){
                    return false;
                  }
                }
              '); ?>
                <?php echo form_open('admin/users/router',$attributes); ?>
                <div class="btn-group pull-right">
                   <input type="submit" name="add" id="add" class="btn btn-default" value="New" />
                    <input type="submit" name="edit" id="edit" class="btn btn-default" value="Edit" />
                    <input type="submit" name="activate" id="activate" class="btn btn-default" value="Activate" />
                    <input type="submit" name="deactivate" id="deactivate" class="btn btn-default" value="Deactivate" />
                    <input type="submit" name="delete" id="delete" class="btn btn-default" value="Delete" onclick="checkDelete=true"/>
        </div>
          </div>
        </div><!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
              <li><a href="index.html"><i class="fa fa-dashboard"></i> Dashboard</a></li>
              <li class="active"><i class="fa fa-user"></i> Users</li>
            </ol>
            </div>  
        </div>

        <div class="row">
          <div class="col-lg-12">
            <?php if($users) : ?>
            <div class="table-responsive">
			<fieldset>
              <table class="table table-hover table-striped tablesorter">
                <thead>
                  <tr>
                    <td><div><input type="checkbox" class="checkall"></div></td>
                    <th>ID <i class="fa fa-sort"></i></th>
                    <th>Full Name<i class="fa fa-sort"></i></th>
                    <th>Username <i class="fa fa-sort"></i></th>
                    <th>Email <i class="fa fa-sort"></i></th>
                    <th>Role <i class="fa fa-sort"></i></th>
                    <th>Activated <i class="fa fa-sort"></i></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($users as $user) : ?>
                    <tr>
                    <td><div><input type="checkbox" name="user_id[]" id="check_list[]" value="<?php echo $user->id; ?>" /></div></td>
                      <td><?php echo $user->id; ?></td>
                      <td><a href="<?php echo base_url(); ?>admin/users/edit/<?php echo $user->id; ?>"><?php echo $user->first_name.' '.$user->last_name; ?></a></td>
                      <td><?php echo $user->username; ?></td>
                      <td><?php echo $user->email; ?></td>
                      <td><?php echo get_user_group($user->user_group); ?></td>
                      <td>
                          <?php if($user->is_activated) :?>
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
              No Users to Display
          <?php endif; ?>
      <?php echo form_close(); ?>
          </div>
        </div><!-- /.row -->