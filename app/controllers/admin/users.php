<?php
class Users extends Admin_Controller{
	public function __construct(){
		parent::__construct();
	}

	/**
     * Show list of users
     */
	public function index(){
		//Validate User
        $this->access->validate_user();

        //Get Users
        $data['users'] = $this->User_model->get_all();

		//Load View Into Template
        $this->template->load('default','admin','users/index',$data);
	}

    /**
     * User router
     */
    public function router(){ 
         if($this->input->post('add')){
             redirect('admin/users/add');
             
         } elseif($this->input->post('edit')){
             $user_array = $this->input->post('user_id');
             $user_id = $user_array[0];
              redirect("admin/users/edit/$user_id");
             
         } elseif($this->input->post('delete')){
             $user_array = $this->input->post('user_id');
             $this->delete($user_array); 

         } elseif($this->input->post('activate')){
             $user_array = $this->input->post('user_id');
             $this->activate($user_array);
             
         } elseif($this->input->post('deactivate')){
             $user_array = $this->input->post('user_id');
             $this->deactivate($user_array);
         } else {
             redirect('admin/users');
         }
     }

	/**
     * Add a new user
     */
	public function add(){
        //Validation Rules
        $this->form_validation->set_rules('first_name','First Name','trim|required|min_length[3]|xss_clean');
        $this->form_validation->set_rules('last_name','Last Name','trim|xss_clean');
        $this->form_validation->set_rules('username','Username','trim|required|min_length[3]|xss_clean|callback_check_username_exists');
        $this->form_validation->set_rules('first_name','First Name','trim|required|min_length[3]|xss_clean');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean|callback_check_email_exists');
        $this->form_validation->set_rules('password','Password','trim|required|min_length[4]|max_length[50]|xss_clean');
        $this->form_validation->set_rules('password2','Confirm Password','trim|required|matches[password]|xss_clean');
        $this->form_validation->set_rules('is_activated','Activated','required');
        $this->form_validation->set_rules('address','Address','trim|xss_clean');
        $this->form_validation->set_rules('city','City','trim|xss_clean');
        $this->form_validation->set_rules('state','State','trim|xss_clean');

        if($this->form_validation->run() == FALSE){ 
		  //Validate User
            $this->access->validate_user();

            //Get states array
            $data['states'] = $this->User_model->get_states();
            //Get states array
            $data['groups'] = $this->User_model->get_user_groups();

		    //Load View Into Template
            $this->template->load('default','admin','users/add', $data);
        } else {
            //Upload Image
            $config['upload_path'] = './assets/images/avatars/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '2048';
            $config['max_width'] = '500';
            $config['max_height'] = '500';

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload()){
                $errors = array('error' => $this->upload->display_errors());
                $avatar_image = "nouserimage.jpg";
            } else {
                $data = array('upload_data' => $this->upload->data());
                $avatar_image = $_FILES['userfile']['name'];
            }

            //Encrypt password
            $enc_password = md5($this->input->post('password'));

            //Get random code
            $activation_code = $this->_random_string(10);
            
            //User data array
            $data = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'avatar' => $avatar_image,
                    'email' => $this->input->post('email'),
                    'username' => $this->input->post('username'),
                    'password' => $enc_password,
                    'user_group' => $this->input->post('user_group'),
                    'phone' => $this->input->post('phone'),
                    'address' => $this->input->post('address'),
                    'city' => $this->input->post('city'),
                    'state' => $this->input->post('state'),
                    'postcode' => $this->input->post('postcode'),
                    'is_activated' => $this->input->post('is_activated'),
                    'activation_code' => $activation_code
                
             );

            //User Insert
            $this->User_model->insert($data);

            //Activity Array
            $data = array(
                'resource_id'   =>  $this->db->insert_id(),
                'resource'      => 'user',
                'action'        => 'added',
                'message'       => 'A new user was added',
                'icon'          => 'fa-user'
            ); 

            //Add Activity  
            $this->Activity_model->insert($data);

            //Create Message
            $this->session->set_flashdata('user_added', 'User has been saved');
            
            //Redirect to users
            redirect('admin/users');
        }
	}

	/**
     * Edit a user
     */
	public function edit($user_id){
         //Validation Rules
        $this->form_validation->set_rules('first_name','First Name','trim|required|min_length[3]|xss_clean');
        $this->form_validation->set_rules('last_name','Last Name','trim|xss_clean');
        $this->form_validation->set_rules('username','Username','trim|required|min_length[3]|xss_clean');
        $this->form_validation->set_rules('first_name','First Name','trim|required|min_length[3]|xss_clean');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email|xss_clean');
        $this->form_validation->set_rules('is_activated','Activated','required');
        $this->form_validation->set_rules('address','Address','trim|xss_clean');
        $this->form_validation->set_rules('city','City','trim|xss_clean');
        $this->form_validation->set_rules('state','State','trim|xss_clean');

        if($this->form_validation->run() == FALSE){ 
		  //Validate User
            $this->access->validate_user();
        
            //Get states array
            $data['states'] = $this->User_model->get_states();
            //Get groups array
            $data['groups'] = $this->User_model->get_user_groups();
            //Get user
            $data['this_user'] = $this->User_model->get($user_id);

		  //Load View Into Template
            $this->template->load('default','admin','users/edit', $data);
        } else {
            //Upload Image
            $config['upload_path'] = './assets/images/avatars/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '2048';
            $config['max_width'] = '500';
            $config['max_height'] = '500';

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload()){
                $errors = array('error' => $this->upload->display_errors());
                $avatar_image = "nouserimage.jpg";
            } else {
                $data = array('upload_data' => $this->upload->data());
                $avatar_image = $_FILES['userfile']['name'];
            }

            //User data array
            $data = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'avatar' => $avatar_image,
                    'email' => $this->input->post('email'),
                    'username' => $this->input->post('username'),
                    'user_group' => $this->input->post('user_group'),
                    'phone' => $this->input->post('phone'),
                    'address' => $this->input->post('address'),
                    'city' => $this->input->post('city'),
                    'state' => $this->input->post('state'),
                    'postcode' => $this->input->post('postcode'),
                    'is_activated' => $this->input->post('is_activated')
             );

            //User Insert
            $this->User_model->update_by(array('id'=>$user_id), $data);

            //Activity Array
            $data = array(
                'resource_id'   =>  $user_id,
                'resource'      => 'user',
                'action'        => 'updated',
                'message'       => 'A user was updated',
                'icon'          => 'fa-user'
            ); 

            //Add Activity  
            $this->Activity_model->insert($data);

            //Create Message
            $this->session->set_flashdata('user_updated', 'User(s) have been updated');
            
            //Redirect to users
            redirect('admin/users');
        }
	}

    /**
     * Delete a user
     */
    public function delete($user_array){      
            if(!isset($user_array) || $user_array == ''){
                redirect('admin/users');
            }
            //Delete users in array
            $this->User_model->delete_many($user_array);
         
            //Create Message
            $this->session->set_flashdata('user_deleted', 'User(s) have been deleted');
            
            //Redirect to users
            redirect('admin/users');
     }

     /**
     * Activate a user
     */
     public function activate($user_array){
          if(!isset($user_array) || $user_array == ''){
                redirect('admin/users');
            }
            //Publish users in array
            $this->User_model->activate($user_array);
         
            //Create Message
            $this->session->set_flashdata('user_activated', 'User(s) have been activated');
            
            //Redirect to users
            redirect('admin/users');
     }
     
     /**
     * Deactivate a user
     */
     public function deactivate($user_array){
           if(!isset($user_array) || $user_array == ''){
                redirect('admin/users');
            }
            //Unpublish users in array
            $this->User_model->deactivate($user_array);
         
            //Create Message
            $this->session->set_flashdata('user_deactivated', 'User(s) have been deactivated');
            
            //Redirect to users
            redirect('admin/users');
    }


	/**
     * Display login form and process login
     */
	public function login(){
		//Make sure user is NOT logged in
        $this->access->guest_only();

		$this->form_validation->set_rules('username','Username','trim|required|min_length[6]|xss_clean');
        $this->form_validation->set_rules('password','Password','trim|required|min_length[4]|xss_clean');
        if ($this->form_validation->run() == FALSE) {
			//Load View Into Template
        	$this->template->load('aiologin','admin','users/login');
    	} else {
    		//Get From Post
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $enc_password = md5($password);

            //Validate Username & Password
            $user_id = $this->User_model->get_by(array('username' => $username, 'password' => $enc_password,'user_group' => 2));
    		if($user_id){
    			$user_data = array(
                       'user_id'   => $user_id,
                       'username'  => $username,
                       'logged_in' => true
                   );
                    //Set session userdata
                   $this->session->set_userdata($user_data);
                   
                   //Set message
                   $this->session->set_flashdata('pass_login', 'You are now logged in');
                   redirect('admin/dashboard');
    		} else {
    			//Set Login Error
                $this->session->set_flashdata('fail_login', 'Sorry, the login info that you entered is invalid');
                redirect('admin/login');
    		}
    	}
	}

	 /**
     * Log Out and Destroy Session
     */
    public function logout() {
    	//Validate User
        $this->access->validate_user();

    	$this->session->unset_userdata('logged_in');
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('username');
        $this->session->sess_destroy();
        //Set Logout Message
        $this->session->set_flashdata('logged_out', 'You have been logged out');
        redirect('admin/login');
    }

	 /**
     * Check to see if the email is taken
     */
    public function check_email_exists($email) {
        $this->form_validation->set_message('check_email_exists', 'That email already exists. Please choose a different one');
        if (!$this->User_model->get_by('email', $email)) {
           return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Check to see if the username is taken
     */
    public function check_username_exists($username){
        $this->form_validation->set_message('check_username_exists','That username already exists. Please choose a different one');
       if($this->User_model->check_username_exists($username)){
           return false;
       } else {
           return true;
       }
    }

    /**
     * Get a random string
     */
    private function _random_string($length) {
        $len = $length;
        $base = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789";
        $max = strlen($base) - 1;
        $activatecode = '';
        mt_srand((double) microtime() * 1000000);

        while (strlen($activatecode) < $len + 1) {
            $activatecode.=$base[mt_rand(0, $max)];
        }

            return $activatecode;
    }
	
}