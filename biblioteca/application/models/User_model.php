<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {

	public function login($user, $password){
		$query = $this->db->select("*")
		->from("usuario")
		->where("usuario", $user)
		->where("password", $password)
		->get();
		if($query->num_rows() === 1)
		{
			return $query->row();
		}
		return false;
	}

	public function CheckReg($user){
		$query = $this->db->select("usuario")
		->from("usuario")
		->where("usuario", $user)
		->get();
		if($query->num_rows() === 1)
		{
			return $query->row();
		}
		return false;
	}

	public function Registrar($datos){
		return $this->db->insert('usuario', $datos);
	}

	public function checkUser($user, $pass){
		$query = $this->db->limit(1)->get_where("usuario", array("usuario" => $user,"password"=>$pass));
		return $query->num_rows() === 1;
	}

	function getIdUsuario($user){

        $query = $this->db->select('id_usuario')
               ->from('usuario')
			   ->where("usuario", $user)
               ->get();
      return $query->result();
    }
}
