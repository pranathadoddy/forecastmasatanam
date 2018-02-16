<?php
class MCurahhujan extends CI_Model{
	function __construct()
	{
		parent::__construct();		
	}

	function listcurahhujan(){
		$this->db->from('tb_curahhujan');
		$this->db->order_by('id','desc');
		$this->db->select('*');
		return $this->db->get();
	}

	function insert($data){
		$this->db->insert('tb_curahhujan',$data);
	}

	function listcurahhujandesa($iddesa){
		$this->db->from('tb_curahhujan');
		$this->db->where('IdDaerah', $iddesa);
		$this->db->order_by('id','desc');
		$this->db->select('*');
		return $this->db->get();
	}

	function read($id){
		$this->db->from('tb_curahhujan');
		$this->db->where('id',$id);
		$this->db->select('*');
		$query=$this->db->get();
		return $query->row();
	}

	function update($data, $id){
		$this->db->where("id",$id);
		$this->db->update("tb_curahhujan",$data);
	}

	function delete($id){
		$this->db->where("id",$id);
		$this->db->delete("tb_curahhujan");
	}

	function getlastrow(){
		$this->db->from('tb_curahhujan');
		$this->db->order_by('id', 'DESC');
		$this->db->limit('1'); 
		$this->db->select('*');
		$query=$this->db->get();
		return $query->row();
	}

	function listcurahhujandesasort($iddesa){
		$this->db->from('tb_curahhujan');
		$this->db->where('IdDaerah', $iddesa);
		$this->db->order_by('CurahHujan','asc');
		$this->db->select('*');
		return $this->db->get();
	}

	function listcurahhujandesawithrange($iddesa, $min, $max){
		$this->db->from('tb_curahhujan');
		$this->db->where('IdDaerah', $iddesa);
		$this->db->where('CurahHujan >', $min);
		$this->db->where('CurahHujan <', $max);
		$this->db->order_by('id','asc');
		$this->db->select('*');
		return $this->db->get();
	}

	function listsuhudesawithrange($iddesa, $min, $max){
		$this->db->from('tb_curahhujan');
		$this->db->where('IdDaerah', $iddesa);
		$this->db->where('Suhu >', $min);
		$this->db->where('Suhu <', $max);
		$this->db->order_by('id','asc');
		$this->db->select('*');
		return $this->db->get();
	}

	function gettahun($iddesa){
		$this->db->from('tb_curahhujan');
		$this->db->where('IdDaerah', $iddesa);
		$this->db->order_by('id','desc');
		$this->db->select('*');
		$query = $this->db->get();
		$ret = $query->row();
		return $ret->Tahun;
	}

	function counttimeseries($iddesa, $tahun){
		$this->db->select('COUNT(Id) as Total');
		$this->db->from('tb_curahhujan');
		$this->db->where('IdDaerah', $iddesa);
		$this->db->order_by('id','desc');
		$query = $this->db->get();
		$ret = $query->row();
		return $ret->Total;
	}
}
?>