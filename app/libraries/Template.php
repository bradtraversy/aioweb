<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 class Template {
    var $ci;
       
    function __construct() {
       $this->ci =& get_instance();
    }

    /*
     * @name:           load
     * @desc:           Loads the template and view specified
     * @param:tpl_name: Name of the template
     * @param:loc:      Location (admin or public)
     * @param:view:     Name of the view to load
     * @param:data:     Optional data array
     */
    function load($tpl_name, $loc, $view, $data = null) {
    	if($loc == 'admin'){
            if($tpl_name == 'default'){
                $tpl_name = $this->ci->config->item('admin_template');
            } 
        }
    		
    	if($loc == 'public'){
            if($tpl_name == 'default'){
                $tpl_name = $this->ci->config->item('public_template');
            } 
        }

    	$data['main'] = $loc.'/'.$view;
    	$this->ci->load->view($loc.'/templates/'.$tpl_name.'/index',$data);
	}
}