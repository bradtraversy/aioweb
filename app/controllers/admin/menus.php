<?php
class Menus extends Admin_Controller{
	public function __construct(){
		parent::__construct();

		//Validate User
        $this->access->validate_user();
	}

	public function index(){
		//Get Menus
        $data['menus'] = $this->Menu_model->get_all();
		//Load View Into Template
        $this->template->load('default','admin','menus/index',$data);
	}

	//Directs the checkbox actions on "menus" view
    public function router(){ 
         if($this->input->post('add')){
             redirect('admin/menus/add');
             
         } elseif($this->input->post('edit')){
             $menu_array = $this->input->post('menu_id');
             $menu_id = $menu_array[0];
              redirect("admin/menus/edit/$menu_id");
            
         } elseif($this->input->post('delete')){
             $menu_array = $this->input->post('menu_id');
             $this->delete($menu_array);
             
         } elseif($this->input->post('publish')){
             $menu_array = $this->input->post('menu_id');
             $this->publish($menu_array);
             
         } elseif($this->input->post('unpublish')){
             $menu_array = $this->input->post('menu_id');
             $this->unpublish($menu_array);

         } elseif($this->input->post('make_global')){
             $menu_array = $this->input->post('menu_id');
             $this->make_global($menu_array);
             
         } elseif($this->input->post('remove_global')){
             $menu_array = $this->input->post('menu_id');
             $this->remove_global($menu_array);

         } else {
             redirect('admin/menus');
         }
     }

	public function add($item_array = null){
		 //Validation Rules
        $this->form_validation->set_rules('menu_title','Menu Title','trim|required|min_length[4]|xss_clean');
        $this->form_validation->set_rules('show_title','Show Title','trim|required|xss_clean');  
        $this->form_validation->set_rules('class_suffix','Class Suffix','trim|xss_clean');  
        $this->form_validation->set_rules('is_global','Global','required');
        $this->form_validation->set_rules('is_published','Publish','required');

    	if($this->form_validation->run() == FALSE){ 
            //Get Menus
            $data['menus'] = $this->Menu_model->get_all();
            //Get Module Positions
            $data['positions'] = $this->Module_model->get_positions();
            //Get Groups
            $data['user_groups'] = $this->User_Group_model->get_all();

       		//Load View Into Template
        	$this->template->load('default','admin','menus/add', $data);
       	} else {
            //Create Page Data Array
            $data = array(
                'title'             => $this->input->post('menu_title'),
                'show_title'        => $this->input->post('show_title'),
                'access'            => $this->input->post('access'),
                'module_position'   => $this->input->post('module_position'),
                'order'     	    => $this->input->post('order'),
                'class_suffix'      => $this->input->post('class_suffix'),
                'is_global'   	    => $this->input->post('is_global'),             
                'is_published'      => $this->input->post('is_published')
            );   

            //Menu Insert
            $this->Menu_model->insert($data);

            //Activity Array
            $data = array(
                'resource_id'   =>  $this->db->insert_id(),
                'resource'      => 'menu',
                'action'        => 'added',
                'message'       => 'A new menu was created',
                'icon'          => 'fa-list'
            ); 

            //Add Activity  
            $this->Activity_model->insert($data);

            //Create Message
            $this->session->set_flashdata('menu_added', 'Menu has been added');
            
            //Redirect to pages
            redirect('admin/menus');
       	}    

	}

    public function edit($menu_id){
         //Validation Rules
        $this->form_validation->set_rules('menu_title','Menu Title','trim|required|min_length[4]|xss_clean');
        $this->form_validation->set_rules('show_title','Show Title','trim|required|xss_clean');  
        $this->form_validation->set_rules('class_suffix','Class Suffix','trim|xss_clean');  
        $this->form_validation->set_rules('is_global','Global','required');
        $this->form_validation->set_rules('is_published','Publish','required');

        if($this->form_validation->run() == FALSE){ 
            //Get Menus
            $data['this_menu'] = $this->Menu_model->get($menu_id);
            //Get Module Positions
            $data['positions'] = $this->Module_model->get_positions();
            //Get Groups
            $data['user_groups'] = $this->User_Group_model->get_all();
            //Get Selected Position
            $data['selected_position'] = $this->Menu_model->get_selected_position($menu_id);
            //Get Selected Group
            $data['selected_user_group'] = $this->Menu_model->get_selected_access($menu_id);

            //Load View Into Template
            $this->template->load('default','admin','menus/edit', $data);
        } else {
            //Create Page Data Array
            $data = array(
                'title'             => $this->input->post('menu_title'),
                'show_title'        => $this->input->post('show_title'),
                'access'            => $this->input->post('access'),
                'module_position'   => $this->input->post('module_position'),
                'order'             => $this->input->post('order'),
                'class_suffix'      => $this->input->post('class_suffix'),
                'is_global'         => $this->input->post('is_global'),             
                'is_published'      => $this->input->post('is_published')
            );   

            //Page Table Update
            $this->Menu_model->update_by(array('id'=>$menu_id), $data);

            //Activity Array
            $data = array(
                'resource_id'   =>  $this->db->insert_id(),
                'resource'      => 'menu',
                'action'        => 'updated',
                'message'       => 'Updated Menu',
                'icon'          => 'fa-list'
            ); 

            //Add Activity  
            $this->Activity_model->insert($data);

            //Create Message
            $this->session->set_flashdata('menu_updated', 'Menu has been Updated');
            
            //Redirect to pages
            redirect('admin/menus');
        }    

    }

    public function delete($menu_array){      
            if(!isset($menu_array) || $menu_array == ''){
                redirect('admin/menus');
            }
            //Delete menus in array
            $this->Menu_model->delete_many($menu_array);
         
            //Create Message
            $this->session->set_flashdata('menu_deleted', 'Menu(s) have been deleted');
            
            //Redirect to menus
            redirect('admin/menus');
     }

     public function publish($menu_array){
          if(!isset($menu_array) || $menu_array == ''){
                redirect('admin/menus');
            }
            //Publish menus in array
            $this->Menu_model->publish_menus($menu_array);
         
            //Create Message
            $this->session->set_flashdata('menu_published', 'Menu(s) have been published');
            
            //Redirect to menus
            redirect('admin/menus');
     }
     
     public function unpublish($menu_array){
           if(!isset($menu_array) || $menu_array == ''){
                redirect('admin/menus');
            }
            //Unpublish menus in array
            $this->Menu_model->unpublish_menus($menu_array);
         
            //Create Message
            $this->session->set_flashdata('menu_unpublished', 'Menu(s) have been unpublished');
            
            //Redirect to modules
            redirect('admin/menus');
    }

    public function make_global($menu_array){
          if(!isset($menu_array) || $menu_array == ''){
                redirect('admin/menus');
            }
            //Global menus in array
            $this->Menu_model->make_global($menu_array);
         
            //Create Message
            $this->session->set_flashdata('menu_global', 'Menu(s) are global');
            
            //Redirect to menus
            redirect('admin/menus');
     }
     
     public function remove_global($menu_array){
           if(!isset($menu_array) || $menu_array == ''){
                redirect('admin/menus');
            }
            //Remove global menus in array
            $this->Menu_model->remove_global($menu_array);
         
            //Create Message
            $this->session->set_flashdata('menu_remove_global', 'Menu(s) are not global');
            
            //Redirect to menus
            redirect('admin/menus');
    }

    //Directs the checkbox actions on "menu items" view
    public function items_router(){ 
         if($this->input->post('add')){
             redirect('admin/menus/add_item');
             
         } elseif($this->input->post('edit')){
             $menu_item_array = $this->input->post('menu_item_id');
             $menu_item_id = $menu_item_array[0];
              redirect("admin/menus/edit_item/$menu_item_id");
            
         } elseif($this->input->post('delete')){
             $menu_item_array = $this->input->post('menu_item_id');
             $this->delete_items($menu_item_array);
             
         } elseif($this->input->post('publish')){
             $menu_item_array = $this->input->post('menu_item_id');
             $this->publish_items($menu_item_array);
             
         } elseif($this->input->post('unpublish')){
             $menu_item_array = $this->input->post('menu_item_id');
             $this->unpublish_items($menu_item_array);
        } else {
             redirect('admin/mens/items');
         }
     }

     public function items(){
        //Get Menus
        $data['menu_items'] = $this->Menu_model->get_all_items();
        //Load View Into Template
        $this->template->load('default','admin','menus/items',$data);
    }

    //Add Menu Item
    public function add_item(){
        //Validation Rules
        $this->form_validation->set_rules('item_title','Menu Item Title','trim|required|min_length[2]|xss_clean');
        $this->form_validation->set_rules('item_type','Item Type','trim|required|xss_clean');
        $this->form_validation->set_rules('is_published','Publish','required');

        if($this->form_validation->run() == FALSE){ 
            //Get Menus
            $data['menus'] = $this->Menu_model->get_all();
            //Get Items
            $data['items'] = $this->Menu_model->get_all_items();
            //Get Pages
            $data['pages'] = $this->Page_model->get_all();
            //Get Forms
            $data['forms'] = $this->Form_model->get_all();
            //Get Access Groups
            $data['user_groups'] = $this->User_Group_model->get_all();
            //Load View Into Template
            $this->template->load('default','admin','menus/add_item',$data);
        } else {
            //Generate Alias
            if(!$this->input->post('item_alias')){
                $item_alias = urldecode(strtolower(str_replace(' ','-',$this->input->post('item_alias'))));
            } else {
                $item_alias = $this->input->post('item_alias');
            }

            if(!$this->input->post('parent_item') || $this->input->post('parent_item') == 0){
                $is_child = 0;
            } else {
                $is_child = 1;
            }

            //Assign page id
            $form_id = $this->input->post('page_item');

            //If url then page is 0
            if($this->input->post('url_item')){
                $page_id = 0;
            }

            //Assign form id
            $form_id = $this->input->post('form_item');

            //If url then form is 0
            if($this->input->post('url_item')){
                $form_id = 0;
            }

            //Create Page Data Array
           $data = array(
                'title'         => $this->input->post('item_title'),
                'menu_id'       => $this->input->post('menu'),
                'page_id'       => $page_id,
                'form_id'       => $form_id,
                'url'           => $this->input->post('url_item'),
                'order'         => $this->input->post('order'),
                'access'        => $this->input->post('access'),     
                'is_child'      => $is_child, 
                'parent_id'     => $this->input->post('parent_item'),    
                'alias'         => $item_alias,        
                'is_published'  => $this->input->post('is_published')
            );    

            //Menu Insert
            $this->Menu_model->insert_item($data);

            //Activity Array
            $data = array(
                'resource_id'   =>  $this->db->insert_id(),
                'resource'      => 'menu_item',
                'action'        => 'added',
                'message'       => 'Menu item added',
                'icon'          => 'fa-list'
            ); 

            //Add Activity  
            $this->Activity_model->insert($data);

            //Create Message
            $this->session->set_flashdata('menu_item_added', 'Menu item has been added');
            
            //Redirect to pages
            redirect('admin/menus/items');
        }
    }

    public function edit_item($id){
        //Validation Rules
        $this->form_validation->set_rules('item_title','Menu Item Title','trim|required|min_length[2]|xss_clean');
        $this->form_validation->set_rules('item_type','Item Type','trim|required|xss_clean');
        $this->form_validation->set_rules('is_published','Publish','required');

        if($this->form_validation->run() == FALSE){ 
            //Get Menus
            $data['menus'] = $this->Menu_model->get_all();
            //Get Items
            $data['items'] = $this->Menu_model->get_all_items();
            //Get Pages
            $data['pages'] = $this->Page_model->get_all();
            //Get Forms
            $data['forms'] = $this->Form_model->get_all();
            //Get Access Groups
            $data['user_groups'] = $this->User_Group_model->get_all();

            //Get Selected Item
            $data['this_item'] = $this->Menu_model->get_item_by_id($id);

            //Load View Into Template
            $this->template->load('default','admin','menus/edit_item',$data);
        } else {
            //Generate Alias
            if(!$this->input->post('item_alias')){
                $item_alias = urldecode(strtolower(str_replace(' ','-',$this->input->post('item_alias'))));
            } else {
                $item_alias = $this->input->post('item_alias');
            }

            if(!$this->input->post('parent_item') || $this->input->post('parent_item') == 0){
                $is_child = 0;
            } else {
                $is_child = 1;
            }

            //Assign page id
            $form_id = $this->input->post('page_item');

            //If url then page is 0
            if($this->input->post('url_item')){
                $page_id = 0;
            }

            //Assign form id
            $form_id = $this->input->post('form_item');

            //If url then form is 0
            if($this->input->post('url_item')){
                $form_id = 0;
            }

            //Create Page Data Array
           $data = array(
                'title'         => $this->input->post('item_title'),
                'menu_id'       => $this->input->post('menu'),
                'page_id'       => $page_id,
                'form_id'       => $form_id,
                'url'           => $this->input->post('url_item'),
                'order'         => $this->input->post('order'),
                'access'        => $this->input->post('access'),     
                'is_child'      => $is_child, 
                'parent_id'     => $this->input->post('parent_item'),    
                'alias'         => $item_alias,        
                'is_published'  => $this->input->post('is_published')
            );    

            //Menu Insert
            $this->Menu_model->update_item_by_id($id,$data);

            //Activity Array
            $data = array(
                'resource_id'   =>  $id,
                'resource'      => 'menu_item',
                'action'        => 'updated',
                'message'       => 'Menu item updated',
                'icon'          => 'fa-list'
            ); 

            //Add Activity  
            $this->Activity_model->insert($data);

            //Create Message
            $this->session->set_flashdata('menu_item_updated', 'Menu item has been updated');
            
            //Redirect to pages
            redirect('admin/menus/items');
        }
    }

    public function delete_items($item_array){
        //Delete Menu Item
        if(!isset($item_array) || $item_array == ''){
            redirect('admin/menus/items');
        }
        //Delete menus in array
        $this->Menu_model->delete_items($item_array);
         
        //Create Message
        $this->session->set_flashdata('menu_item_deleted', 'Menu item(s) have been deleted');
            
        //Redirect to menu items
        redirect('admin/menus/items');
    }

    public function publish_items($item_array){
        //Delete Menu Item
        if(!isset($item_array) || $item_array == ''){
            redirect('admin/menus/items');
        }
        //Publish menus in array
        $this->Menu_model->publish_items($item_array);
         
        //Create Message
        $this->session->set_flashdata('menu_item_published', 'Menu item(s) have been published');
            
        //Redirect to menu items
        redirect('admin/menus/items');
    }

    public function unpublish_items($item_array){
        //Delete Menu Item
        if(!isset($item_array) || $item_array == ''){
            redirect('admin/menus/items');
        }
        //Unpublish menus in array
        $this->Menu_model->unpublish_items($item_array);
         
        //Create Message
        $this->session->set_flashdata('menu_item_unpublished', 'Menu item(s) have been unpublished');
            
        //Redirect to menu items
        redirect('admin/menus/items');
    }

    public function change_order(){
        $position = $this->input->post('position');
        $item_id = $this->input->post('item_id');
        $this->Menu_model->update_order($item_id,$position);
    }

}