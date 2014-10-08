<?php
class Dashboard_model extends MY_Model{
	 public function __construct(){
        parent::__construct();
    }

    public function get_activities(){
    	$query = $this->db->get('activities',8);
    	return $query->result();
    }

    public function get_tasks(){
    	$query = $this->db->get('tasks',10);
    	return $query->result();
    }

    public function mark_task_complete($task_id){
    	$this->db->where('id', $task_id);
		$this->db->delete('tasks'); 
    }

    public function add_task($data){
    	$this->db->insert('tasks', $data); 
    }
}