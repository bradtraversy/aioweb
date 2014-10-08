<?php
class Categories extends Admin_Controller{
    private $category_limit = 10;

	public function __construct(){
		parent::__construct();
		
		//Validate User
        $this->access->validate_user();
	}

	public function index(){
        //Configure pagination
        $config['base_url'] = base_url().'admin/categories/index';
        $config['total_rows'] = $this->db->count_all('blog_categories');
        $config['per_page'] = $this->category_limit; 
        $config['uri_segment'] = 4;

        //Init pagination
        $this->pagination->initialize($config);
	
        $data['categories'] = $this->Category_model->limit( $config['per_page'],$this->uri->segment(4))->get_categories();

		//Load View Into Template
        $this->template->load('default','admin','categories/index', $data);
	}

    //Directs the checkbox actions on "Categories" view
     public function router(){ 
         if($this->input->post('add')){
             redirect('admin/categories/add');
             
         } elseif($this->input->post('edit')){
             $category_array = $this->input->post('category_id');
             $category_id = $category_array[0];
              redirect("admin/categories/edit/$category_id");
             
         } elseif($this->input->post('delete')){
             //Get post ids from checkboxes
             $category_array = $this->input->post('category_id');
             $this->delete($category_array);
             
         } elseif($this->input->post('publish')){
             //Get post ids from checkboxes
             $category_array = $this->input->post('category_id');
             $this->publish($category_array);
             
         } elseif($this->input->post('unpublish')){
             //Get post ids from checkboxes
             $category_array = $this->input->post('category_id');
             $this->unpublish($category_array);

         } else {
             redirect('admin/categories');
         }
     }

     public function add(){
         //Validation Rules
        $this->form_validation->set_rules('category_title','Category Title','trim|required|min_length[3]|xss_clean');
        $this->form_validation->set_rules('category_description','Category Description','trim|xss_clean');   
        $this->form_validation->set_rules('category_slug','Category Slug','trim|xss_clean');
        $this->form_validation->set_rules('is_published','Publish','required');

       
        if($this->form_validation->run() == FALSE){ 
            //Load View Into Template
            $this->template->load('default','admin','categories/add');
        } else {
            //Generate Slug
            if(!$this->input->post('category_slug')){
                $category_slug = urldecode(strtolower(str_replace(' ','-',$this->input->post('category_title'))));
            } else {
                $category_slug = $this->input->post('category_slug');
            }

            //Create Category Data Array
            $data = array(
                'title'         => $this->input->post('category_title'),
                'slug'          => $category_slug,
                'description'   => $this->input->post('category_description'),
                'is_published'  => $this->input->post('is_published')
            );   

            //Category Table Insert
            $this->Category_model->insert_category($data);

            //Activity Array
            $data = array(
                'resource_id'   =>  $this->db->insert_id(),
                'resource'      => 'category',
                'action'        => 'added',
                'message'       => 'A new category was created',
                'icon'          => 'fa-folder'
            ); 

            //Add Activity  
            $this->Activity_model->insert($data);

            //Create Message
            $this->session->set_flashdata('category_added', 'Category has been added');
            
            //Redirect to pages
            redirect('admin/categories');
        }
     }

      public function edit($category_id){
         //Validation Rules
        $this->form_validation->set_rules('category_title','Category Title','trim|required|min_length[3]|xss_clean');
        $this->form_validation->set_rules('category_description','Category Description','trim|xss_clean');   
        $this->form_validation->set_rules('category_slug','Category Slug','trim|xss_clean');
        $this->form_validation->set_rules('is_published','Publish','required');

        if($this->form_validation->run() == FALSE){ 
            //Get Category
            $data['this_category'] = $this->Category_model->get_category($category_id);
            //Load View Into Template
            $this->template->load('default','admin','categories/edit',$data);
        } else {
            //Generate Slug
            if(!$this->input->post('category_slug')){
                $category_slug = urldecode(strtolower(str_replace(' ','-',$this->input->post('category_title'))));
            } else {
                $category_slug = $this->input->post('category_slug');
            }

            //Create Category Data Array
            $data = array(
                'title'         => $this->input->post('category_title'),
                'slug'          => $category_slug,
                'description'   => $this->input->post('category_description'),
                'is_published'  => $this->input->post('is_published')
            );   

            //Category Table Insert
            $this->Category_model->update_category($category_id,$data);

            //Activity Array
            $data = array(
                'resource_id'   =>  $this->db->insert_id(),
                'resource'      => 'category',
                'action'        => 'updated',
                'message'       => 'A category was updated',
                'icon'          => 'fa-folder'
            ); 

            //Add Activity  
            $this->Activity_model->insert($data);

            //Create Message
            $this->session->set_flashdata('category_updated', 'Category has been updated');
            
            //Redirect to pages
            redirect('admin/categories');
        }
     }

     public function delete($category_array){      
            if(!isset($category_array) || $category_array == ''){
                redirect('admin/categories');
            }
            //Delete categories in array
            $this->Category_model->delete_category($category_array);
         
            //Create Message
            $this->session->set_flashdata('category_deleted', 'Category has been deleted');
            
            //Redirect to categories
            redirect('admin/categories');
     }

     public function publish($category_array){
          if(!isset($category_array) || $category_array == ''){
                redirect('admin/categories');
            }
            //Publish categories in array
            $this->Category_model->publish_categories($category_array);
         
            //Create Message
            $this->session->set_flashdata('category_published', 'Category has been published');
            
            //Redirect to categories
            redirect('admin/categories');
     }
     
     
     
      public function unpublish($category_array){
           if(!isset($category_array) || $category_array == ''){
                redirect('admin/categories');
            }
            //Unpublish category in array
            $this->Category_model->unpublish_categories($category_array);
         
            //Create Message
            $this->session->set_flashdata('category_unpublished', 'Category has been unpublished');
            
            //Redirect to categories
            redirect('admin/categories');
     }
}