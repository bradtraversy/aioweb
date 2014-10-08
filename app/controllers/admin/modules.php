<?php
class Modules extends Admin_Controller{
	private $module_limit = 10;

	public function __construct(){
		parent::__construct();

		//Validate User
        $this->access->validate_user();
	}

	public function index(){
		//Configure pagination
    	$config['base_url'] = base_url().'admin/modules/index';
    	$config['total_rows'] = $this->db->count_all('modules');
    	$config['per_page'] = $this->module_limit; 
    	$config['uri_segment'] = 4;

    	//Init pagination
    	$this->pagination->initialize($config);
		//Get Modules
        $data['modules'] = $this->Module_model->limit( $config['per_page'],$this->uri->segment(4))->get_all();
		//Load View Into Template
        $this->template->load('default','admin','modules/index',$data);
	}

	//Directs the checkbox actions on "modules" view
    public function router(){ 
         if($this->input->post('add')){
             redirect('admin/modules/add');
             
         } elseif($this->input->post('edit')){
             $module_array = $this->input->post('module_id');
             $module_id = $module_array[0];
              redirect("admin/modules/edit/$module_id");
            
         } elseif($this->input->post('delete')){
             $module_array = $this->input->post('module_id');
             $this->delete($module_array);
             
         } elseif($this->input->post('publish')){
             $module_array = $this->input->post('module_id');
             $this->publish($module_array);
             
         } elseif($this->input->post('unpublish')){
             $module_array = $this->input->post('module_id');
             $this->unpublish($module_array);

         } elseif($this->input->post('make_global')){
             $module_array = $this->input->post('module_id');
             $this->make_global($module_array);
             
         } elseif($this->input->post('remove_global')){
             $module_array = $this->input->post('module_id');
             $this->remove_global($module_array);

         } else {
             redirect('admin/modules');
         }
     }

     public function add(){
		 //Validation Rules
        $this->form_validation->set_rules('module_title','Module Title','trim|required|min_length[4]|xss_clean');
        $this->form_validation->set_rules('show_title','Show Title','trim|required|xss_clean');  
        $this->form_validation->set_rules('module_content','Module Content','trim|required|xss_clean');  
        $this->form_validation->set_rules('is_global','Global','required');
        $this->form_validation->set_rules('is_published','Publish','required');

    	if($this->form_validation->run() == FALSE){ 
            //Get Modules
            $data['modules'] = $this->Module_model->get_all();
            //Get Module Positions
            $data['positions'] = $this->Module_model->get_positions();

       		//Load View Into Template
        	$this->template->load('default','admin','modules/add', $data);
       	} else {
            //Create Page Data Array
            $data = array(
                'title'         => $this->input->post('module_title'),
                'show_title'    => $this->input->post('show_title'),
                'content'       => $this->input->post('module_content'),
                'position'    	=> $this->input->post('module_position'),
                'order'     	=> $this->input->post('order'),
                'class_suffix'  => $this->input->post('class_suffix'),
                'is_global'   	=> $this->input->post('is_global'),             
                'is_published'  => $this->input->post('is_published')
            );   

            //Module Insert
            $this->Module_model->insert($data);

            //Activity Array
            $data = array(
                'resource_id'   =>  $this->db->insert_id(),
                'resource'      => 'module',
                'action'        => 'added',
                'message'       => 'A new module was added',
                'icon'          => 'fa-bars'
            ); 

            //Add Activity  
            $this->Activity_model->insert($data);

            //Create Message
            $this->session->set_flashdata('module_added', 'Module has been added');
            
            //Redirect to pages
            redirect('admin/modules');
       	}    

	}

	 public function edit($module_id){
		 //Validation Rules
        $this->form_validation->set_rules('module_title','Module Title','trim|required|min_length[4]|xss_clean');
        $this->form_validation->set_rules('show_title','Show Title','trim|required|xss_clean');  
        $this->form_validation->set_rules('module_content','Module Content','trim|required|xss_clean');  
        $this->form_validation->set_rules('is_global','Global','required');
        $this->form_validation->set_rules('is_published','Publish','required');

    	if($this->form_validation->run() == FALSE){ 
            //Get Modules
            $data['this_module'] = $this->Module_model->get($module_id);
            //Get Module Positions
            $data['positions'] = $this->Module_model->get_positions();
            //Get Selected Position
            $data['position'] = $this->Module_model->get_position($module_id);

       		//Load View Into Template
        	$this->template->load('default','admin','modules/edit', $data);
       	} else {
            //Create Page Data Array
            $data = array(
                'title'         => $this->input->post('module_title'),
                'show_title'    => $this->input->post('show_title'),
                'content'       => $this->input->post('module_content'),
                'position'    	=> $this->input->post('module_position'),
                'order'     	=> $this->input->post('order'),
                'class_suffix'  => $this->input->post('class_suffix'),
                'is_global'   	=> $this->input->post('is_global'),             
                'is_published'  => $this->input->post('is_published')
            );   

            //Module Insert
            $this->Module_model->update_by(array('id'=>$module_id), $data);

            //Activity Array
            $data = array(
                'resource_id'   =>  $module_id,
                'resource'      => 'module',
                'action'        => 'updated',
                'message'       => 'A module was updated',
                'icon'          => 'fa-bars'
            ); 

            //Add Activity  
            $this->Activity_model->insert($data);

            //Create Message
            $this->session->set_flashdata('module_updated', 'Module has been updated');
            
            //Redirect to pages
            redirect('admin/modules');
       	}    

	}


     public function delete($module_array){      
            if(!isset($module_array) || $module_array == ''){
                redirect('admin/modules');
            }
            //Delete modules in array
            $this->Module_model->delete_many($module_array);
         
            //Create Message
            $this->session->set_flashdata('module_deleted', 'Module(s) have been deleted');
            
            //Redirect to modules
            redirect('admin/modules');
     }

     public function publish($module_array){
          if(!isset($module_array) || $module_array == ''){
                redirect('admin/modules');
            }
            //Publish modules in array
            $this->Module_model->publish_modules($module_array);
         
            //Create Message
            $this->session->set_flashdata('module_published', 'Module(s) have been published');
            
            //Redirect to modules
            redirect('admin/modules');
     }
     
     public function unpublish($module_array){
           if(!isset($module_array) || $module_array == ''){
                redirect('admin/modules');
            }
         	//Unpublish modules in array
          	$this->Module_model->unpublish_modules($module_array);
         
            //Create Message
            $this->session->set_flashdata('module_unpublished', 'Module(s) have been unpublished');
            
            //Redirect to modules
            redirect('admin/modules');
    }

    public function make_global($module_array){
          if(!isset($module_array) || $module_array == ''){
                redirect('admin/modules');
            }
            //Global modules in array
            $this->Module_model->make_global($module_array);
         
            //Create Message
            $this->session->set_flashdata('module_global', 'Module(s) are global');
            
            //Redirect to modules
            redirect('admin/modules');
     }
     
     public function remove_global($module_array){
           if(!isset($module_array) || $module_array == ''){
                redirect('admin/modules');
            }
         	//Remove global modules in array
          	$this->Module_model->remove_global($module_array);
         
            //Create Message
            $this->session->set_flashdata('module_remove_global', 'Module(s) are not global');
            
            //Redirect to modules
            redirect('admin/modules');
    }

    public function positions(){
    	//Configure pagination
    	$config['base_url'] = base_url().'admin/modules/positions/index';
    	$config['total_rows'] = $this->db->count_all('module_positions');
    	$config['per_page'] = $this->module_limit; 
    	$config['uri_segment'] = 5;

    	//Init pagination
    	$this->pagination->initialize($config);
		//Get Modules
        $data['positions'] = $this->Module_model->limit( $config['per_page'],$this->uri->segment(4))->get_positions();
		//Load View Into Template
        $this->template->load('default','admin','modules/positions',$data);
    }

    //Directs the checkbox actions on "Positions" view
     public function position_router(){ 
         if($this->input->post('add')){
             redirect('admin/modules/add_position');
             
         } elseif($this->input->post('edit')){
             $position_array = $this->input->post('position_id');
             $position_id = $position_array[0];
              redirect("admin/modules/edit_position/$position_id");
             
         } elseif($this->input->post('delete')){
             //Get post ids from checkboxes
             $position_array = $this->input->post('position_id');
             $this->delete_positions($position_array);
             
         } elseif($this->input->post('publish')){
             //Get post ids from checkboxes
             $position_array = $this->input->post('position_id');
             $this->publish_position($position_array);
             
         } elseif($this->input->post('unpublish')){
             //Get post ids from checkboxes
             $position_array = $this->input->post('position_id');
             $this->unpublish_position($position_array);

         } else {
             redirect('admin/modules/positions');
         }
     }

     public function add_position(){
         //Validation Rules
        $this->form_validation->set_rules('position_title','Position Title','trim|required|min_length[3]|xss_clean');
        $this->form_validation->set_rules('is_published','Publish','required');
       
        if($this->form_validation->run() == FALSE){ 
            //Load View Into Template
            $this->template->load('default','admin','modules/add_position');
        } else {
            //Create Position Data Array
            $data = array(
                'title'         => $this->input->post('position_title'),
                'is_published'  => $this->input->post('is_published')
            );   

            //Position Table Insert
            $this->Module_model->insert_position($data);

            //Create Message
            $this->session->set_flashdata('position_added', 'Position has been added');
            
            //Redirect to pages
            redirect('admin/modules/positions');
        }
     }

      public function edit_position($position_id){
         //Validation Rules
        $this->form_validation->set_rules('position_title','Position Title','trim|required|min_length[3]|xss_clean');
        $this->form_validation->set_rules('is_published','Publish','required');
       
        if($this->form_validation->run() == FALSE){ 
        	//Get Position
            $data['this_position'] = $this->Module_model->get_position($position_id);
            //Load View Into Template
            $this->template->load('default','admin','modules/edit_position',$data);
        } else {
            //Create Position Data Array
            $data = array(
                'title'         => $this->input->post('position_title'),
                'is_published'  => $this->input->post('is_published')
            );   

            //Position Table Insert
            $this->Module_model->update_position($position_id,$data);

            //Create Message
            $this->session->set_flashdata('position_added', 'Position has been added');
            
            //Redirect to pages
            redirect('admin/modules/positions');
        }
     }

     public function delete_positions($position_array){      
            if(!isset($position_array) || $position_array == ''){
                redirect('admin/categories');
            }
            //Delete positions in array
            $this->Module_model->delete_positions($position_array);
         
            //Create Message
            $this->session->set_flashdata('position_deleted', 'Position has been deleted');
            
            //Redirect to positions
            redirect('admin/modules/positions');
     }

     public function publish_position($position_array){
          if(!isset($position_array) || $position_array == ''){
                redirect('admin/modules/positions');
            }
            //Publish positions in array
            $this->Module_model->publish_positions($position_array);
         
            //Create Message
            $this->session->set_flashdata('position_published', 'Position has been published');
            
            //Redirect to positions
            redirect('admin/modules/positions');
     } 
     
      public function unpublish_position($position_array){
           if(!isset($position_array) || $position_array == ''){
                redirect('admin/modules/positions');
            }
            //Unpublish position in array
            $this->Module_model->unpublish_positions($position_array);
         
            //Create Message
            $this->session->set_flashdata('position_unpublished', 'Position has been unpublished');
            
            //Redirect to positions
            redirect('admin/modules/positions');
     }

     public function change_order(){
        $position = $this->input->post('position');
        $item_id = $this->input->post('item_id');
        $this->Module_model->update_order($item_id,$position);
    }
	
}