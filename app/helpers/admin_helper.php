<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function get_time_elapsed($timestamp){
	 $time = time() - strtotime($timestamp); // to get the time since that moment

    $tokens = array (
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
    }
}

function get_severity($task_severity){
     if($task_severity == 'Low') $severity = 'label-default';
     if($task_severity == 'Normal') $severity = 'label-success';
     if($task_severity == 'High') $severity = 'label-warning';
     if($task_severity == 'Urgent') $severity = 'label-danger';
     return $severity;
}

function get_resource($item_id){
    $CI =& get_instance();
    $CI->load->database();
     
    $CI->db->where('id',$item_id);
    $query = $CI->db->get('menu_items');
    if($query->row()->page_id != 0){
        return 'Page';
    }
    if($query->row()->form_id != 0){
        return 'Form';
    }
    if($query->row()->url != NULL){
        return 'URL';
    }
}

function get_resource_id($item_id){
    $CI =& get_instance();
    $CI->load->database();
     
    $CI->db->where('id',$item_id);
    $query = $CI->db->get('menu_items');
    if($query->row()->page_id != 0){
        return $query->row()->page_id;
    }
    if($query->row()->form_id != 0){
        return $query->row()->form_id;
    }
    if($query->row()->url != NULL){
        return $query->row()->url;
    }
}

function get_title($table,$id,$none = 'None'){
    $CI =& get_instance();
    $CI->load->database();
     
    $CI->db->where('id',$id);
    $query = $CI->db->get($table);
    if($query->num_rows() > 0){
        return $query->row()->title;
    } else {
        return $none;
    }
}