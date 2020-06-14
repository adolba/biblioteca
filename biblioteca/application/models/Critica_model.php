<?php
class Critica_Model extends CI_Model {  
	

    function getCriticaByIdDePelicula($id){
        $query = $this->db->select('id_critica,Mensaje,fecha,usuario')
               ->from('critica_pelicula')
               ->join('usuario','critica_pelicula.id_usuario = usuario.id_usuario','inner')
               ->order_by('fecha', "desc")
          	   ->where('id_pelicula', $id)
               ->get();

      return $query->result();
    }

    function getCriticaByIdDeSerie($id){
      $query = $this->db->select('id_critica,Mensaje,fecha,usuario')
             ->from('critica_serie')
             ->join('usuario','critica_serie.id_usuario = usuario.id_usuario','inner')
             ->order_by('fecha', "desc")
             ->where('id_serie', $id)
             ->get();

    return $query->result();
  }

  public function insertarComentarioPeli($datos){
		return $this->db->insert('critica_pelicula', $datos);
  }
  
  public function insertarComentarioSerie($datos){
		return $this->db->insert('critica_serie', $datos);
	}

}
?>