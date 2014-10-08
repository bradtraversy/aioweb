<?php
class Pages extends Admin_Controller{
    private $page_limit = 10;

	public function __construct(){
		parent::__construct();

        //Validate User
        $this->access->validate_user();
	}

	/*
	 * Displays all pages
	 */
	public function index(){
        //Configure pagination
        $config['base_url'] = base_url().'admin/pages/index';
        $config['total_rows'] = $this->db->count_all('pages');
        $config['per_page'] = $this->page_limit; 
        $config['uri_segment'] = 4;

        //Init pagination
        $this->pagination->initialize($config);

        $data['pages'] = $this->Page_model->limit( $config['per_page'],$this->uri->segment(4))->get_all();

        //Load View Into Template
        $this->template->load('default','admin','pages/index', $data);
	}

	/*
	 *Directs the checkbox actions on "Pages" view
	 */
    public function router(){ 
         if($this->input->post('add')){
             redirect('admin/pages/add');
             
         } elseif($this->input->post('edit')){
             $page_array = $this->input->post('page_id');
             $page_id = $page_array[0];
              redirect("admin/pages/edit/$page_id");
             
         } elseif($this->input->post('delete')){
             //Get page ids from checkboxes
             $page_array = $this->input->post('page_id');
             $this->delete($page_array);
             
         } elseif($this->input->post('publish')){
             //Get page ids from checkboxes
             $page_array = $this->input->post('page_id');
             $this->publish($page_array);
             
         } elseif($this->input->post('unpublish')){
             //Get page ids from checkboxes
             $page_array = $this->input->post('page_id');
             $this->unpublish($page_array);
             
         } elseif($this->input->post('feature')){
             //Get page ids from checkboxes
             $page_array = $this->input->post('page_id');
             $this->feature($page_array);
             
         } elseif($this->input->post('unfeature')){
             //Get page ids from checkboxes
             $page_array = $this->input->post('page_id');
             $this->unfeature($page_array);

         } else {
             redirect('admin/pages');
         }
     }

     /*
	 * Add a new page
	 */
	public function add(){
		//Validation Rules
        $this->form_validation->set_rules('page_title','Page Title','trim|required|min_length[4]|xss_clean');
        $this->form_validation->set_rules('page_body','Page Body','trim|required|xss_clean');   
        $this->form_validation->set_rules('page_keywords','Keywords','trim|xss_clean');
        $this->form_validation->set_rules('page_description','Description','trim|xss_clean');
        $this->form_validation->set_rules('page_modules','Page Modules','xss_clean');
        $this->form_validation->set_rules('is_published','Publish','required');
        $this->form_validation->set_rules('is_featured','Featured','required');
        $this->form_validation->set_rules('order','Order','integer');
       
       	if($this->form_validation->run() == FALSE){ 
       		//Get Module Options  
            $data['mod_selection'] = $this->Module_model->get_all();

            //Get User Group options  
            $data['group_selection'] = $this->User_model->get_user_groups();

            //Get menu options  
            $data['menu_selection'] = $this->Menu_model->get_all();

       		//Load View Into Template
        	$this->template->load('default','admin','pages/add', $data);
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
            if(!$this->input->post('page_slug')){
                $page_slug = urldecode(strtolower(str_replace(' ','-',$this->input->post('page_title'))));
            } else {
                $page_slug = $this->input->post('page_slug');
            }

            //Create Page Data Array
            $data = array(
                'title'         => $this->input->post('page_title'),
                'slug'          => $page_slug,
                'body'          => $this->input->post('page_body'),
                'seo_title'     => $this->input->post('seo_page_title'),
                'keywords'      => $this->input->post('keywords'),
                'description'   => $this->input->post('page_description'),
                'page_modules'  => $mod_string,
                'access'   		=> $this->input->post('access'),
                'is_published'  => $this->input->post('is_published'),
                'is_featured'   => $this->input->post('is_featured')
            );   

            //Page Table Insert
            $this->Page_model->insert($data);

            //Activity Array
            $data = array(
                'resource_id'   =>  $this->db->insert_id(),
                'resource'      => 'page',
                'action'        => 'added',
                'message'       => 'A new page was created',
                'icon'          => 'fa-pencil'
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
                        'title'            => $this->input->post('menu_item_title'),
                        'page_id'           => $next_page_id,
                        'order'             => $this->input->post('order'),
                        'access'            => $this->input->post('access'),
                        'parent_id'         => $this->input->post('parent_item'),
                        'is_child'          => $is_child,
                        'alias'             => strtolower(str_replace(' ','-',$this->input->post('page_title'))),
                        'is_published'      => 1
                );
                    
                //Add data to menu_items table
                $this->Menu_model->add_item($data);
            }

            //Create Message
            $this->session->set_flashdata('page_added', 'Your page has been added');
            
            //Redirect to pages
            redirect('admin/pages');
       	}
	}

    public function edit($page_id){
        //Validation Rules
        $this->form_validation->set_rules('page_title','Page Title','trim|required|min_length[4]|xss_clean');
        $this->form_validation->set_rules('page_body','Page Body','trim|required|xss_clean');   
        $this->form_validation->set_rules('page_keywords','Keywords','trim|xss_clean');
        $this->form_validation->set_rules('page_description','Description','trim|xss_clean');
        $this->form_validation->set_rules('page_modules','Page Modules','xss_clean');
        $this->form_validation->set_rules('is_published','Publish','required');
        $this->form_validation->set_rules('is_featured','Featured','required');
        $this->form_validation->set_rules('order','Order','integer');

        if($this->form_validation->run() == FALSE){ 
            //Get Module Options  
            $data['mod_selection'] = $this->Module_model->get_all();
            //Get User Group options  
            $data['group_selection'] = $this->User_model->get_user_groups();
            //Get menu options  
            $data['menu_selection'] = $this->Menu_model->get_all();
            //Get all menu items
            $data['all_items'] = $this->Menu_model->get_all_items();
            //Get the page to edit 
            $data['this_page'] = $this->Page_model->get($page_id);
            //Check for the menu that this current page is attached to 
            $data['selected_menu'] = $this->Menu_model->get_selected_menu('page',$page_id);
            //Check seleted parent ids
            $data['selected_parent'] = $this->Menu_model->get_selected_parent('page',$page_id);
            //Get the page to edit 
            $data['this_item'] = $this->Menu_model->get_item('page',$page_id);
            //Get selected modules
            $data['selected_modules'] = $this->Page_model->get_page_modules($page_id);
            //Get selected groups
            $data['selected_groups'] = $this->Page_model->get_page_access($page_id);

            //Load View Into Template
            $this->template->load('default','admin','pages/edit', $data);
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
            if(!$this->input->post('page_slug')){
                $page_slug = urldecode(strtolower(str_replace(' ','-',$this->input->post('page_title'))));
            } else {
                $page_slug = $this->input->post('page_slug');
            }
            
            //Create Page Data Array
            $data = array(
                'title'         => $this->input->post('page_title'),
                'slug'          => $page_slug,
                'body'          => $this->input->post('page_body'),
                'seo_title'     => $this->input->post('seo_page_title'),
                'keywords'      => $this->input->post('keywords'),
                'description'   => $this->input->post('page_description'),
                'page_modules'  => $mod_string,
                'access'        => $this->input->post('access'),
                'is_published'  => $this->input->post('is_published'),
                'is_featured'   => $this->input->post('is_featured')
            );   

            //Page Table Update
            $this->Page_model->update_by(array('id'=>$page_id), $data);

            //Activity Array
            $data = array(
                'resource_id'   =>  $page_id,
                'resource'      => 'page',
                'action'        => 'updated',
                'message'       => 'A page was updated',
                'icon'          => 'fa-pencil'
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
                        'title'            => $this->input->post('menu_item_title'),
                        'page_id'           => $page_id,
                        'order'             => $this->input->post('order'),
                        'access'            => $this->input->post('access'),
                        'parent_id'         => $this->input->post('parent_item'),
                        'is_child'          => $is_child,
                        'alias'             => strtolower(str_replace(' ','-',$this->input->post('page_title'))),
                        'is_published'      => 1
                );
                    
                //Update menu_items table
                $this->Menu_model->update_item('page',$data);
            } else {
                $this->Menu_model->delete_item('page',$page_id);
            }

             //Create Message
            $this->session->set_flashdata('page_updated', 'Page has been updated');
            
            //Redirect to pages
            redirect('admin/pages');
        }
    }

    public function delete($page_array){      
            if(!isset($page_array) || $page_array == ''){
                redirect('admin/pages');
            }
            //Delete pages in array
            $this->Page_model->delete_many($page_array);
            //Delete menu items in array
            //$this->Page_model->delete_menu_items($page_array);
         
            //Create Message
            $this->session->set_flashdata('page_deleted', 'Your page(s) have been deleted');
            
            //Redirect to pages
            redirect('admin/pages');
     }

     public function publish($page_array){
          if(!isset($page_array) || $page_array == ''){
                redirect('admin/pages');
            }
            //Publish pages in array
            $this->Page_model->publish_pages($page_array);
            //Publish Menu Items in array
            $this->Page_model->publish_menu_items($page_array);
         
            //Create Message
            $this->session->set_flashdata('page_published', 'Your page(s) have been published');
            
            //Redirect to pages
            redirect('admin/pages');
     }
     
     
     
      public function unpublish($page_array){
           if(!isset($page_array) || $page_array == ''){
                redirect('admin/pages');
            }
         //Unpublish pages in array
          $this->Page_model->unpublish_pages($page_array);
          //Unpublish menu items in array
          $this->Page_model->unpublish_menu_items($page_array);
         
            //Create Message
            $this->session->set_flashdata('page_unpublished', 'Your page(s) have been unpublished');
            
            //Redirect to pages
            redirect('admin/pages');
     }
     
     
     
      public function feature($page_array){
           if(!isset($page_array) || $page_array == ''){
                redirect('admin/pages');
            }
         
         $this->Page_model->feature_pages($page_array);
         
            //Create Message
            $this->session->set_flashdata('page_featured', 'Your page(s) have been featured');
            
            //Redirect to pages
            redirect('admin/pages');
     }
     
     
     
      public function unfeature($page_array){
           if(!isset($page_array) || $page_array == ''){
                redirect('admin/pages');
            }
         
          $this->Page_model->unfeature_pages($page_array);
         
            //Create Message
            $this->session->set_flashdata('page_unfeatured', 'Your page(s) have been unfeatured');
            
            //Redirect to pages
            redirect('admin/pages');
     }
	
}