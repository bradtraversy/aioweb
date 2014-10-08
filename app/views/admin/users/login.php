<?php $attributes = array('id' => 'login_form','class' => 'form-signin','role' => 'form'); ?>
<?php echo form_open('admin/users/login',$attributes); ?>
    <h2 class="form-signin-heading text-center">AIO Login </h2>
    <?php echo validation_errors('<p class="alert alert-dismissable alert-danger">'); ?>
<?php if($this->session->flashdata('fail_login')) : ?>
    <?php echo '<p class="error">' .$this->session->flashdata('fail_login') . '</p>'; //Login failed ?>
<?php endif; ?>
<?php if($this->session->flashdata('access_denied')) : ?>
    <?php echo '<p class="error">' .$this->session->flashdata('access_denied') . '</p>'; //Access denied ?>
<?php endif; ?>
<?php if($this->session->flashdata('logged_out')) : ?>
    <?php echo '<p class="success">' .$this->session->flashdata('logged_out') . '</p>'; //Logged out ?>
<?php endif; ?>
    <input name = "username" type="text" class="form-control" placeholder="Username" required autofocus>
    <input name="password" type="password" class="form-control" placeholder="Password" required>
    <label class="checkbox">
    <input name="remember" type="checkbox" value="remember-me"> Remember me
    </label>
    <button name="submit" class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
<?php echo form_close(); ?>