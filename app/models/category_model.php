<?php
class Category_model extends MY_Model{
	 function __construct(){
        parent::__construct();
        $this->table = 'blog_categories';
    }

    public function get_categories(){
      	$query = $this->db->get('blog_categories');
      	$this->db->order_by('id','DESC');
       	return $query->result();
    }

     public function get_category($category_id){
        $query = $this->db->get('blog_categories');
        $this->db->where('id', $category_id);
        return $query->row();
    }

    public function insert_category($data){
    	$this->db->insert('blog_categories', $data); 
    }

    public function update_category($category_id,$data){
        $this->db->where('id', $category_id);
        $this->db->update('blog_categories', $data); 
    }

     //Publish Categories
    public function publish_categories($category_array){
        foreach($category_array as $category_id){
           $data = array(
               'is_published' => 1
            );
            $this->db->where('id',$category_id);
            $this->db->update('blog_categories',$data);
        }
        return;
    }
    
    //Unpublish Categories
    public function unpublish_categories($category_array){
        foreach($category_array as $category_id){
            $data = array(
               'is_published' => 0
            );
            $this->db->where('id',$category_id);
            $this->db->update('blog_categories',$data);
        }
        return;
    }

    public function delete_category($category_array){
    	foreach($category_array as $category_id){
            $this->db->where('id', $category_id);
			$this->db->delete('blog_categories'); 
        }
        return;
    }
}