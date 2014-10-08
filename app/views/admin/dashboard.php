<div class="row">
          <div class="col-lg-12">
            <h1>Dashboard <small>AIO Website Management</small></h1>
            <ol class="breadcrumb">
              <li class="active"><i class="fa fa-dashboard"></i> Dashboard</li>
            </ol>
           
          </div>
        </div><!-- /.row -->
        <div class="row msg-row">
          <div class="col-md-12">
            <?php if($this->session->flashdata('task_added')) : ?>
            <?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('task_added') . '</p>'; ?>
            <?php endif; ?>
             <?php if($this->session->flashdata('task_deleted')) : ?>
            <?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('task_deleted') . '</p>'; ?>
            <?php endif; ?>
          </div>
        </div><!-- /.row -->
        <div class="row">
          <div class="col-lg-3">
            <div class="panel panel-info">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-5">
                    <i class="fa fa-pencil fa-5x"></i>
                  </div>
                  <div class="col-xs-7 text-right">
                    <p class="announcement-heading"><?php echo $page_count; ?></p>
                    <p class="announcement-text">Website Pages</p>
                  </div>
                </div>
              </div>
              <a href="#">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-8">
                      <a href="<?php echo base_url(); ?>admin/pages">Manage Pages</a>
                    </div>
                    <div class="col-xs-4 text-right">
                      <i class="fa fa-arrow-circle-right"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="panel panel-warning">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-6">
                    <i class="fa fa-thumb-tack fa-5x"></i>
                  </div>
                  <div class="col-xs-6 text-right">
                    <p class="announcement-heading"><?php echo $post_count; ?></p>
                    <p class="announcement-text">Blog Posts</p>
                  </div>
                </div>
              </div>
              <a href="#">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-7">
                      <a href="<?php echo base_url(); ?>admin/posts">Manage Posts</a>
                    </div>
                    <div class="col-xs-5 text-right">
                      <i class="fa fa-arrow-circle-right"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="panel panel-danger">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-5">
                    <i class="fa fa-comments fa-5x"></i>
                  </div>
                  <div class="col-xs-7 text-right">
                    <p class="announcement-heading"><?php echo $comment_count; ?></p>
                    <p class="announcement-text">Blog Comments</p>
                  </div>
                </div>
              </div>
              <a href="#">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-8">
                      <a href="<?php echo base_url(); ?>admin/posts/comments">Manage Comments</a>
                    </div>
                    <div class="col-xs-4 text-right">
                      <i class="fa fa-arrow-circle-right"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="panel panel-success">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-5">
                    <i class="fa fa-user fa-5x"></i>
                  </div>
                  <div class="col-xs-7 text-right">
                    <p class="announcement-heading"><?php echo $user_count; ?></p>
                    <p class="announcement-text">Registered Users</p>
                  </div>
                </div>
              </div>
              <a href="#">
                <div class="panel-footer announcement-bottom">
                  <div class="row">
                    <div class="col-xs-7">
                      <a href="<?php echo base_url(); ?>admin/users">Manage Users</a>
                    </div>
                    <div class="col-xs-5 text-right">
                      <i class="fa fa-arrow-circle-right"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>
        </div><!-- /.row -->

        <!--<div class="row">
          <div class="col-lg-12">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Traffic Statistics: October 1, 2013 - October 31, 2013</h3>
              </div>
              <div class="panel-body">
                <div id="morris-chart-area"></div>
              </div>
            </div>
          </div>
        </div><!-- /.row -->

        <div class="row">
          <div class="col-lg-4">
            <div class="panel panel-primary dash-panel">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-long-arrow-right"></i> Latest Blog Posts</h3>
              </div>
              <div class="panel-body">
                  <div class="list-group">
                  	<?php foreach($posts as $post) : ?>
                <a href="<?php echo base_url(); ?>admin/posts/edit/<?php echo $post->id; ?>" class="list-group-item">
                  <h4 class="list-group-item-heading"><?php echo $post->title; ?></h4>
                  <p class="list-group-item-text"><?php echo word_limiter($post->body,13); ?></p>
                </a>
                	<?php endforeach; ?>
               
              </div>
                <div id="morris-chart-donut"></div>
                <div class="text-right">
                  <a href="<?php echo base_url(); ?>admin/posts">View All <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="panel panel-primary dash-panel">
              <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-clock-o"></i> Recent Activity</h3>
              </div>
              <div class="panel-body">
                <div class="list-group">
                	<?php foreach($activities as $activity) : ?>
                		<a href="<?php echo base_url(); ?>admin/<?php echo $activity->resource; ?>s" class="list-group-item">
                    		<span class="badge"><?php echo get_time_elapsed($activity->timestamp); ?> ago</span>
                    		<i class="fa <?php echo $activity->icon; ?>"></i> <?php echo $activity->message; ?>
                  		</a>
                	<?php endforeach; ?>
                </div>
                <div class="text-right">
                  <a href="#">View All Activity <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="list-group dash-panel">
  <a href="#" class="list-group-item active">
   <h3 class="panel-title"><i class="fa fa-globe"></i> Quick Actions</h3>
  </a>
  <a href="<?php echo base_url(); ?>admin/pages/add" class="list-group-item">Create a Website Page</a>
  <a href="<?php echo base_url(); ?>admin/posts/add" class="list-group-item">Create a Blog Post</a>
  <a href="<?php echo base_url(); ?>admin/posts/comments" class="list-group-item">Moderate Comments</a>
  <a href="<?php echo base_url(); ?>admin/categories/add" class="list-group-item">Create a Blog Category</a>
  <a href="<?php echo base_url(); ?>admin/forms/add" class="list-group-item">Create a New Website Form</a>
  <a href="<?php echo base_url(); ?>admin/modules/add" class="list-group-item">Create a Module</a>
  <a href="<?php echo base_url(); ?>admin/modules/add_position" class="list-group-item">Create a Module Position</a>
  <a href="<?php echo base_url(); ?>admin/users/add" class="list-group-item">Add a Website User</a>
  <a href="<?php echo base_url(); ?>admin/user_groups/add" class="list-group-item">Create a User Group</a>
  <a href="<?php echo base_url(); ?>admin/settings" class="list-group-item">Edit Website Settings</a>
</div>
          </div>
        </div><!-- /.row -->
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-primary">
       <div class="panel-heading">
    <h3 class="panel-title"><i class="fa fa-tasks"></i> Task Manager</h3>
  </div>
  <form class="form-inline task-form" method="post" role="form" action="<?php echo base_url(); ?>admin/dashboard/add_task">
  <div class="form-group">
    <label for="task">Task</label>
    <input name="task" type="text" class="form-control" id="task" placeholder="Enter Task">
  </div>
  <div class="form-group">
  <label for="severity">Severity</label>
   <select name="severity" class="form-control">
  <option value="Low">Low</option>
  <option value="Normal">Normal</option>
  <option value="High">High</option>
  <option value="Urgent">Urgent</option>
</select>
  </div>
  <div class="form-group">
    <label class="due_date" for="due_date">Due Date</label>
    <input name="due_date" type="date" class="form-control" placeholder="Enter Due Date">
  </div>
  <button type="submit" class="btn btn-default task-btn">Add Task</button>
</form>
<?php if($tasks) : ?>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Task</th>
          <th>Severity</th>
          <th>Due Date</th>
          <td></td>
        </tr>
      </thead>
      <tbody>
          <?php foreach($tasks as $task) : ?>
          <?php $severity = get_severity($task->severity); ?>
          <tr>
            <td><?php echo $task->task; ?></td>
            <td><span class="label <?php echo $severity; ?>"><?php echo $task->severity; ?></span></td>
            <td><?php echo $task->due_date; ?></td>
            <td><a href="<?php echo base_url(); ?>admin/dashboard/mark_task_complete/<?php echo $task->id; ?>" class="btn btn-primary">Mark Complete</a></td>
          </tr>
          <?php endforeach; ?>
      </tbody>
    </table>
    <?php else : ?>
          <p class="no-tasks">No Tasks To Display</p>
      <?php endif; ?>
  </div>
  </div>
</div>
