<?php
class Module_model extends MY_Model{
	public function __construct(){
        parent::__construct();
        $this->table = 'modules';
    }

    //Publish module(s)
    public function publish_modules($module_array){
        foreach($module_array as $module_id){
           $data = array(
               'is_published' => 1
            );
            $this->db->where('id',$module_id);
            $this->db->update('modules',$data);
        }
        return;
    }
    
    //Unpublish module(s)
    public function unpublish_modules($module_array){
        foreach($module_array as $module_id){
            $data = array(
               'is_published' => 0
            );
            $this->db->where('id',$module_id);
            $this->db->update('modules',$data);
        }
        return;
    }

    //Make Global
    public function make_global($module_array){
        foreach($module_array as $module_id){
           $data = array(
               'is_global' => 1
            );
            $this->db->where('id',$module_id);
            $this->db->update('modules',$data);
        }
        return;
    }
    
    //Remove Global
    public function remove_global($module_array){
        foreach($module_array as $module_id){
            $data = array(
               'is_global' => 0
            );
            $this->db->where('id',$module_id);
            $this->db->update('modules',$data);
        }
        return;
    }

    //Get Positions
    public function get_positions(){
    	$query = $this->db->get('module_positions');
    	return $query->result();
    }

    //Get Position
    public function get_position($module_id){
    	$query = $this->db->get('module_positions');
    	$this->db->where('id', $module_id);
    	return $query->row();
    }

     //Publish Positions
    public function publish_positions($position_array){
        foreach($position_array as $position_id){
           $data = array(
               'is_published' => 1
            );
            $this->db->where('id',$position_id);
            $this->db->update('module_positions',$data);
        }
        return;
    }
    
    //Unpublish Positions
    public function unpublish_positions($position_array){
        foreach($position_array as $position_id){
            $data = array(
               'is_published' => 0
            );
            $this->db->where('id',$position_id);
            $this->db->update('module_positions',$data);
        }
        return;
    }

    public function delete_positions($position_array){
    	foreach($position_array as $position_id){
            $this->db->where('id', $position_id);
			$this->db->delete('module_positions'); 
        }
        return;
    }

    public function insert_position($data){
    	$this->db->insert('module_positions', $data); 
    }

    public function update_position($position_id,$data){
        $this->db->where('id', $position_id);
        $this->db->update('module_positions', $data); 
    }

    //Update Order
    public function update_order($item_id,$position){
         $data = array(
               'order' => $position
            );
            $this->db->where('id',$item_id);
            $this->db->update('modules',$data);
    }

}