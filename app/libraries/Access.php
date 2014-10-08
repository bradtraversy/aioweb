<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Access {
    public function __construct() {
        $this->CI =& get_instance(); //Get super object
        //Load libs, models, configs
        $this->CI->load->library('session');
        $this->CI->config->item('base_url');
    }

    /**
     * Make sure user is logged in
    **/
    public function validate_user(){ 
        //Validate user
        if($this->CI->session->userdata('logged_in') != true){
            //Set error
            $this->CI->session->set_flashdata('access_denied', 'Sorry, you must be logged in');
            redirect('admin/login'); 
        }
    }
    
    /**
     * Make sure user is NOT logged in (Registration, landing page)
    **/
    public function guest_only(){
        //Validate user
        if($this->CI->session->userdata('logged_in') == true){
            redirect('admin/dashboard'); 
        }
    }

}