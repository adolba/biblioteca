<?php
class Pelicula_Model extends CI_Model {  
	
    function getPeliculas(){

        $query = $this->db->select('*')
               ->from('pelicula')
               ->join('genero','pelicula.id_genero = genero.id_genero','inner')
               ->get();
      return $query->result();
    }

    function getPeliculaById($id){
        $query = $this->db->select('*')
               ->from('pelicula')
               ->join('genero','pelicula.id_genero = genero.id_genero','inner')
               ->where('id', $id)
               ->get();

      return $query->result();
    }
  
  	function getPeliculaByGenero($genero){
        $query = $this->db->select('*')
               ->from('pelicula')
               ->join('genero','pelicula.id_genero = genero.id_genero','inner')
               ->where('genero', $genero)
               ->get();

      return $query->result();
    }
  	
  	function getPeliculasPorFecha(){

        $query = $this->db->select('*')
          	   ->LIMIT(3)
               ->from('pelicula')
               ->join('genero','pelicula.id_genero = genero.id_genero','inner')
          	   ->order_by('fecha', "desc")
               ->get();
      return $query->result();
    }
  	
  	public function getPeliLike($name){
    	$query = $this->db->select('*')
               ->from('pelicula')
          	   ->join('genero','pelicula.id_genero = genero.id_genero','inner')
               ->like('nombre',$name,'both')
          	   ->get();
      return $query->result();
    }

    public function InsertPelicula($datos){
      return $this->db->insert('pelicula', $datos);
    }

    public function EliminarPelicula($id){
      $query = $this->db->from('pelicula')
             ->where('id', $id);
      
      return $query->delete();
    }

    function getPeliculaByuser($username){
      $query = $this->db->select('id,nombre,fecha,img')
             ->from('usuario_pelicula')
             ->join('pelicula','usuario_pelicula.id_pelicula = pelicula.id','inner')
             ->join('usuario','usuario_pelicula.id_usuario = usuario.id_usuario','inner')
             ->where('usuario', $username)
             ->get();

      return $query->result();
    }

    function getPeliculaPendienteByuser($username){
      $query = $this->db->select('id,nombre,fecha,img')
             ->from('pelicula_pendiente')
             ->join('pelicula','pelicula_pendiente.id_pelicula = pelicula.id','inner')
             ->join('usuario','pelicula_pendiente.id_usuario = usuario.id_usuario','inner')
             ->where('usuario', $username)
             ->get();

      return $query->result();
    }

//CALIFICACION
    public function CalificarPelicula($datos){
      return $this->db->insert('pelicula_calificacion', $datos);
    }

    public function CheckPeliCalificada($datos){
      $query = $this->db->select('*')
             ->from('pelicula_calificacion')
             ->where($datos)
             ->get();

             if($query->num_rows())
             {
               return True;
             }
             return false;
    }

    public function EliminarCalificacion($datos){
      $query = $this->db->from('pelicula_calificacion')
             ->where($datos);
      
      return $query->delete();
    }

    function getCalificacionById($id){

      $query = $this->db->select('*')
             ->from('pelicula_calificacion')
             ->where('id_pelicula', $id)
             ->get();
    return $query->result();
  }

  public function InsertCalificacionTotal($id, $datos){
      $query = $this->db->where('id', $id);
      
      return $query->update('pelicula', $datos);
  }

//VISTO Y PENDIENTE
    public function MarcarVisto($datos){
      return $this->db->insert('usuario_pelicula', $datos);
    }

    public function MarcarPendiente($datos){
      return $this->db->insert('pelicula_pendiente', $datos);
    }

    public function CheckPeliVista($datos){
      $query = $this->db->select('*')
             ->from('usuario_pelicula')
             ->where($datos)
             ->get();

             if($query->num_rows())
             {
               return True;
             }
             return false;
    }

    public function CheckPeliPendiente($datos){
      $query = $this->db->select('*')
             ->from('pelicula_pendiente')
             ->where($datos)
             ->get();

             if($query->num_rows())
             {
               return True;
             }
             return false;
    }

    public function DeletePeliVista($datos){
      $query = $this->db->from('usuario_pelicula')
             ->where($datos);
      
      return $query->delete();
    }

    public function DeletePeliPendiente($datos){
      $query = $this->db->from('pelicula_pendiente')
             ->where($datos);
      
      return $query->delete();
    }
    
}
?>