<?php
class Serie_Model extends CI_Model {  
	
    function getSeries(){

        $query = $this->db->select('*')
               ->from('serie')
               ->join('genero','serie.id_genero = genero.id_genero','inner')
               ->get();

      return $query->result();
    }

    function getSerieById($id){
        $query = $this->db->select('*')
               ->from('serie')
               ->join('genero','serie.id_genero = genero.id_genero','inner')
               ->where('id', $id)
               ->get();

      return $query->result();
    }
  
  	function getSerieByGenero($genero){
        $query = $this->db->select('*')
               ->from('serie')
               ->join('genero','serie.id_genero = genero.id_genero','inner')
               ->where('genero', $genero)
               ->get();

      return $query->result();
    }
	
  	function getSeriesPorFecha(){

        $query = $this->db->select('*')
          	   ->LIMIT(3)
               ->from('serie')
               ->join('genero','serie.id_genero = genero.id_genero','inner')
          	   ->order_by('fecha', "desc")
               ->get();

      return $query->result();
    }	
  
    public function InsertSerie($datos){
      return $this->db->insert('serie', $datos);
    }

    public function EliminarSerie($id){
      $query = $this->db->from('serie')
             ->where('id', $id);
      
      return $query->delete();
    }

  function getSerieByUser($username){
    $query = $this->db->select('id,nombre,fecha,img')
           ->from('usuario_serie')
           ->join('serie','usuario_serie.id_serie = serie.id','inner')
           ->join('usuario','usuario_serie.id_usuario = usuario.id_usuario','inner')
           ->where('usuario', $username)
           ->get();
    
    return $query->result();
  }

  function getSeriePendienteByUser($username){
    $query = $this->db->select('id,nombre,fecha,img')
           ->from('serie_pendiente')
           ->join('serie','serie_pendiente.id_serie = serie.id','inner')
           ->join('usuario','serie_pendiente.id_usuario = usuario.id_usuario','inner')
           ->where('usuario', $username)
           ->get();
    
    return $query->result();
  }

//CALIFICACION
  public function CalificarSerie($datos){
    return $this->db->insert('serie_calificacion', $datos);
  }

  public function CheckSerieCalificada($datos){
    $query = $this->db->select('*')
          ->from('serie_calificacion')
          ->where($datos)
          ->get();

          if($query->num_rows())
          {
            return True;
          }
          return false;
  }

  public function EliminarCalificacion($datos){
    $query = $this->db->from('serie_calificacion')
          ->where($datos);
    
    return $query->delete();
  }

  function getCalificacionById($id){

    $query = $this->db->select('*')
          ->from('serie_calificacion')
          ->where('id_serie', $id)
          ->get();
  return $query->result();
  }
  public function InsertCalificacionTotal($id, $datos){
    $query = $this->db->where('id', $id);
    
    return $query->update('serie', $datos);
  }

//Vistos y pendientes
  public function MarcarVisto($datos){
    return $this->db->insert('usuario_serie', $datos);
  }

  public function MarcarPendiente($datos){
    return $this->db->insert('serie_pendiente', $datos);
  }

  public function CheckSerieVista($datos){
    $query = $this->db->select('*')
           ->from('usuario_serie')
           ->where($datos)
           ->get();

           if($query->num_rows())
           {
             return True;
           }
           return false;
  }

  public function CheckSeriePendiente($datos){
    $query = $this->db->select('*')
           ->from('serie_pendiente')
           ->where($datos)
           ->get();

           if($query->num_rows())
           {
             return True;
           }
           return false;
  }

  public function DeleteSerieVista($datos){
    $query = $this->db->from('usuario_serie')
           ->where($datos);
    
    return $query->delete();
  }

  public function DeleteSeriePendiente($datos){
    $query = $this->db->from('serie_pendiente')
           ->where($datos);
    
    return $query->delete();
  }

}