<?php
class MCurahhujan extends CI_Model{
	function __construct()
	{
		parent::__construct();		
	}

	function listcurahhujan(){
		$this->db->from('tb_curahhujan');
		$this->db->join('tb_desa', 'tb_curahhujan.IdDaerah = tb_desa.Id');
		$this->db->order_by('id','desc');
		$this->db->select('tb_curahhujan.Id as Id,tb_curahhujan.CurahHujan as CurahHujan, tb_curahhujan.Suhu as Suhu, tb_curahhujan.Bulan as Bulan, tb_curahhujan.Tahun as Tahun, tb_Desa.NamaDesa as NamaDesa');
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

	function listcurahhujandesasorttest($iddesa, $bulan, $tahun){
		$this->db->from('tb_curahhujan');
		$this->db->where('IdDaerah', $iddesa);
		$this->db->order_by('CurahHujan','asc');
		$this->db->where('Bulan', $bulan);
		$this->db->where('Tahun<', $tahun);
		$this->db->select('*');
		return $this->db->get();
	}

	function listsuhudesatest($iddesa, $bulan, $tahun){
		$this->db->from('tb_curahhujan');
		$this->db->where('IdDaerah', $iddesa);
		$this->db->where('Bulan', $bulan);
		$this->db->where('Tahun<', $tahun);
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

	function listcurahhujandesawithrangetest($iddesa, $min, $max, $bulan, $tahun){
		$this->db->from('tb_curahhujan');
		$this->db->where('IdDaerah', $iddesa);
		$this->db->where('CurahHujan >', $min);
		$this->db->where('CurahHujan <', $max);
		$this->db->where('Bulan', $bulan);
		$this->db->where('Tahun<', $tahun);
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

	function listsuhudesawithrangetest($iddesa, $min, $max, $bulan){
		$this->db->from('tb_curahhujan');
		$this->db->where('IdDaerah', $iddesa);
		$this->db->where('Suhu >', $min);
		$this->db->where('Suhu <', $max);
		$this->db->where('Bulan', $bulan);
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