<?php
class Posts extends Admin_Controller{
	private $post_limit = 10;

	public function __construct(){
		parent::__construct();
		
		//Validate User
        $this->access->validate_user();
	}

	public function index(){
        //Configure pagination
        $config['base_url'] = base_url().'admin/posts/index';
        $config['total_rows'] = $this->db->count_all('pages');
        $config['per_page'] = $this->post_limit; 
        $config['uri_segment'] = 4;

        //Init pagination
        $this->pagination->initialize($config);
	
        $data['posts'] = $this->Post_model->limit( $config['per_page'],$this->uri->segment(4))->get_posts();

		//Load View Into Template
        $this->template->load('default','admin','posts/index', $data);
	}

	 //Directs the checkbox actions on "Posts" view
     public function router(){ 
         if($this->input->post('add')){
             redirect('admin/posts/add');
             
         } elseif($this->input->post('edit')){
             $post_array = $this->input->post('post_id');
             $post_id = $post_array[0];
              redirect("admin/posts/edit/$post_id");
             
         } elseif($this->input->post('delete')){
             $post_array = $this->input->post('post_id');
             $this->delete($post_array); 

         } elseif($this->input->post('publish')){
             $post_array = $this->input->post('post_id');
             $this->publish($post_array);
             
         } elseif($this->input->post('unpublish')){
             $post_array = $this->input->post('post_id');
             $this->unpublish($post_array);

         } elseif($this->input->post('delete_comment')){
             $comment_array = $this->input->post('comment_id');
             $this->delete_comment($comment_array);
             
         } elseif($this->input->post('approve_comment')){
             $comment_array = $this->input->post('comment_id');
             $this->approve_comment($comment_array);
             
         } elseif($this->input->post('unapprove_comment')){
             $comment_array = $this->input->post('comment_id');
             $this->unapprove_comment($comment_array);

         } else {
             redirect('admin/posts');
         }
     }

	public function add(){
		 //Validation Rules
        $this->form_validation->set_rules('post_title','Post Title','trim|required|min_length[4]|xss_clean');
        $this->form_validation->set_rules('post_body','Post Body','trim|required|xss_clean');  
        $this->form_validation->set_rules('post_author','Post Author','trim|required|xss_clean');   
        $this->form_validation->set_rules('post_category','Post Category','trim|required|xss_clean');    
        $this->form_validation->set_rules('keywords','Keywords','trim|xss_clean');
        $this->form_validation->set_rules('post_description','Description','trim|xss_clean');
        $this->form_validation->set_rules('seo_page_title','SEO Page Title','trim|xss_clean');
        $this->form_validation->set_rules('page_modules','Page Modules','xss_clean');
        $this->form_validation->set_rules('is_published','Publish','required');

    	if($this->form_validation->run() == FALSE){ 
            //Get Categories
            $data['categories'] = $this->Post_model->get_published_categories();

            //Get Authors
            $data['authors'] = $this->Post_model->get_authors();

            //Get Module Options  
            $data['mod_selection'] = $this->Module_model->get_all();

       		//Load View Into Template
        	$this->template->load('default','admin','posts/add', $data);
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

            //Upload Image
            $config['upload_path'] = './assets/images/blog/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '2048';
            $config['max_width'] = '1024';
            $config['max_height'] = '768';

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload()){
                $errors = array('error' => $this->upload->display_errors());
                $main_image = "noimage.jpg";
                //$this->session->set_flashdata('image_errors', $errors);
                //redirect('admin/posts');
            } else {
                $data = array('upload_data' => $this->upload->data());
                $main_image = $_FILES['userfile']['name'];
            }


            //Create Page Data Array
            $data = array(
                'title'         => $this->input->post('post_title'),
                'slug'          => $post_slug,
                'body'          => $this->input->post('post_body'),
                'main_image'    => $main_image,
                'seo_title'     => $this->input->post('seo_page_title'),
                'keywords'      => $this->input->post('keywords'),
                'description'   => $this->input->post('post_description'),
                'page_modules'  => $mod_string,
                'tags'          => $this->input->post('keywords'),
                'is_published'  => $this->input->post('is_published'),
                'category_id'   => $this->input->post('post_category'),
                'author_id'     => $this->input->post('post_author')
            );   

            //Post Insert
            $this->Post_model->insert($data);

            //Activity Array
            $data = array(
                'resource_id'   =>  $this->db->insert_id(),
                'resource'      => 'post',
                'action'        => 'added',
                'message'       => 'A new post was created',
                'icon'          => 'fa-thumb-tack'
            ); 

            //Add Activity  
            $this->Activity_model->insert($data);

            //Create Message
            $this->session->set_flashdata('post_added', 'Your post has been saved');
            
            //Redirect to pages
            redirect('admin/posts');
       	}    

	}

	public function edit($post_id){
         //Validation Rules
        $this->form_validation->set_rules('post_title','Post Title','trim|required|min_length[4]|xss_clean');
        $this->form_validation->set_rules('post_body','Post Body','trim|required|xss_clean');  
        $this->form_validation->set_rules('post_author','Post Author','trim|required|xss_clean');   
        $this->form_validation->set_rules('post_category','Post Category','trim|required|xss_clean');    
        $this->form_validation->set_rules('keywords','Keywords','trim|xss_clean');
        $this->form_validation->set_rules('post_description','Description','trim|xss_clean');
        $this->form_validation->set_rules('seo_page_title','SEO Page Title','trim|xss_clean');
        $this->form_validation->set_rules('page_modules','Page Modules','xss_clean');
        $this->form_validation->set_rules('is_published','Publish','required');

        if($this->form_validation->run() == FALSE){ 
            //Get the post to edit 
            $data['this_post'] = $this->Post_model->get_post($post_id);
            //Get Categories
            $data['categories'] = $this->Post_model->get_published_categories();
            //Get Authors
            $data['authors'] = $this->Post_model->get_authors();
            //Get Module Options  
            $data['mod_selection'] = $this->Module_model->get_all();
            //Get selected modules
            $data['selected_modules'] = $this->Post_model->get_page_modules($post_id);

		  //Load View Into Template
            $this->template->load('default','admin','posts/edit', $data);
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

            //Upload Image
            $config['upload_path'] = './assets/images/blog/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '2048';
            $config['max_width'] = '1024';
            $config['max_height'] = '768';
            $config['overwrite']    = true;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload()){
                $errors = array('error' => $this->upload->display_errors());
                if($this->input->post('delete_image') != 1){
                    $main_image = $this->Post_model->get($post_id)->main_image;
                } else {
                    $main_image = 'noimage.jpg';
                }
            } else {
                $data = array('upload_data' => $this->upload->data());
                $main_image = $_FILES['userfile']['name'];
            }


            //Create Page Data Array
            $data = array(
                'title'         => $this->input->post('post_title'),
                'slug'          => $post_slug,
                'body'          => $this->input->post('post_body'),
                'main_image'    => $main_image,
                'seo_title'     => $this->input->post('seo_page_title'),
                'keywords'      => $this->input->post('keywords'),
                'description'   => $this->input->post('post_description'),
                'page_modules'  => $mod_string,
                'tags'          => $this->input->post('keywords'),
                'is_published'  => $this->input->post('is_published'),
                'category_id'   => $this->input->post('post_category'),
                'author_id'     => $this->input->post('post_author')
            );   

            //Post Udate
            $this->Post_model->update_by(array('id'=>$post_id), $data);

            //Activity Array
            $data = array(
                'resource_id'   =>  $post_id,
                'resource'      => 'post',
                'action'        => 'updated',
                'message'       => 'A post was updated',
                'icon'          => 'fa-thumb-tack'
            ); 

            //Add Activity  
            $this->Activity_model->insert($data);

            //Create Message
            $this->session->set_flashdata('post_added', 'Your post has been saved');
            
            //Redirect to pages
            redirect('admin/posts');
        }
	}

	public function delete($post_array){      
            if(!isset($post_array) || $post_array == ''){
                redirect('admin/posts');
            }
            //Delete posts in array
            $this->Post_model->delete_many($post_array);
         
            //Create Message
            $this->session->set_flashdata('post_deleted', 'Your post(s) have been deleted');
            
            //Redirect to posts
            redirect('admin/posts');
     }

     public function publish($post_array){
          if(!isset($post_array) || $post_array == ''){
                redirect('admin/posts');
            }
            //Publish posts in array
            $this->Post_model->publish_posts($post_array);
         
            //Create Message
            $this->session->set_flashdata('post_published', 'Your post(s) have been published');
            
            //Redirect to posts
            redirect('admin/posts');
     }
     
     public function unpublish($post_array){
           if(!isset($post_array) || $post_array == ''){
                redirect('admin/posts');
            }
         	//Unpublish posts in array
          	$this->Post_model->unpublish_posts($post_array);
         
            //Create Message
            $this->session->set_flashdata('post_unpublished', 'Your post(s) have been unpublished');
            
            //Redirect to posts
            redirect('admin/posts');
    }

	public function comments(){
        //Get Comments
        $data['comments'] = $this->Post_model->get_comments();

		//Load View Into Template
        $this->template->load('default','admin','posts/comments',$data);
	}

    public function delete_comment($comment_array){      
            if(!isset($comment_array) || $comment_array == ''){
                redirect('admin/posts/comments');
            }
            //Delete comments in array
            $this->Post_model->delete_comment($comment_array);
         
            //Create Message
            $this->session->set_flashdata('comment_deleted', 'Comment has been deleted');
            
            //Redirect to comments
            redirect('admin/posts/comments');
     }

     public function approve_comment($comment_array){
          if(!isset($comment_array) || $comment_array == ''){
                redirect('admin/posts/comments');
            }
            //Publish comments in array
            $this->Post_model->approve_comment($comment_array);
         
            //Create Message
            $this->session->set_flashdata('comment_approved', 'Comment has been approved');
            
            //Redirect to comments
            redirect('admin/posts/comments');
     }
     
     public function unapprove_comment($comment_array){
           if(!isset($comment_array) || $comment_array == ''){
                redirect('admin/posts/comments');
            }
            //Unapprove comments in array
            $this->Post_model->unapprove_comment($comment_array);
         
            //Create Message
            $this->session->set_flashdata('comment_unapproved', 'Comment has been unapproved');
            
            //Redirect to comments
            redirect('admin/posts/comments');
    }
	
}