<?php
class discussion extends CI_Controller
{

	private $current_line;
	private $recent = true;

	public function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION))
    {
        session_start();
				$_SESSION['id'] = session_id();
    }
		$this->lang->load('en_admin_lang');
		$this->load->model('discussion_model');
	}
	public function index()
	{
		$data['title'] = "Redfoxes Forums";
		//$this->load->view('createDiscussion_view',$data);
		$date = date("m/d/Y");
	  if (isset($_SESSION['LAST_SESSION']) && (time() - $_SESSION['LAST_SESSION'] > 900)) {
					 if(!isset($_SESSION['CAS'])) {
							 $_SESSION['CAS'] = false; // set the CAS session to false
					 }
			 }
		$authenticated = $_SESSION['CAS'];
		$_SESSION['id'] = session_id();
			 //URL accessable when the authentication works
	  //$casurl = "http%3A%2F%2Flocalhost%2Frepository%2F%3Fc%3Dauth%26m%3DdbAuth";
	  //$casurl = "http://localhost/redfoxes/discussion/createDiscussion_view";
		//$casurl = "http%3A%2F%2Fdev.library.marist.edu%2Fredfoxes%2F%3Fc%3DDiscussion%26m%3DcreateDiscussion_view"; //-uncomment for dev
	$casurl = "http%3A%2F%2Flibrary.marist.edu%2Fredfoxes%2F%3Fc%3Ddiscussion%26m%3DcreateDiscussion_view";
		if (!$authenticated) {
					 $_SESSION['LAST_SESSION'] = time(); // update last activity time stamp
					 $_SESSION['CAS'] = true;
					 echo '<META HTTP-EQUIV="Refresh" Content="0; URL=https://login.marist.edu/cas/?service='.$casurl.'">';
					 exit;
				 }
		if ($authenticated) {
		 //$this->session->set_userdata('ad', true); // this needs to be set when the user access is accepted by CAS
		 if (isset($_GET["ticket"])) {
			 //set up validation URL to ask CAS if ticket is good
			 $_url = "https://login.marist.edu/cas/validate";
			 //  $serviceurl = "http://localhost:9090/repository-2.0/?c=repository&m=cas_admin";
			 // $cassvc = 'IU'; //search kb.indiana.edu for "cas application code" to determine code to use here in place of "appCode"
			 //$ticket = $_GET["ticket"];
			 $params = "ticket=$_GET[ticket]&service=$casurl";
			 $urlNew = "$_url?$params";
			// $urlNew = "$_url";

			 //CAS sending response on 2 lines. First line contains "yes" or "no". If "yes", second line contains username (otherwise, it is empty).
			 $ch = curl_init();
			 $timeout = 5; // set to zero for no timeout
			 curl_setopt ($ch, CURLOPT_URL, $urlNew);
			 curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			 ob_start();
			 curl_exec($ch);
			 curl_close($ch);
			 $cas_answer = ob_get_contents();
			 ob_end_clean();

			 //split CAS answer into access and user
			 list($access,$user) = preg_split("/\n/",$cas_answer,2);
			 $access = trim($access);
			 $user = trim($user);
			 //$this->session->set_userdata('access',$access)
			 //set user and session variable if CAS says YES
			 if ($access == "yes") {
					 $user= str_replace('@marist.edu','',$user);
					 $_SESSION['user'] = $user;
					 $_SESSION['access'] = $access;
					 $_SESSION['cas_answer'] = $cas_answer;
					 $data['cwid'] = $_SESSION['user'];
					 $cwid = $_SESSION['user'];
					 $userquery = $this->discussion_model->checkuniqueuser($cwid);
					 if($userquery){
						 $data['username'] = $this->discussion_model->getusername($cwid);
						 $_SESSION['firstname'] = $data['username'];
					 } else {
						 $data['username'] = '';
					 }
					 //$data['uname'] = $_GET['username'];
					 $data['cas_answer'] = $_SESSION['cas_answer'];
					 $data['title'] = "Redfoxes Forums";
					 $this->session->set_userdata('ad',$access);
	 				 $this->load->view('createDiscussion_vieww',$data);
					 } else {
						 echo "<h1>UnAuthorized Access</h1>";
					 }
				 }//END SESSION user
				 else{
					 echo '<META HTTP-EQUIV="Refresh" Content="0; URL=https://login.marist.edu/cas?service='.$casurl.'">';
				 }
			 } else  {
				 echo '<META HTTP-EQUIV="Refresh" Content="0; URL=https://login.marist.edu/cas?service='.$casurl.'">';
			 }
			/* if($_GET['ticket']!='') {
				 if(empty($_SESSION['login'])){
					 $_SESSION['login'] = 'yes';
				 }
		 }*/
	 }



	public function successView(){
		$this->load->view('success_view');
	}

	public function failView(){
		$this->load->view('fail_view');
	}

	public function createDiscussion_view(){
				$data['user'] = $_SESSION['user'];
				$cwid = $_SESSION['user'];
				$userquery = $this->discussion_model->checkuniqueuser($cwid);
				if($userquery){
					$data['username'] = $this->discussion_model->getusername($cwid);
				} else {
					$data['username'] = '';
				}
				$data['title'] = "Redfoxes Forumss";
				$this->load->view('createDiscussion_vieww',$data);
	}
	public function discussionList(){
		$page_data['query'] = $this->discussion_model->discussion_list();
		$this->load->view('discussionList_view',$page_data);
	}
	public function create() {
    //$this->form_validation->set_rules('cwid', $this->lang->line('cwid'), 'required|min_length[8]|max_length[8]');
    $this->form_validation->set_rules('ds_title', $this->lang->line('discussion_ds_title'), 'required|min_length[1]|max_length[50]');
    $this->form_validation->set_rules('ds_body', $this->lang->line('discussion_ds_body'), 'required|min_length[1]|max_length[500]');
		if ($this->form_validation->run() == FALSE) {
			$data['title'] = "Redfoxes Forums";
			$this->load->view('newDiscussion_view',$data);//add alert and bring user to same page to fill the form again.
		} else {
			$data = array(
				'cwid' => $_SESSION['user'],
				'ds_title' => $this->input->post('ds_title'),
				'ds_body' =>  $this->input->post('ds_body'),
				'category' => $this->input->post('category'),
				'ds_num' => $this->input->post('ds_num'),
				'firstname' => $_SESSION['firstname']
			);
      $dtitle = $this->input->post('ds_title');
      $dbody = $this->input->post('ds_body');

			$flag = $this->discussion_model->create($data);

			if ($flag) {
				return 1;
				/*$did = $this->discussion_model->find_discussion($dtitle,$dbody);
				$discussion_data['query'] = $this->discussion_model->fetch_discussion($did);
				$this->load->view('discussionDetails_view',$discussion_data);*/
				//redirect(base_url()); //need to redirected to the list of discussions __******
			} else {
				// error
				// load view and flash sess error
				$this->load->view('errors/error_exception');
			}
		}
	}
	public function discussionDetails(){
		//details include the discussion body, posts on the discussion and the comments on these posts
			$did = $this->uri->segment(3);
			//var_dump($did);
			$pid = array();
			//fetch discussions from Discussion IDs
			if($did != '') {
				$discussion_data['query'] = $this->discussion_model->fetch_discussion($did);
				$discussion_data['postquery'] = $this->discussion_model->fetch_post($did);//,$config['per_page'],$page);
				$this->load->view('discussionDetails_view',$discussion_data);
			}
			else {
				$this->load->view('fail_view');
			}
	}
	public function addNewPost(){
		$data['title'] = "Redfoxes Forums";
	  // Submitted form data
	  //$data['cwid']   = $_POST['cwid'];
		$data['cwid']   = $_SESSION['user'];
	  $data['p_title']   = $this->input->post('postTitle');
	  $data['p_body']   = $this->input->post('postBody');
		$data['d_id']   = $this->input->post('d_id');
		$data['firstname'] = $_SESSION['firstname'];
		$did = $this->input->post('d_id');
		if($data['p_title'] != NULL){
		if($this->discussion_model->createPost($data)){
			$post_data['postquery'] = $this->discussion_model->fetch_post($did);
			$post_data['query'] = $this->discussion_model->fetch_discussion($did);
			$this->load->view('discussionDetails_view',$post_data);
			} else {
				$this->load->view('fail_view');
			}
		}
		else {
			$this->load->view('fail_view');
		}
	}
	public function addEmail(){
		$data['title'] = "Redfoxes Forums";
	  // Submitted form data
	  //$data['cwid']   = $_POST['cwid'];
		$data['cwid'] = $_SESSION['user'];
		$cwid = $_SESSION['user'];
	  $data['emailid'] = $this->input->post('emailid');
		$data['firstname'] = $this->input->post('firstname');
		$data['lastname'] = $this->input->post('lastname');
	  if($data['emailid'] != NULL){
			if($this->discussion_model->addEmailId($data)){
				$userquery = $this->discussion_model->checkuniqueuser($cwid);
				if($userquery){
					if($_SESSION['firstname']='') {
						$data['username'] = $this->discussion_model->getusername($cwid);
						$_SESSION['firstname'] = $data['username'];
					} else {
						$_SESSION['fisrtname'] = 	$this->input->post('firstname');
					}
				} else {
					$data['username'] = '';
				}
				$data['title'] = "Redfoxes Forums";
				$this->load->view('createDiscussion_vieww',$data);
				} else {
					$this->load->view('fail_view');
				}
			} else {
				$this->load->view('fail_view');
			}
		}
		public function search_discussion(){
			$data['title'] = "Redfoxes Forums";
			$ds_num = $this->uri->segment(3);
			$did = $this->discussion_model->find_discussion($ds_num);
			if($did != '') {
				$discussion_data['query'] = $this->discussion_model->fetch_discussion($did);
				$discussion_data['postquery'] = $this->discussion_model->fetch_post($did);
				$this->load->view('discussionDetails_view',$discussion_data);
			} else {
				$this->load->view('fail_view');
			}
		}
}
?>
