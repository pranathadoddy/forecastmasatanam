<?php
class login extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('muser');
	}

	function index(){
		if($this->session->userdata('logged_in')){
			redirect('/dashboard');
		}
		else{
			$this->load->view('login');	
		}
	}

	function login(){
		$username=$this->input->post('username');
		$password=md5($this->input->post('password'));
		$loginData=$this->muser->login($username, $password);
		echo $username;
		if($loginData==FALSE){
			echo FALSE;
		}else{
			$sessArray=array();
			foreach ($loginData as $row) {
				$sess_array= array(
					'username' =>$row->Username ,
					'type'=>$row->type_login,
					'id'=>$row->id );
			}
			$this->session->set_userdata('logged_in',$sess_array);
			echo TRUE;
		}
	}

	function logout(){
		$this->session->sess_destroy();
		redirect('/login');
	}
}
?>