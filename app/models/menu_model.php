<?php
class Menu_model extends MY_Model{
	public function __construct(){
        parent::__construct();
        $this->table = 'menus';
    }

    //Get a form pages menu
    public function get_selected_menu($type,$id){
        $this->db->where($type.'_id',$id);
        $query = $this->db->get('menu_items');
        return $query->row();
    }

    public function add_item($data){
    	$this->db->insert('menu_items',$data);
        return;
    }

     public function get_item($type,$id){
        $query = $this->db->get('menu_items');
        $this->db->where($type.'_id',$id);
        if($query->num_rows() > 0){
            return $query->row();
        }
        return false;
    }

     public function get_item_by_id($id){
        $this->db->where('id',$id);
        $query = $this->db->get('menu_items');
        if($query->num_rows() > 0){
            return $query->row();
        }
        return false;
    }

    public function update_item($type, $data){
        $this->db->where($type.'_id',$data[$type.'_id']);
        $query = $this->db->get('menu_items');
        if($query->num_rows() > 0){
            $this->db->where($type.'_id', $data[$type.'_id']);
            $this->db->update('menu_items', $data);
        } else {
            $this->add_item($data);
        }
    }

    public function update_item_by_id($id,$data){
        $this->db->where('id', $id);
        $this->db->update('menu_items', $data); 
    }

     //Get all items
    public function get_all_items(){
        $this->db->order_by("order", "asc"); 
        $query = $this->db->get('menu_items');
        return $query->result();
    }

     public function get_selected_parent($type,$id){
        $this->db->where($type.'_id',$id);
        $query = $this->db->get('menu_items');
        if($query->num_rows() > 0){
            return $query->row()->parent_id;
        } else {
            return false;
        }
    }

    public function delete_item($type, $id){
        $this->db->where($type.'_id', $id);
        $this->db->delete('menu_items'); 
    }

    //Publish menu(s)
    public function publish_menus($menu_array){
        foreach($menu_array as $menu_id){
           $data = array(
               'is_published' => 1
            );
            $this->db->where('id',$menu_id);
            $this->db->update('menus',$data);
        }
        return;
    }
    
    //Unpublish menu(s)
    public function unpublish_menus($menu_array){
        foreach($menu_array as $menu_id){
            $data = array(
               'is_published' => 0
            );
            $this->db->where('id',$menu_id);
            $this->db->update('menus',$data);
        }
        return;
    }

    //Make Global
    public function make_global($menu_array){
        foreach($menu_array as $menu_id){
           $data = array(
               'is_global' => 1
            );
            $this->db->where('id',$menu_id);
            $this->db->update('menus',$data);
        }
        return;
    }
    
    //Remove Global
    public function remove_global($menu_array){
        foreach($menu_array as $menu_id){
            $data = array(
               'is_global' => 0
            );
            $this->db->where('id',$menu_id);
            $this->db->update('menus',$data);
        }
        return;
    }

    //Get selected position
    public function get_selected_position($id){
        $this->db->where('id',$id);
        $query = $this->db->get('menus');
        return $query->row()->module_position;
    }

    //Get selected access
    public function get_selected_access($id){
        $this->db->where('id',$id);
        $query = $this->db->get('menus');
        return $query->row()->access;
    }

     //Insert Item
    public function insert_item($data){
        $this->db->insert('menu_items', $data); 
    }

    //Delete items
    public function delete_items($item_array){
        foreach($item_array as $item_id){
            $this->db->where('id', $item_id);
            $this->db->delete('menu_items'); 
        }
        return;
    }

    //Publish item(s)
    public function publish_items($item_array){
        foreach($item_array as $item_id){
           $data = array(
               'is_published' => 1
            );
            $this->db->where('id',$item_id);
            $this->db->update('menu_items',$data);
        }
        return;
    }
    
    //Unpublish item(s)
    public function unpublish_items($item_array){
        foreach($item_array as $item_id){
            $data = array(
               'is_published' => 0
            );
            $this->db->where('id',$item_id);
            $this->db->update('menu_items',$data);
        }
        return;
    }

    //Update Order
    public function update_order($item_id,$position){
         $data = array(
               'order' => $position
            );
            $this->db->where('id',$item_id);
            $this->db->update('menu_items',$data);
    }


}