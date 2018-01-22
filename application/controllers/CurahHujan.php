<?php

class CurahHujan extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mdesa');
		$this->load->model('MCurahHujan');
	}

	function index(){
		$data['listcurahhujan']=$this->MCurahHujan->listcurahhujan();
		$data['isi']='CurahHujan';
		
		$this->load->view('dashboard',$data);
	}

	function create(){
		$data['listdesa']=$this->Mdesa->listdesa();
		$this->load->view("CurahHujan/create",$data);
	}

	function tambah(){
		$data = array('Tahun' => $this->input->post('tahun'), 
					  'Bulan' => $this->input->post('bulan'),
					  'IdDaerah'=> $this->input->post('iddesa'),
					  'CurahHujan'=>$this->input->post('curahhujan'),
					  'Suhu'=>$this->input->post('suhu'));

		$this->MCurahHujan->insert($data);
	}

	function edit(){
		$id=$this->input->post('iddesa');
		$data['curahhujan']=$this->MCurahHujan->read($id);
		$data['listdesa']=$this->Mdesa->listdesa();
		$this->load->view('CurahHujan/edit',$data);
	}

	function update(){
		$data= array('Tahun' => $this->input->post('tahun'), 
					  'Bulan' => $this->input->post('bulan'),
					  'IdDaerah'=> $this->input->post('iddesa'),
					  'CurahHujan'=>$this->input->post('curahhujan'),
					  'Suhu'=>$this->input->post('suhu'));

		$id=$this->input->post('idcurah');
		$this->MCurahHujan->update($data,$id);
	}

}
?>