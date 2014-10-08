<?php
class Messages extends Admin_Controller{
	public function __construct(){
		parent::__construct();

        //Validate User
        $this->access->validate_user();
	}

	/*
	 * Displays all pages
	 */
	public function index(){
        
    }
    
}