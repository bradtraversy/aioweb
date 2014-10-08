<?php
//Global Controller
class MY_Controller extends CI_Controller{
    public function __construct() {
        parent::__construct();
    
        //Set timezone
        date_default_timezone_set('America/New_York');

        //Load All Models
        $this->load->model('Page_model');
        $this->load->model('Module_model');
        $this->load->model('User_model');
        $this->load->model('User_Group_model');
        $this->load->model('Menu_model');
        $this->load->model('Post_model');
        $this->load->model('Category_model');
        $this->load->model('Form_model');
        $this->load->model('Settings_model');
        $this->load->model('Dashboard_model');
        $this->load->model('Activity_model');
    }
}


//Admin Controller
class Admin_Controller extends MY_Controller{
    public function __construct() {
        parent::__construct();
        
    }
}

//Public Controller
class Public_Controller extends MY_Controller{
    public function __construct() {
        parent::__construct();
        
    }
}
