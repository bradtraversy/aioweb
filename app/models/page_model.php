<?php
class Page_model extends MY_Model{
	public function __construct(){
        parent::__construct();
        $this->table = 'pages';
    }

    public function get_insert_id(){
        return $this->db->insert_id();
    }

    public function get_page_modules($id){
    	$query = $this->db->query('SELECT * FROM pages WHERE id = '.$id);
    	$modules_string = $query->row()->page_modules;
        $modules_array = explode(',',$modules_string); 
        return $modules_array;
    }

    public function get_page_access($id){
    	$query = $this->db->query('SELECT * FROM pages WHERE id = '.$id);
    	$groups_string = $query->row()->access;
        $groups_array = explode(',',$groups_string); 
        return $groups_array;
    }

    public function publish_pages($page_array){
        foreach($page_array as $page_id){
           $data = array(
               'is_published' => 1
            );
            $this->db->where('id',$page_id);
            $this->db->update('pages',$data);
        }
        return;
    }
    
    public function publish_menu_items($page_array){
        foreach($page_array as $page_id){
           $data = array(
               'is_published' => 1
            );
            $this->db->where('page_id',$page_id);
            $this->db->update('menu_items',$data);
        }
    }

     public function unpublish_pages($page_array){
        foreach($page_array as $page_id){
            $data = array(
               'is_published' => 0
            );
            $this->db->where('id',$page_id);
            $this->db->update('pages',$data);
        }
        return;
    }
    
    
     public function unpublish_menu_items($page_array){
        foreach($page_array as $page_id){
            $data = array(
               'is_published' => 0
            );
            $this->db->where('page_id',$page_id);
            $this->db->update('menu_items',$data);
        }
        return;
    }
    
    
    
     public function feature_pages($page_array){
        foreach($page_array as $page_id){
           $data = array(
               'is_featured' => 1
            );
            $this->db->where('id',$page_id);
            $this->db->update('pages',$data);
        }
        return;
    }
    
    
    
     public function unfeature_pages($page_array){
        foreach($page_array as $page_id){
            $data = array(
               'is_featured' => 0
            );
            $this->db->where('id',$page_id);
            $this->db->update('pages',$data);
        }
        return;
    }

}