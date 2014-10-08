<?php
class Form_model extends MY_Model{
	 function __construct(){
        parent::__construct();
        $this->table = 'forms';
    }

    //Publish form(s)
    public function publish_forms($form_array){
        foreach($form_array as $form_id){
           $data = array(
               'is_published' => 1
            );
            $this->db->where('id',$form_id);
            $this->db->update('forms',$data);
        }
        return;
    }
    
    //Unpublish form(s)
    public function unpublish_forms($form_array){
        foreach($form_array as $form_id){
            $data = array(
               'is_published' => 0
            );
            $this->db->where('id',$form_id);
            $this->db->update('forms',$data);
        }
        return;
    }

    public function get_page_modules($id){
    	$query = $this->db->query('SELECT * FROM forms WHERE id = '.$id);
    	$modules_string = $query->row()->page_modules;
        $modules_array = explode(',',$modules_string); 
        return $modules_array;
    }

    public function get_form_fields($form_id){
        $this->db->order_by('order','ASC');
        $this->db->where('form_id',$form_id);
        $query = $this->db->get('form_fields');
        return $query->result();
    }

    public function get_form_field($form_id,$field_id){
        $this->db->where('form_id',$form_id);
        $this->db->where('id',$field_id);
        $query = $this->db->get('form_fields');
        return $query->row();
    }

    //Get validations selected
    public function get_selected_validations($form_id,$field_id){
        $this->db->where('form_id',$form_id);
        $this->db->where('id',$field_id);
        $query = $this->db->get('form_fields');
        return $query->row()->validation;
    }

     //Add form field
    public function add_field($form_id,$data){
        $this->db->where('form_id',$form_id);
        $this->db->insert('form_fields',$data);
        return;
    }
    
    //Edit form field
    public function edit_field($form_id,$field_id,$data){
        $this->db->where('form_id',$form_id);
        $this->db->where('id', $field_id);
        $this->db->update('form_fields', $data); 
        return;
    }

    //Delete fields
    public function delete_fields($form_id,$field_array){
        foreach($field_array as $field_id){
            $this->db->where('form_id',$form_id);
            $this->db->where('id',$field_id);
            $this->db->delete('form_fields');
        }
       return;
    }
    
    
    //Publish fields
    public function publish_fields($form_id,$field_array){
        foreach($field_array as $field_id){
            $this->db->where('form_id',$form_id);
            $this->db->where('id',$field_id);
            $data = array(
               'is_published' => 1
            );
            $this->db->update('form_fields',$data);
        }
       return;
    }
    
    
    //Unpublish fields
    public function unpublish_fields($form_id,$field_array){
        foreach($field_array as $field_id){
            $this->db->where('form_id',$form_id);
            $this->db->where('id',$field_id);
            $data = array(
               'is_published' => 0
            );
            $this->db->update('form_fields',$data);
        }
       return;
    }

    //Update Order
    public function update_order($item_id,$position){
         $data = array(
               'order' => $position
            );
            $this->db->where('id',$item_id);
            $this->db->update('form_fields',$data);
    }
}