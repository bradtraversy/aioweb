<?php
class Settings extends Admin_Controller{
	public function __construct(){
		parent::__construct();

		//Validate User
        $this->access->validate_user();
	}

	public function index(){
		//Load View Into Template
        $this->template->load('default','admin','settings/index');
	}
	
}