<?php
class Forecast extends CI_Controller{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdesa');
		$this->load->model('MCurahHujan');
	}


	function index(){
		$data['listdesa']=$this->Mdesa->listdesa();
		$data['isi']='Forecast';
		$this->load->view('dashboard',$data);

	}

	
}
?>