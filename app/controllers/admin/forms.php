<?php
class Forms extends Admin_Controller{
  private $form_limit = 10;

	public function __construct(){
		parent::__construct();

		//Validate User
        $this->access->validate_user();
	}

	public function index(){
		//Configure pagination
    $config['base_url'] = base_url().'admin/forms/index';
    $config['total_rows'] = $this->db->count_all('forms');
    $config['per_page'] = $this->form_limit; 
    $config['uri_segment'] = 4;

    //Init pagination
    $this->pagination->initialize($config);
  
    $data['forms'] = $this->Form_model->limit( $config['per_page'],$this->uri->segment(4))->get_all();

		//Load View Into Template
    $this->template->load('default','admin','forms/index', $data);
	}

	public function add(){
		//Validation Rules
        $this->form_validation->set_rules('form_title','Form Title','trim|required|min_length[4]|xss_clean');
        $this->form_validation->set_rules('to_email','To Email','trim|required|xss_clean|valid_email');  
        $this->form_validation->set_rules('subject','Subject','trim|required|xss_clean');      
        $this->form_validation->set_rules('menu_item_title','Menu Item Title','trim|xss_clean');
        $this->form_validation->set_rules('page_menu','Page menu','trim|xss_clean');
        $this->form_validation->set_rules('seo_page_title','SEO Page Title','trim|xss_clean');
        $this->form_validation->set_rules('parent_item','Parent Item','xss_clean');
        $this->form_validation->set_rules('order','Parent Item','xss_clean|numeric');
        $this->form_validation->set_rules('is_published','Publish','required');

    	if($this->form_validation->run() == FALSE){ 
            //Get Categories
            $data['forms'] = $this->Form_model->get_all();

            //Get Module Options  
            $data['mod_selection'] = $this->Module_model->get_all();

             //Get menu options  
            $data['menu_selection'] = $this->Menu_model->get_all();

       		//Load View Into Template
        	$this->template->load('default','admin','forms/add', $data);
       	} else {
       		//Get Page Modules if Any
            if($this->input->post('page_modules') != ""){
                $modules[] = $this->input->post('page_modules');
                foreach ($modules as $mods) {
                    foreach($mods as $mod){
                    $mod_string[] = $mod;
                    }
                }
                //Make Array CSV string
                $mod_string = implode(",",$mod_string);
              } else {
                  $mod_string = 0;
        	}

            //Generate Slug
            if(!$this->input->post('post_slug')){
                $post_slug = urldecode(strtolower(str_replace(' ','-',$this->input->post('post_title'))));
            } else {
                $post_slug = $this->input->post('post_slug');
            }

            //Create Page Data Array
            $data = array(
                'title'         => $this->input->post('form_title'),
                'to_email'      => $this->input->post('to_email'),
                'subject'      	=> $this->input->post('subject'),
                'type'   		=> 'custom',
                'page_modules'  => $mod_string,
                'is_published'  => $this->input->post('is_published')
            );   

            //Form Table Insert
            $this->Form_model->insert($data);

            //Activity Array
            $data = array(
                'resource_id'   =>  $this->db->insert_id(),
                'resource'      => 'form',
                'action'        => 'added',
                'message'       => 'A new form was created',
                'icon'          => 'fa-envelope'
            ); 

            //Add Activity  
            $this->Activity_model->insert($data);

            if($this->input->post('page_menu') != "" && $this->input->post('page_menu') != 0 && $this->input->post('page_menu') != 'none'){
                //Get the last insert id
                $last_page_id = $this->Page_model->get_insert_id();
                $next_page_id = $last_page_id;          
                   
                //Decide If Child
                if($this->input->post('parent_item') != 0){
                    $is_child = 1;
                } else {
                    $is_child = 0;
                }

                 //Gather data for menu_items table
                $data = array(
                        'menu_id'           => $this->input->post('page_menu'),
                        'anchor'            => $this->input->post('menu_item_title'),
                        'form_id'           => $next_page_id,
                        'order'             => $this->input->post('order'),
                        'access'            => 0,
                        'parent_id'         => $this->input->post('parent_item'),
                        'is_child'          => $is_child,
                        'alias'             => strtolower(str_replace(' ','-',$this->input->post('form_title'))),
                        'is_published'      => 1
                );
                    
                //Add data to menu_items table
                $this->Menu_model->add_item($data);

                //Activity Array
                $data = array(
                  'resource_id'   =>  $this->db->insert_id(),
                  'resource'      => 'menu_item',
                  'action'        => 'added',
                  'message'       => 'Menu Item Created',
                  'icon'          => 'fa-list'
                ); 

                //Add Activity  
                $this->Activity_model->insert($data);
            }

            //Create Message
            $this->session->set_flashdata('form_added', 'Form has been saved');
            
            //Redirect to pages
            redirect('admin/forms');
       	}    

	}

	public function edit($form_id){
		//Validation Rules
        $this->form_validation->set_rules('form_title','Form Title','trim|required|min_length[4]|xss_clean');
        $this->form_validation->set_rules('to_email','To Email','trim|required|xss_clean|valid_email');  
        $this->form_validation->set_rules('subject','Subject','trim|required|xss_clean');      
        $this->form_validation->set_rules('menu_item_title','Menu Item Title','trim|xss_clean');
        $this->form_validation->set_rules('page_menu','Page menu','trim|xss_clean');
        $this->form_validation->set_rules('seo_page_title','SEO Page Title','trim|xss_clean');
        $this->form_validation->set_rules('parent_item','Parent Item','xss_clean');
        $this->form_validation->set_rules('order','Parent Item','xss_clean|numeric');
        $this->form_validation->set_rules('is_published','Publish','required');

    	if($this->form_validation->run() == FALSE){ 
            //Get Categories
            $data['forms'] = $this->Form_model->get_all();
            //Get Module Options  
            $data['mod_selection'] = $this->Module_model->get_all();
             //Get menu options  
            $data['menu_selection'] = $this->Menu_model->get_all();
             //Get the page to edit 
            $data['this_form'] = $this->Form_model->get($form_id);
             //Check for the menu that this current page is attached to 
            $data['selected_menu'] = $this->Menu_model->get_selected_menu('form',$form_id);
            //Check seleted parent ids
            $data['selected_parent'] = $this->Menu_model->get_selected_parent('form',$form_id);
            //Get the item to edit 
            $data['this_item'] = $this->Menu_model->get_item('form',$form_id);
            //Get selected modules
            $data['selected_modules'] = $this->Form_model->get_page_modules($form_id);

       		//Load View Into Template
        	$this->template->load('default','admin','forms/edit', $data);
       	} else {
       		//Get Page Modules if Any
            if($this->input->post('page_modules') != ""){
                $modules[] = $this->input->post('page_modules');
                foreach ($modules as $mods) {
                    foreach($mods as $mod){
                    $mod_string[] = $mod;
                    }
                }
                //Make Array CSV string
                $mod_string = implode(",",$mod_string);
              } else {
                  $mod_string = 0;
        	}

            //Generate Slug
            if(!$this->input->post('post_slug')){
                $post_slug = urldecode(strtolower(str_replace(' ','-',$this->input->post('post_title'))));
            } else {
                $post_slug = $this->input->post('post_slug');
            }

            //Create Page Data Array
            $data = array(
                'title'         => $this->input->post('form_title'),
                'to_email'      => $this->input->post('to_email'),
                'subject'      	=> $this->input->post('subject'),
                'type'   		=> 'custom',
                'page_modules'  => $mod_string,
                'is_published'  => $this->input->post('is_published')
            );   

            //Form Table Update
            $this->Form_model->update_by(array('id'=>$form_id), $data);

            //Activity Array
            $data = array(
                'resource_id'   =>  $form_id,
                'resource'      => 'form',
                'action'        => 'updated',
                'message'       => 'A form was updated',
                'icon'          => 'fa-envelope'
            ); 

            //Add Activity  
            $this->Activity_model->insert($data);

            if($this->input->post('page_menu') != "" && $this->input->post('page_menu') != 0 && $this->input->post('page_menu') != 'none'){
                //Decide If Child
                if($this->input->post('parent_item') != 0){
                    $is_child = 1;
                } else {
                    $is_child = 0;
                }

                 //Gather data for menu_items table
                $data = array(
                        'menu_id'           => $this->input->post('page_menu'),
                        'anchor'            => $this->input->post('menu_item_title'),
                        'form_id'           => $form_id,
                        'order'             => $this->input->post('order'),
                        'access'            => 0,
                        'parent_id'         => $this->input->post('parent_item'),
                        'is_child'          => $is_child,
                        'alias'             => strtolower(str_replace(' ','-',$this->input->post('form_title'))),
                        'is_published'      => 1
                );
                    
                //Update menu_items table
                $this->Menu_model->update_item('form',$data);

                //Activity Array
                $data = array(
                  'resource_id'   =>  $this->db->insert_id(),
                  'resource'      => 'menu_item',
                  'action'        => 'updated',
                  'message'       => 'Menu item updated',
                  'icon'          => 'fa-list'
                ); 

            //Add Activity  
            $this->Activity_model->insert($data);

            } else {
            	$this->Menu_model->delete_item('form',$form_id);
            }

            //Create Message
            $this->session->set_flashdata('form_added', 'Form has been saved');
            
            //Redirect to pages
            redirect('admin/forms');
       	}    

	}

	//Directs the checkbox actions on "Forms" view
    public function router(){ 
         if($this->input->post('add')){
             redirect('admin/forms/add');
             
         } elseif($this->input->post('edit')){
             $form_array = $this->input->post('form_id');
             $form_id = $form_array[0];
              redirect("admin/forms/edit/$form_id");
            
         } elseif($this->input->post('delete')){
             $form_array = $this->input->post('form_id');
             $this->delete($form_array);
             
         } elseif($this->input->post('publish')){
             $form_array = $this->input->post('form_id');
             $this->publish($form_array);
             
         } elseif($this->input->post('unpublish')){
             $form_array = $this->input->post('form_id');
             $this->unpublish($form_array);

         } else {
             redirect('admin/forms');
         }
     }

     public function delete($form_array){      
            if(!isset($form_array) || $form_array == ''){
                redirect('admin/forms');
            }
            //Delete forms in array
            $this->Form_model->delete_many($form_array);
         
            //Create Message
            $this->session->set_flashdata('form_deleted', 'Form(s) have been deleted');
            
            //Redirect to forms
            redirect('admin/forms');
     }

     public function publish($form_array){
          if(!isset($form_array) || $form_array == ''){
                redirect('admin/forms');
            }
            //Publish forms in array
            $this->Form_model->publish_forms($form_array);
         
            //Create Message
            $this->session->set_flashdata('form_published', 'Form(s) have been published');
            
            //Redirect to forms
            redirect('admin/forms');
     }
     
     public function unpublish($form_array){
           if(!isset($form_array) || $form_array == ''){
                redirect('admin/forms');
            }
         	//Unpublish forms in array
          	$this->Form_model->unpublish_forms($form_array);
         
            //Create Message
            $this->session->set_flashdata('form_unpublished', 'Form(s) have been unpublished');
            
            //Redirect to forms
            redirect('admin/forms');
    }

      //Fields action
      public function fields($form_id){
        $data['fields'] = $this->Form_model->get_form_fields($form_id);
        $data['forms'] = $this->Form_model->get_all();
        $data['form'] = $this->Form_model->get($form_id);
         
        //Load View Into Template
        $this->template->load('default','admin','forms/fields', $data);
      }
     

    //Directs field actions
    public function fields_router($form_id){ 
         if($this->input->post('add')){
             redirect('admin/forms/add_field/'.$form_id);            
         } elseif($this->input->post('edit')){
             $field_array = $this->input->post('field_id');
             $field_id = $field_array[0];
              redirect("admin/forms/edit_field/$form_id/$field_id");
         } elseif($this->input->post('delete')){
             //Get field ids from checkboxes
             $field_array = $this->input->post('field_id');
             //Pass to delete function
             $this->delete_fields($form_id,$field_array); 
         } elseif($this->input->post('publish')){
             //Get field ids from checkboxes
             $field_array = $this->input->post('field_id');
             //Pass to publish function
             $this->publish_fields($form_id,$field_array);
         } elseif($this->input->post('unpublish')){
             //Get field ids from checkboxes
             $field_array = $this->input->post('field_id');
             //Pass to unpublish function
             $this->unpublish_fields($form_id,$field_array);
         } else {
             //Redirect to fields
              redirect('admin/forms/fields/'.$form_id);
         }
    }

    //Add form field
    public function add_field($form_id){
       $this->form_validation->set_rules('field_label','Field Label','trim|required|xss_clean');
          $this->form_validation->set_rules('field_name','Field Name','trim|required|xss_clean');
          $this->form_validation->set_rules('field_type','Field Type','required');
          $this->form_validation->set_rules('field_width','Field Width','xss_clean');
          $this->form_validation->set_rules('field_height','Field Height','xss_clean');
          $this->form_validation->set_rules('is_published','Published','required');
          $this->form_validation->set_rules('order','Order','required|integer');

          if($this->form_validation->run() == FALSE){
            //Get form info
            $data['this_form'] = $this->Form_model->get($form_id);
            //Get fields info
            $data['this_form_fields'] = $this->Form_model->get_form_fields($form_id);
            //Load View Into Template
            $this->template->load('default','admin','forms/add_field', $data);    
          } else {
              //Create validation array
              $validation_array = $this->input->post('validation');
              //Check if array is not empty
              if(!empty($validation_array)){
                  //Create validation string
                  $validation_string = implode(",", $validation_array);
              } else {
                  $validation_string = "";
              }

              $data = array(
                    'form_id' => $form_id,
                    'label' => $this->input->post('field_label'),    
                    'name' => strtolower($this->input->post('field_name')), 
                    'type' => $this->input->post('field_type'),
                    'options' => $this->input->post('field_options'),
                    'width' => $this->input->post('field_width'), 
                    'height' => $this->input->post('field_height'),
                    'order' => $this->input->post('order'),  
                    'is_published' => $this->input->post('is_published'),
                    'validation' => $validation_string
             );
              
              //Add the field to the specified form
              $this->Form_model->add_field($form_id,$data);  
             
              //Create Message
              $this->session->set_flashdata('field_added', 'Your field has been added');
            
              //Redirect to forms
              redirect('admin/forms/fields/'.$form_id);
          }
    }

    //Edit field
    public function edit_field($form_id,$field_id){
          $this->form_validation->set_rules('field_label','Field Label','trim|required|xss_clean');
          $this->form_validation->set_rules('field_name','Field Name','trim|required|xss_clean');
          $this->form_validation->set_rules('field_type','Field Type','required');
          $this->form_validation->set_rules('field_width','Field Width','xss_clean');
          $this->form_validation->set_rules('field_height','Field Height','xss_clean');
          $this->form_validation->set_rules('is_published','Published','required');
          $this->form_validation->set_rules('order','Order','required|integer');

          if($this->form_validation->run() == FALSE){
            //Get form info
            $data['this_form'] = $this->Form_model->get($form_id);
            //Get field info
            $data['this_field'] = $this->Form_model->get_form_field($form_id,$field_id);
            //Get fields info
            $data['this_form_fields'] = $this->Form_model->get_form_fields($form_id);
            //Get which validations are selected
            $validation_string = $this->Form_model->get_selected_validations($form_id,$field_id);
            $data['selected_validations'] = explode("|",$validation_string);
            //Load View Into Template
            $this->template->load('default','admin','forms/add_field', $data);    
          } else {
              //Create validation array
              $validation_array = $this->input->post('validation');
              //Check if array is not empty
              if(!empty($validation_array)){
                  //Create validation string
                  $validation_string = implode(",", $validation_array);
              } else {
                  $validation_string = "";
              }

              $data = array(
                    'form_id' => $form_id,
                    'label' => $this->input->post('field_label'),    
                    'name' => strtolower($this->input->post('field_name')), 
                    'type' => $this->input->post('field_type'),
                    'options' => $this->input->post('field_options'),
                    'width' => $this->input->post('field_width'), 
                    'height' => $this->input->post('field_height'),
                    'order' => $this->input->post('order'),  
                    'is_published' => $this->input->post('is_published'),
                    'validation' => $validation_string
             );
              
              //Edit field info for the specified form
              $this->Form_model->edit_field($form_id,$field_id,$data);  
             
              //Create Message
              $this->session->set_flashdata('field_edited', 'Your field has been saved');
            
              //Redirect to forms
              redirect('admin/forms/fields/'.$form_id);
          }
    }

    public function delete_fields($form_id,$field_array){
      if(!isset($field_array) || $field_array == ''){
          redirect('admin/forms/fields/'.$form_id);
      }
            
      $this->Form_model->delete_fields($form_id,$field_array);
         
      //Create Message
      $this->session->set_flashdata('field_deleted', 'Your field(s) have been deleted');
         
      //Redirect to fields view
      redirect('admin/forms/fields/'.$form_id);
     }
     
     
     public function publish_fields($form_id,$field_array){
          if(!isset($field_array) || $field_array == ''){
                redirect('admin/forms/fields/'.$form_id);
         }
         //Publish fields in array
         $this->Form_model->publish_fields($form_id,$field_array);
       
         //Create Message
         $this->session->set_flashdata('field_published', 'Your field(s) have been published');
            
         //Redirect to fields view
         redirect('admin/forms/fields/'.$form_id);
     }
     
     
     public function unpublish_fields($form_id,$field_array){
          if(!isset($field_array) || $field_array == ''){
                redirect('admin/forms/fields/'.$form_id);
         }
         //Publish fields in array
         $this->Form_model->unpublish_fields($form_id,$field_array);
       
         //Create Message
         $this->session->set_flashdata('field_unpublished', 'Your field(s) have been unpublished');
            
         //Redirect to fields view
         redirect('admin/forms/fields/'.$form_id);
     }

     public function change_order(){
        $position = $this->input->post('position');
        $item_id = $this->input->post('item_id');
        $this->Form_model->update_order($item_id,$position);
    }
	
}