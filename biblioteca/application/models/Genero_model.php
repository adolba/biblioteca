<?php
class Genero_model extends CI_Model {  
	
    function getGeneros(){

        $query = $this->db->select('*')
               ->from('genero')
               ->get();

      return $query->result();
    }

    function getGeneroById($id){
        $query = $this->db->select('*')
               ->from('genero')
               ->where('id', $id)
               ->get();

      return $query->result();
    }

    function getGeneroByName($name){
      $query = $this->db->select('*')
             ->from('genero')
             ->where('genero', $name)
             ->get();

    return $query->result();
  }

    public function InsertGenero($datos){
      return $this->db->insert('genero', $datos);
    }

    public function EliminarGenero($id){
      $query = $this->db->from('genero')
             ->where('id_genero', $id);
      
      return $query->delete();
    }
}
?>