<?php
class Post_model extends MY_Model{
	 function __construct(){
        parent::__construct();
        $this->table = 'posts';
    }

 	public function get_posts(){
    	$this->db->select('a.*,b.title as category_title,c.first_name,c.last_name');
		$this->db->from('posts AS a');
		$this->db->join('blog_categories AS b', 'b.id = a.category_id');
		$this->db->join('users AS c', 'c.id = a.author_id');
        $this->db->order_by('a.id','DESC');
      	$query = $this->db->get();
       	return $query->result();
    }

    public function get_post($post_id){
        $this->db->select('a.*,b.title as category_title,c.first_name,c.last_name');
        $this->db->from('posts AS a');
        $this->db->join('blog_categories AS b', 'b.id = a.category_id');
        $this->db->join('users AS c', 'c.id = a.author_id');
        $this->db->where('a.id',$post_id);
        $this->db->order_by('a.id','DESC');
        $query = $this->db->get();
        return $query->row();
    }

    //Publish post(s)
    public function publish_posts($post_array){
        foreach($post_array as $post_id){
           $data = array(
               'is_published' => 1
            );
            $this->db->where('id',$post_id);
            $this->db->update('posts',$data);
        }
        return;
    }
    
    //Unpublish post(s)
    public function unpublish_posts($post_array){
        foreach($post_array as $post_id){
            $data = array(
               'is_published' => 0
            );
            $this->db->where('id',$post_id);
            $this->db->update('posts',$data);
        }
        return;
    }

    //Get Published Categories
    public function get_published_categories(){
        $this->db->where('is_published',1);
        $query = $this->db->get('blog_categories');
        return $query->result();
    }

     //Get Authors
    public function get_authors(){
        $this->db->where('is_activated',1);
        $this->db->where('user_group',2);
        $query = $this->db->get('users');
        return $query->result();
    }

    //Get Modules on Post Page
    public function get_page_modules($id){
        $query = $this->db->query('SELECT * FROM posts WHERE id = '.$id);
        $modules_string = $query->row()->page_modules;
        $modules_array = explode(',',$modules_string); 
        return $modules_array;
    }

    //Get All Comments
    public function get_comments(){
        $this->db->order_by('id','DESC');
        $query = $this->db->get('blog_comments');
        return $query->result();
    }

    //Approve Comment
    public function approve_comment($comment_array){
        foreach($comment_array as $comment_id){
           $data = array(
               'is_approved' => 1
            );
            $this->db->where('id',$comment_id);
            $this->db->update('blog_comments',$data);
        }
        return;
    }

    //Unapprove Comment
    public function unapprove_comment($comment_array){
        foreach($comment_array as $comment_id){
           $data = array(
               'is_approved' => 0
            );
            $this->db->where('id',$comment_id);
            $this->db->update('blog_comments',$data);
        }
        return;
    }

    //Delete Comment
    public function delete_comment($comment_array){
        foreach($comment_array as $comment_id){
            $this->db->where('id', $comment_id);
            $this->db->delete('blog_comments'); 
        }
        return;
    }
}