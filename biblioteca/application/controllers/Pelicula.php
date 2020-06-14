<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelicula extends CI_Controller {

	public function getPeliculas()
	{	
		$this->load->helper('url');
		$this->load->model('Pelicula_model');
      	header("Access-Control-Allow-Headers: *");
      	header("Access-Control-Allow-Origin: *");
        $data = $this->Pelicula_model->getPeliculas();
        echo json_encode($data);
	}
	public function getPeliculaById($id){
		$this->load->helper('url');
		$this->load->model('Pelicula_model');
      	header("Access-Control-Allow-Headers: *");
      	header("Access-Control-Allow-Origin: *");
		$data = $this->Pelicula_model->getPeliculaById($id);
		echo json_encode($data);
	}
  
  	public function getPeliculaByGenero($genero){
		$this->load->helper('url');
		$this->load->model('Pelicula_model');
      	header("Access-Control-Allow-Headers: *");
      	header("Access-Control-Allow-Origin: *");
		$data = $this->Pelicula_model->getPeliculaByGenero($genero);
		echo json_encode($data);
	}
  
  	public function getPeliculasPorFecha()
	{	
		$this->load->helper('url');
		$this->load->model('Pelicula_model');
      	header("Access-Control-Allow-Headers: *");
      	header("Access-Control-Allow-Origin: *");
        $data = $this->Pelicula_model->getPeliculasPorFecha();
        echo json_encode($data);
	}
  
  	public function getPeliculaLike($name){
		$this->load->helper('url');
		$this->load->model('Pelicula_model');
      	header("Access-Control-Allow-Headers: *");
      	header("Access-Control-Allow-Origin: *");
		$data = $this->Pelicula_model->getPeliLike($name);
		echo json_encode($data);
	}

	public function getPeliculaByuser($username){
		$this->load->helper('url');
		$this->load->model('Pelicula_model');
      	header("Access-Control-Allow-Headers: *");
      	header("Access-Control-Allow-Origin: *");
		$data = $this->Pelicula_model->getPeliculaByuser($username);
		echo json_encode($data);
	}
    
    public function getPeliculaPendienteByuser($username){
		$this->load->helper('url');
		$this->load->model('Pelicula_model');
        header("Access-Control-Allow-Headers: *");
      	header("Access-Control-Allow-Origin: *");
		$data = $this->Pelicula_model->getPeliculaPendienteByuser($username);
		echo json_encode($data);
	}

	public function CalificarPelicula(){
		$this->load->helper('url');
		$this->load->model('Pelicula_model'); 
		$this->load->model('User_model');
      	header("Access-Control-Allow-Headers: *");
      	header("Access-Control-Allow-Origin: *");
		$request = json_decode (file_get_contents ('php://input'), TRUE);
		$data = $this->User_model->getIdUsuario($request['usuario']);
		$check  = array(
			'id_pelicula' => $request['id_pelicula'],	
			'id_usuario' => $data[0]->id_usuario,	
		);
		$datos = array(
			'id_pelicula' => $request['id_pelicula'],	
			'id_usuario' => $data[0]->id_usuario,
			'calificacion' => $request['valor'],	
		);
		$info = $this->Pelicula_model->CheckPeliCalificada($check);
		if($info){
			$this->Pelicula_model->EliminarCalificacion($check);
			$this->Pelicula_model->CalificarPelicula($datos);
		}else{
			$this->Pelicula_model->CalificarPelicula($datos);
		}
		//calcular calificacion total de la peli
		$calificaciones = $this->Pelicula_model->getCalificacionById($request['id_pelicula']);
		$cont = 0;
		$suma = 0;
		foreach ($calificaciones as $calificacion) {
			$suma += $calificacion->calificacion;
			$cont++;			
		}
		$total = array(
			'calificacion' => $suma/$cont,	
		);
		$this->Pelicula_model->InsertCalificacionTotal($request['id_pelicula'],$total);
		
	}

	public function InsertPeli(){
		$this->load->helper('url');
		$this->load->model('Pelicula_model'); 
		$this->load->model('Genero_model');
      	header("Access-Control-Allow-Headers: *");
      	header("Access-Control-Allow-Origin: *");
		$request = json_decode (file_get_contents ('php://input'), TRUE);
		$id_genero = $this->Genero_model->getGeneroByName($request['genero']);

		$datos = array(
			'nombre' => $request['nombre'],	
			'resumen' => $request['resumen'],
			'fecha' => $request['fecha'],
			'duracion' => $request['duracion'],
			'id_genero' => $id_genero[0]->id_genero,
			'img' => $request['portada'],		
		);
		$this->Pelicula_model->InsertPelicula($datos);
	}

	public function eliminarPelicula(){
		$this->load->helper('url');
		$this->load->model('Pelicula_model');
      	header("Access-Control-Allow-Headers: *");
      	header("Access-Control-Allow-Origin: *");
		$request = json_decode (file_get_contents ('php://input'), TRUE);
		print_r($request);
		$this->Pelicula_model->EliminarPelicula($request['id']);
	}

	public function MarcarVisto(){
		$this->load->helper('url');
		$this->load->model('Pelicula_model');
		$this->load->model('User_model');
      	header("Access-Control-Allow-Headers: *");
      	header("Access-Control-Allow-Origin: *");
		$request = json_decode (file_get_contents ('php://input'), TRUE);
		$data = $this->User_model->CheckReg($request['usuario']);
		if($data){
		  $id_usuario = $this->User_model->getIdUsuario($request['usuario']);
	
		  $datos = array(
			'id_usuario' => $id_usuario[0]->id_usuario,
			'id_pelicula' => $request['id_pelicula'],			
		  );
		  $this->Pelicula_model->MarcarVisto($datos);
		}else{
		  echo 0;
		} 
			
	  }

	  public function MarcarPendiente(){
		$this->load->helper('url');
		$this->load->model('Pelicula_model');
		$this->load->model('User_model');
        header("Access-Control-Allow-Headers: *");
        header("Access-Control-Allow-Origin: *");
		$request = json_decode (file_get_contents ('php://input'), TRUE);
		$data = $this->User_model->CheckReg($request['usuario']);
		if($data){
		  $id_usuario = $this->User_model->getIdUsuario($request['usuario']);
	
		  $datos = array(
			'id_usuario' => $id_usuario[0]->id_usuario,
			'id_pelicula' => $request['id_pelicula'],			
		  );
		  $this->Pelicula_model->MarcarPendiente($datos);
		}else{
		  echo 0;
		} 
			
	  }
	
	  public function CheckPeliVista(){
		$this->load->helper('url');
		$this->load->model('Pelicula_model');
		$this->load->model('User_model');
        header("Access-Control-Allow-Headers: *");
        header("Access-Control-Allow-Origin: *");
		$request = json_decode (file_get_contents ('php://input'), TRUE);
		$data = $this->User_model->CheckReg($request['usuario']);
		if($data){
		  $id_usuario = $this->User_model->getIdUsuario($request['usuario']);
	
		  $datos = array(
			'id_usuario' => $id_usuario[0]->id_usuario,
			'id_pelicula' => $request['id_pelicula'],			
		  );
		  $result = $this->Pelicula_model->CheckPeliVista($datos);

		  echo json_encode($result);

		}else{
		  echo 0;
		} 
			
	  }

	  public function CheckPeliPendiente(){
		$this->load->helper('url');
		$this->load->model('Pelicula_model');
		$this->load->model('User_model');
        header("Access-Control-Allow-Headers: *");
        header("Access-Control-Allow-Origin: *");
		$request = json_decode (file_get_contents ('php://input'), TRUE);
		$data = $this->User_model->CheckReg($request['usuario']);
		if($data){
		  $id_usuario = $this->User_model->getIdUsuario($request['usuario']);
	
		  $datos = array(
			'id_usuario' => $id_usuario[0]->id_usuario,
			'id_pelicula' => $request['id_pelicula'],			
		  );
		  $result = $this->Pelicula_model->CheckPeliPendiente($datos);

		  echo json_encode($result);

		}else{
		  echo 0;
		} 
			
	  }

	  public function DeletePeliVista(){
		$this->load->helper('url');
		$this->load->model('Pelicula_model');
		$this->load->model('User_model');
        header("Access-Control-Allow-Headers: *");
        header("Access-Control-Allow-Origin: *");
		$request = json_decode (file_get_contents ('php://input'), TRUE);
		$data = $this->User_model->CheckReg($request['usuario']);
		if($data){
		  $id_usuario = $this->User_model->getIdUsuario($request['usuario']);
	
		  $datos = array(
			'id_usuario' => $id_usuario[0]->id_usuario,
			'id_pelicula' => $request['id_pelicula'],			
		  );
		  $this->Pelicula_model->DeletePeliVista($datos);

		}else{
		  echo 0;
		} 
	  }

	  public function DeletePeliPendiente(){
		$this->load->helper('url');
		$this->load->model('Pelicula_model');
		$this->load->model('User_model');
        header("Access-Control-Allow-Headers: *");
        header("Access-Control-Allow-Origin: *");
		$request = json_decode (file_get_contents ('php://input'), TRUE);
		$data = $this->User_model->CheckReg($request['usuario']);
		if($data){
		  $id_usuario = $this->User_model->getIdUsuario($request['usuario']);
	
		  $datos = array(
			'id_usuario' => $id_usuario[0]->id_usuario,
			'id_pelicula' => $request['id_pelicula'],			
		  );
		  $this->Pelicula_model->DeletePeliPendiente($datos);

		}else{
		  echo 0;
		} 
	  }
}
