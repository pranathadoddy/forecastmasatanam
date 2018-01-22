<?php

class admin extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	function index(){
		$data["isi"]="Home";
		$this->load->view("dashboard", $data);
	}
}
?>