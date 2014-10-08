<?php
class User_Group_model extends MY_Model{
	function __construct(){
        parent::__construct();
        $this->table = 'users';
    }
}