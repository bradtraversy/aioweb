<?php
class Dashboard extends Admin_Controller{
	public function __construct(){
		parent::__construct();

		if(!$this->session->userdata('logged_in')){
			redirect('admin/login');
		}
		//Validate User
         $this->access->validate_user();
	}

	public function index(){
		//Count Records
		$data['page_count'] = $this->Page_model->count_all();
		$data['post_count'] = $this->Post_model->count_all();
		$data['user_count'] = $this->User_model->count_all();
		$data['comment_count'] = $this->db->count_all('blog_comments');

		//Get latest activities
		$data['activities'] = $this->Dashboard_model->get_activities();
		//Get Tasks
		$data['tasks'] = $this->Dashboard_model->get_tasks();
		//Get latest blog posts
		$data['posts'] = $this->Post_model->limit(3)->get_all();

		//Load View Into Template
        $this->template->load('default','admin','dashboard',$data);
	}

	public function mark_task_complete($task_id){
		//Delete Task
		$this->Dashboard_model->mark_task_complete($task_id);

		//Create Message
        $this->session->set_flashdata('task_deleted', 'Task has been deleted');

        //Redirect to Dashboard
		redirect('admin'); 
	}

	public function add_task(){
		//Create Category Data Array
        $data = array(
           	'task'          => $this->input->post('task'),
            'severity'      => $this->input->post('severity'),
            'due_date'   	=> $this->input->post('due_date')
            );  

		$this->Dashboard_model->add_task($data);

		 //Activity Array
            $data = array(
                'resource_id'   =>  $this->db->insert_id(),
                'resource'      => 'task',
                'action'        => 'added',
                'message'       => 'A new task was created',
                'icon'          => 'fa-check'
            ); 

            //Add Activity  
            $this->Activity_model->insert($data);

		//Create Message
        $this->session->set_flashdata('task_added', 'Task has been added');

        //Redirect to Dashboard
		redirect('admin'); 
	}
	
}