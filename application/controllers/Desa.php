<?php
class Desa extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('Mdesa');
	}

	function index(){
		$data['listdesa']=$this->Mdesa->listdesa();
		$data['isi']='Desa';
		$this->load->view('dashboard',$data);
	}

	function create(){
		$this->load->view("Desa/create");
	}

	function tambahdesa(){
		$data= array(
			'NamaDesa' =>$this->input->post('namadesa'),
			'Tlp'=>$this->input->post('tlp'),
			'Kl'=>$this->input->post('kl'),
			);
		$this->Mdesa->insertdesa($data);
	}

	function editdesa(){
		$id=$this->input->post('iddesa');
		$data['desa']=$this->Mdesa->editdesa($id);
		$this->load->view("Desa/edit",$data);
	}

	function updatedesa(){
		$data= array(
			'NamaDesa' => $this->input->post('namadesa'),
			'Tlp'=>$this->input->post('tlp'),
			'Kl'=>$this->input->post('kl'), 
			);
		$id=$this->input->post('iddesa');
		$this->Mdesa->updatedesa($data,$id);
	}

	function deletedesa(){
		$id=$this->input->post('iddesa');
		$this->Mdesa->deletedesa($id);
	}
}
?>