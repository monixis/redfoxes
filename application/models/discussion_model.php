<?php
class discussion_model extends CI_Model
{

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		// $this->load->database();
	}
	public function discussion_list() {
			//$result = $this->db->get('discussion');
			//$result = $this->db->query($query);
			$this->db->select('d_id, d_title, d_body, cwid, category,  datetime(age, "localtime") as age, d_num, username');
			$this->db->from('discussion');
			//$this->db->limit(1);
			$result = $this->db->get();
			if ($result) {
				return $result;
			} else {
				return false;
			}
		}
	public function create($data) {
    // Look and see if the email address already exists in the users
    // table, if it does return the primary key, if not create them
    // a user account and return the primary key.
    $discussion_data = array('cwid' => $data['cwid'],'d_title' => $data['ds_title'],'d_body' =>$data['ds_body'],'category'=>$data['category'],'d_num'=>$data['ds_num'],'username'=>$data['firstname']); //can be added a field for active discussions 'ds_is_active' => '1'
		$inserting =  $this->db->insert("discussion",$discussion_data);
    if ($inserting) {
			return 1;
		} else {
			return 0;
		}
	}
	public function createPost($data) {
    // Look and see if the email address already exists in the users
    // table, if it does return the primary key, if not create them
    // a user account and return the primary key.
    $post_data = array('d_id' => $data['d_id'],'p_title' => $data['p_title'],'p_body' =>$data['p_body'],'cwid' =>$data['cwid'],'username'=>$data['firstname']); //can be added a field for active discussions 'ds_is_active' => '1'
		$inserting =  $this->db->insert("post",$post_data);
    if ($inserting) {
			return 1;
		} else {
			return 0;
		}
	}

	public function addEmailId($data) {
    $email_data = array('email' => $data['emailid'],'cwid' => $data['cwid'],'firstname' =>$data['firstname'], 'lastname' =>$data['lastname']);
		//$email_data = array('emailid' => $data['emailid'],'cwid' => $data['cwid'],'firstname' =>$data['firstname'],'lastname' =>$data['lastname']);
		$inserting =  $this->db->insert("webusers",$email_data);
    if ($inserting) {
			return 1;
		} else {
			return 0;
		}
	}

	public function createComment($data) {
    // Look and see if the email address already exists in the users
    // table, if it does return the primary key, if not create them
    // a user account and return the primary key.
    $comment_data = array('p_id' => $data['p_id'],'c_body' =>$data['c_body'],'cwid' =>$data['cwid']); //can be added a field for active discussions 'ds_is_active' => '1'
		$inserting =  $this->db->insert("comment",$comment_data);
    if ($inserting) {
			return 1;
		} else {
			return 0;
		}
	}

	/**
	 * get email ID based on category
	 */
	public function getEmailId($data){
        //get email id based on category
        $condition = 'category='."'".$data['category']."'";
        $this->db->select('*');
        $this->db->from('email');
        $this->db->where($condition);
        $eidquery = $this->db->get();
        $ret = $eidquery->row();
        $emailID = 	$ret->emailID;
        if($eidquery->num_rows() > 0){
            return  $emailID;
        }
	}

	//get discussion id for newly inserted record - needed for email function
    public function getDId($data){
        $condition = 'd_num='."'".$data['ds_num']."'";
        $this->db->select('*');
        $this->db->from('discussion');
        $this->db->where($condition);
        $didquery = $this->db->get();
        $ret = $didquery->row();
        $d_id = $ret->d_id;
        if($didquery->num_rows() > 0){
            return $d_id;
        }

	}
	
	//Get email flag based on category
	public function getMailFlag($category){
		$condition = 'category='."'".$category."'";
        $this->db->select('*');
        $this->db->from('email');
        $this->db->where($condition);
        $eidquery = $this->db->get();
        $ret = $eidquery->row();
        $flag = 	$ret->flag;
        if($eidquery->num_rows() > 0){
            return  $flag;
        }
	}

	/*
     * find email -
     * first need to find the category
     * from category, find email iD
     */
    public function find_email($dnum){
        //function to fetch discussions details from the database
        $condition = 'd_num='."'".$dnum."'".' OR '.'d_id='."'".$dnum."'";
        $this->db->select('*');
        $this->db->from('discussion');
        $this->db->where($condition);
        //$this->db->limit(1);
        $query = $this->db->get();
        $ret = $query->row();
        $cat = 	$ret->category;
        //var_dump($val);


        $condition = 'category='."'".$cat."'";
        $this->db->select('*');
        $this->db->from('email');
        $this->db->where($condition);
        //$this->db->limit(1);
        $emailquery = $this->db->get();
        $ret = $emailquery->row();
        $emailID = 	$ret->emailID;

        if($emailquery->num_rows() == 1) {
            return $emailID;
        } else {
            return false;
        }
	}

	/*
     * find email flag -
     * first need to find the category
     * from category, find email iD
     */
    public function find_mail_flag($dnum){
        //function to fetch discussions details from the database
        $condition = 'd_num='."'".$dnum."'".' OR '.'d_id='."'".$dnum."'";
        $this->db->select('*');
        $this->db->from('discussion');
        $this->db->where($condition);
        //$this->db->limit(1);
        $query = $this->db->get();
        $ret = $query->row();
        $cat = 	$ret->category;
        //var_dump($val);


        $condition = 'category='."'".$cat."'";
        $this->db->select('*');
        $this->db->from('email');
        $this->db->where($condition);
        //$this->db->limit(1);
        $flagquery = $this->db->get();
        $ret = $flagquery->row();
        $flag = $ret->flag;

        if($flagquery->num_rows() == 1) {
            return $flag;
        } else {
            return false;
        }
    }

	public function fetch_discussion($did){
		//function to fetch discussions details from the database
		$condition = 'd_id='."'".$did."'";
		$this->db->select('d_id, d_title, d_body, cwid, category,  datetime(age, "localtime") as age, d_num, username');
		$this->db->from('discussion');
		$this->db->where($condition);
		//$this->db->limit(1);
		$query = $this->db->get();

		if($query->num_rows() == 1) {
			return $query;
		} else {
			return false;
		}
	}

	public function find_discussion($dnum){
		//function to fetch discussions details from the database
		$condition = 'd_num='."'".$dnum."'".' OR '.'d_id='."'".$dnum."'";
		$this->db->select('d_id, d_title, d_body, cwid, category,  datetime(age, "localtime") as age, d_num, username');
		$this->db->from('discussion');
		$this->db->where($condition);
		//$this->db->limit(1);
		$query = $this->db->get();
		$ret = $query->row();
		$val = 	$ret->d_id;
		//var_dump($val);

		if($query->num_rows() == 1) {
			return $val;
		} else {
			return false;
		}
	}
	public function count_post($did){
		//function to fetch discussions details from the database
		$condition = 'd_id='."'".$did."'";
		$this->db->select('*');
		$this->db->from('post');
		$this->db->where($condition);
		//$this->db->limit(1);
		$query = $this->db->get();
		$result = $query->result();
		$count = $query->num_rows();
		return $count;
	}
	public function fetch_post($did){//, $limit, $start)
		//function to fetch discussions details from the database
		$condition = 'd_id='."'".$did."'";
		$this->db->select('p_id, d_id, p_title, p_body, cwid, datetime(age, "localtime") as age, username');
		$this->db->from('post');
		$this->db->where($condition);
		$this->db->order_by("age","desc");
		//$this->db->limit($limit, $start);
		$postquery = $this->db->get();

		if($postquery->num_rows() > 0) {
			return $postquery;
		} else {
				return false;
		}
	}
	public function fetch_postid($pid){
		//function to fetch discussions details from the database
		$condition = 'p_id='."'".$pid."'";
		$this->db->select('*');
		$this->db->from('post');
		$this->db->where($condition);
		$this->db->order_by("age","desc");
		//$this->db->limit(1);
		$postquery = $this->db->get();

		if($postquery->num_rows() > 0) {
			return $postquery;
		} else {
				return false;
		}
	}

	public function checkuniqueuser($cwid){
		$condition = 'cwid='."'".$cwid."'";
		$this->db->select('*');
		$this->db->from('webusers');
		$this->db->where($condition);
		$userquery = $this->db->get();
		if($userquery->num_rows() > 0){
			return $userquery;
		} else {
			return false;
		}
	}

	public function getusername($cwid){
		$condition = 'cwid='."'".$cwid."'";
		$this->db->select('*');
		$this->db->from('webusers');
		$this->db->where($condition);
		$usernamequery = $this->db->get();
		$ret = $usernamequery->row();
		$fname = 	$ret->firstname; //firstname
		$lname = $ret->lastname; //lastname
		$val = $fname." ".$lname; //fullname
		//$uname = $usernamequery->result();
		if($usernamequery->num_rows() > 0){
			return $val;
		} else {
			return false;
		}
	}

	public function fetch_comment($pid){
		$condition = 'p_id='."'".$pid."'";
		$this->db->select('*');
		$this->db->from('comment');
		$this->db->where($condition);
		$this->db->order_by('age','desc');
		//$this->db->limit(1);
		$pidquery = $this->db->get();
		$pid=$pidquery->result();
		if($pidquery->num_rows() > 0) {
			return $pidquery;
		} else {
			return false;
			}
	}
}
?>
