 <div class="row">
  <div class="col-lg-12">
    <!--Display Messages-->
    <?php if($this->session->flashdata('comment_deleted')) : ?>
    <?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('comment_deleted') . '</p>'; ?>
    <?php endif; ?>
    <?php if($this->session->flashdata('comment_approved')) : ?>
    <?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('comment_approved') . '</p>'; ?>
    <?php endif; ?>
    <?php if($this->session->flashdata('comment_unapproved')) : ?>
    <?php echo '<p class="alert alert-dismissable alert-success">' .$this->session->flashdata('comment_unapproved') . '</p>'; ?>
    <?php endif; ?>
  </div>
</div><!-- /.row -->
 <div class="row">
          <div class="col-lg-6">
            <h1>Comments <small>Manage Blog Comments</small></h1>
          </div>
            <div class="col-lg-6">
               <?php $attributes = array('class' => 'comment_form', 'onsubmit' => '
                if(checkDelete){
                  if(!confirm(\'Are you sure you want to delete this comment?\')){
                    return false;
                  }
                }
              '); ?>
                <?php echo form_open('admin/posts/router',$attributes); ?>
                <div class="btn-group pull-right">
                    <input type="submit" name="approve_comment" id="approve_comment" class="btn btn-default" value="Approve" />
                    <input type="submit" name="unapprove_comment" id="unapprove_comment" class="btn btn-default" value="Unapprove" />
                    <input type="submit" name="delete_comment" id="delete_comment" class="btn btn-default" value="Delete" onclick="checkDelete=true"/>
				        </div>
          </div>
        </div><!-- /.row -->
          
          <div class="row">
          <div class="col-lg-12">
             <?php if($comments) : ?>
            <div class="table-responsive">
              <table class="table table-hover table-striped tablesorter">
                <thead>
                  <tr>
                    <td><div><input type="checkbox" class="checkall"></div></td>
                    <th width="45">ID <i class="fa fa-sort"></i></th>
                    <th width="100">Author<i class="fa fa-sort"></i></th>
                    <th>Date <i class="fa fa-sort"></i></th>
                    <th>Comment <i class="fa fa-sort"></i></th>
                    <th width="100">Status <i class="fa fa-sort"></i></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($comments as $comment) : ?>
                     <tr>
                    <td><div><input type="checkbox" name="comment_id[]" id="check_list[]" value="<?php echo $comment->id; ?>" /></div></td>
                    <td><?php echo $comment->id; ?></td>
                    <td><?php echo $comment->author_name; ?></td>
                    <td><?php echo $comment->create_date; ?></td>
                    <td><?php echo $comment->body; ?></td>
                    <td>
                      <?php if($comment->is_approved) :?>
                        <img src="<?php echo base_url(); ?>assets/images/admincheck.png" alt="Yes" />
                      <?php else : ?>
                        <img src="<?php echo base_url(); ?>assets/images/adminxmark.png" alt="No" />
                      <?php endif; ?>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
			       <?php echo $this->pagination->create_links(); ?>
          <?php else : ?>
            No Comments to Display
        <?php endif; ?>
      <?php echo form_close(); ?>
          </div>
        </div><!-- /.row -->