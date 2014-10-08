<?php
class User_model extends MY_Model{
	 function __construct(){
        parent::__construct();
        $this->table = 'users';
    }

    function get_user_groups(){
    	$query = $this->db->get('user_groups');
    	$this->db->order_by('id', 'desc');
    	return $query->result();
    }

    /**
     * Activate a user
     */
    public function activate($user_array){
        foreach($user_array as $user_id){
           $data = array(
               'is_activated' => 1
            );
            $this->db->where('id',$user_id);
            $this->db->update('users',$data);
        }
        return;
    }
    
    /**
     * Activate a user
     */
    public function deactivate($user_array){
        foreach($user_array as $user_id){
            $data = array(
               'is_activated' => 0
            );
            $this->db->where('id',$user_id);
            $this->db->update('users',$data);
        }
        return;
    }

     /**
     * Get all US states
    **/
    public function get_states(){
        $states = array('0'=>"Select State",
                        'AL'=>"Alabama",  
			'AK'=>"Alaska",  
			'AZ'=>"Arizona",  
			'AR'=>"Arkansas",  
			'CA'=>"California",  
			'CO'=>"Colorado",  
			'CT'=>"Connecticut",  
			'DE'=>"Delaware",  
			'DC'=>"District Of Columbia",  
			'FL'=>"Florida",  
			'GA'=>"Georgia",  
			'HI'=>"Hawaii",  
			'ID'=>"Idaho",  
			'IL'=>"Illinois",  
			'IN'=>"Indiana",  
			'IA'=>"Iowa",  
			'KS'=>"Kansas",  
			'KY'=>"Kentucky",  
			'LA'=>"Louisiana",  
			'ME'=>"Maine",  
			'MD'=>"Maryland",  
			'MA'=>"Massachusetts",  
			'MI'=>"Michigan",  
			'MN'=>"Minnesota",  
			'MS'=>"Mississippi",  
			'MO'=>"Missouri",  
			'MT'=>"Montana",
			'NE'=>"Nebraska",
			'NV'=>"Nevada",
			'NH'=>"New Hampshire",
			'NJ'=>"New Jersey",
			'NM'=>"New Mexico",
			'NY'=>"New York",
			'NC'=>"North Carolina",
			'ND'=>"North Dakota",
			'OH'=>"Ohio",  
			'OK'=>"Oklahoma",  
			'OR'=>"Oregon",  
			'PA'=>"Pennsylvania",  
			'RI'=>"Rhode Island",  
			'SC'=>"South Carolina",  
			'SD'=>"South Dakota",
			'TN'=>"Tennessee",  
			'TX'=>"Texas",  
			'UT'=>"Utah",  
			'VT'=>"Vermont",  
			'VA'=>"Virginia",  
			'WA'=>"Washington",  
			'WV'=>"West Virginia",  
			'WI'=>"Wisconsin",  
			'WY'=>"Wyoming");
        return $states;
    }

    function get_user_group($user_id){
    	$query = $this->db->get('user_groups');
    	$this->db->where('id',$user_id);
    	return $query->row()->title;
    }

    /**
     * Check to see if the username is taken
     */
    public function check_username_exists($username){
        $this->db->select('username');
        $this->db->where('username',$username);
        $result = $this->db->get('users');
        if($result->num_rows > 0){
                //It exists
                return true;
	} else {
                //It doesnt exist
                return false;
        }
    }

    /**
     * Check to see if the email is taken
     */
    public function check_email_exists($email){
        $this->db->select('email');
        $this->db->where('email',$email);
        $result = $this->db->get('users');
        if($result->num_rows > 0){
                //It exists
                return true;
	} else {
                //It doesnt exist
                return false;
        }
    }

}