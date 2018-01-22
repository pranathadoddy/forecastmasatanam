<?php

class Mdesa extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();		
	}

	function listdesa(){
		$this->db->from('tb_desa');
		$this->db->order_by('id','desc');
		$this->db->select('*');
		return $this->db->get();
	}

	function insertdesa($data){
		$this->db->insert('tb_desa',$data);
	}

	function editdesa($id){
		$this->db->from('tb_desa');
		$this->db->where('id',$id);
		$this->db->select('*');
		$query=$this->db->get();
		return $query->row();
	}

	function updatedesa($data, $id){
		$this->db->where("id",$id);
		$this->db->update("tb_desa",$data);
	}

	function deletedesa($id){
		$this->db->where("id",$id);
		$this->db->delete("tb_desa");
	}
}
?>