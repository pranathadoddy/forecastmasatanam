<?php
class muser extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function login($username, $password){
		$this->db->from('tb_admin');
		$this->db->where('username',$username);
		$this->db->where('password', $password);
		$this->db->select('*');

		$query=$this->db->get();
		if($query->num_rows()>0){
			return $query->result();
		}
		else{
			return FALSE;
		}
	}
}
?>