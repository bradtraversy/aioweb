<?php
class User_Groups extends Admin_Controller{
	public function __construct(){
		parent::__construct();
	}

	/**
     * Show list of groups
     */
	public function index(){
		//Validate User
        $this->access->validate_user();

        //Get Users
        $data['user_groups'] = $this->User_Group_model->get_all();

		//Load View Into Template
        $this->template->load('default','admin','user_groups/index',$data);
	}

    /**
     * User router
     */
    public function router(){ 
         if($this->input->post('add')){
             redirect('admin/user_groups/add');
             
         } elseif($this->input->post('edit')){
             $group_array = $this->input->post('group_id');
             $group_id = $group_array[0];
              redirect("admin/user_groups/edit/$group_id");
             
         } elseif($this->input->post('delete')){
             $group_array = $this->input->post('group_id');
             $this->delete($group_array); 

         } elseif($this->input->post('activate')){
             $group_array = $this->input->post('group_id');
             $this->activate($group_array);
             
         } elseif($this->input->post('deactivate')){
             $group_array = $this->input->post('group_id');
             $this->deactivate($group_array);
         } else {
             redirect('admin/user_groups');
         }
     }

	/**
     * Add a new group
     */
	public function add(){
        //Validation Rules
        $this->form_validation->set_rules('group_title','Group Title','trim|required|min_length[3]|xss_clean');

        if($this->form_validation->run() == FALSE){ 
		    //Validate User
            $this->access->validate_user();

		    //Load View Into Template
            $this->template->load('default','admin','user_groups/add');
        } else { 
            //User Group data array
            $data = array(
                    'title' => $this->input->post('group_title') 
             );

            //User Group Insert
            $this->User_Group_model->insert($data);

            //Activity Array
            $data = array(
                'resource_id'   =>  $this->db->insert_id(),
                'resource'      => 'user_group',
                'action'        => 'added',
                'message'       => 'A group was added',
                'icon'          => 'fa-user'
            ); 

            //Add Activity  
            $this->Activity_model->insert($data);

            //Create Message
            $this->session->set_flashdata('group_added', 'User Group has been saved');
            
            //Redirect to users
            redirect('admin/user_groups');
        }
	}

	/**
     * Edit a user group
     */
	public function edit($group_id){
         //Validation Rules
        $this->form_validation->set_rules('group_title','Group Title','trim|required|min_length[3]|xss_clean');

        if($this->form_validation->run() == FALSE){ 
		  //Validate User
            $this->access->validate_user();

            //Get user group
            $data['this_group'] = $this->User_Group_model->get($group_id);

		    //Load View Into Template
            $this->template->load('default','admin','user_groups/edit', $data);
        } else {
            //User data array
            $data = array(
                    'title' => $this->input->post('group_title')
             );

            //User Insert
            $this->User_Group_model->update_by(array('id'=>$group_id), $data);

            //Activity Array
            $data = array(
                'resource_id'   =>  $group_id,
                'resource'      => 'user_group',
                'action'        => 'updated',
                'message'       => 'User Group Updated',
                'icon'          => 'fa-user'
            ); 

            //Add Activity  
            $this->Activity_model->insert($data);

            //Create Message
            $this->session->set_flashdata('group_updated', 'User Group(s) have been updated');
            
            //Redirect to users
            redirect('admin/user_groups');
        }
	}

    /**
     * Delete a user group
     */
    public function delete($group_array){      
            if(!isset($group_array) || $group_array == ''){
                redirect('admin/user_groups');
            }
            //Delete users in array
            $this->User_Group_model->delete_many($group_array);
         
            //Create Message
            $this->session->set_flashdata('group_deleted', 'Group(s) have been deleted');
            
            //Redirect to users
            redirect('admin/user_groups');
     }

}