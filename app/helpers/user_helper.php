<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function users_full_name(){
    $CI =& get_instance();
    return $CI->session->userdata('user_id')->first_name.' '.$CI->session->userdata('user_id')->last_name;
}   


function get_access_group($access){
    if($access == 0){
    	return 'Everyone';
    } else {
    	$CI =& get_instance();
    	$CI->load->database();
     
     	$CI->db->where('id',$access);
     	$query = $CI->db->get('user_groups');
     	return $query->row()->title;
    }
}   

function get_user_group($group_id){
        $CI =& get_instance();
        $CI->load->database();
     
        $CI->db->where('id',$group_id);
        $query = $CI->db->get('user_groups');
        return $query->row()->title;
} 
