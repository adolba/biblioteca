<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Serie extends CI_Controller {

	public function getSeries()
	{	
		$this->load->helper('url');
		$this->load->model('Serie_model');
      	header("Access-Control-Allow-Headers: *");
      	header("Access-Control-Allow-Origin: *");
        $data = $this->Serie_model->getSeries();
        echo json_encode($data);
	}

	public function getSerieById($id){
		$this->load->helper('url');
		$this->load->model('Serie_model');
      	header("Access-Control-Allow-Headers: *");
      	header("Access-Control-Allow-Origin: *");
		$data = $this->Serie_model->getSerieById($id);
		echo json_encode($data);
	}
  
  	public function getSeriesByGenero($genero){
		$this->load->helper('url');
		$this->load->model('Serie_model');
      	header("Access-Control-Allow-Headers: *");
      	header("Access-Control-Allow-Origin: *");
		$data = $this->Serie_model->getSerieByGenero($genero);
		echo json_encode($data);
	}

	public function getSerieByUser($username){
		$this->load->helper('url');
		$this->load->model('Serie_model');
      	header("Access-Control-Allow-Headers: *");
      	header("Access-Control-Allow-Origin: *");
		$data = $this->Serie_model->getSerieByUser($username);
		echo json_encode($data);
	}
  
  	public function getSeriesPorFecha()
	{	
		$this->load->helper('url');
		$this->load->model('Serie_model');
      	header("Access-Control-Allow-Headers: *");
      	header("Access-Control-Allow-Origin: *");
        $data = $this->Serie_model->getSeriesPorFecha();
        echo json_encode($data);
	}
  
    public function getSeriePendienteByUser($username){
          $this->load->helper('url');
          $this->load->model('Serie_model');
     	  header("Access-Control-Allow-Headers: *");
      	  header("Access-Control-Allow-Origin: *");
          $data = $this->Serie_model->getSeriePendienteByUser($username);
          echo json_encode($data);
    }

	public function InsertSerie(){
		$this->load->helper('url');
		$this->load->model('Serie_model'); 
		$this->load->model('Genero_model');
      	header("Access-Control-Allow-Headers: *");
      	header("Access-Control-Allow-Origin: *");
		$request = json_decode (file_get_contents ('php://input'), TRUE);
		print_r($request);
		$id_genero = $this->Genero_model->getGeneroByName($request['genero']);
		print_r($id_genero);
		$datos = array(
			'nombre' => $request['nombre'],	
			'resumen' => $request['resumen'],
			'fecha' => $request['fecha'],
			'capitulos' => $request['duracion'],
			'id_genero' => $id_genero[0]->id_genero,
			'img' => $request['portada'],		
		);
		$this->Serie_model->InsertSerie($datos);
	}

	public function eliminarSerie(){
		$this->load->helper('url');
		$this->load->model('Serie_model');
      	header("Access-Control-Allow-Headers: *");
      	header("Access-Control-Allow-Origin: *");
		$request = json_decode (file_get_contents ('php://input'), TRUE);
		print_r($request);
		$this->Serie_model->EliminarSerie($request['id']);
	}

	public function MarcarVisto(){
		$this->load->helper('url');
		$this->load->model('Serie_model');
		$this->load->model('User_model');
      	header("Access-Control-Allow-Headers: *");
      	header("Access-Control-Allow-Origin: *");
		$request = json_decode (file_get_contents ('php://input'), TRUE);
		$data = $this->User_model->CheckReg($request['usuario']);
		if($data){
		  $id_usuario = $this->User_model->getIdUsuario($request['usuario']);
	
		  $datos = array(
			'id_usuario' => $id_usuario[0]->id_usuario,
			'id_serie' => $request['id_serie'],			
		  );
		  $this->Serie_model->MarcarVisto($datos);
		}else{
		  echo 0;
		} 
			
	  }

	  public function CalificarSerie(){
		$this->load->helper('url');
		$this->load->model('Serie_model'); 
		$this->load->model('User_model');
        header("Access-Control-Allow-Headers: *");
        header("Access-Control-Allow-Origin: *");
		$request = json_decode (file_get_contents ('php://input'), TRUE);
		$data = $this->User_model->getIdUsuario($request['usuario']);
		$check  = array(
			'id_serie' => $request['id_serie'],	
			'id_usuario' => $data[0]->id_usuario,	
		);
		$datos = array(
			'id_serie' => $request['id_serie'],	
			'id_usuario' => $data[0]->id_usuario,
			'calificacion' => $request['valor'],	
		);
		$info = $this->Serie_model->CheckSerieCalificada($check);
		if($info){
			$this->Serie_model->EliminarCalificacion($check);
			$this->Serie_model->CalificarSerie($datos);
		}else{
			$this->Serie_model->CalificarSerie($datos);
		}
		//calcular calificacion total de la peli
		$calificaciones = $this->Serie_model->getCalificacionById($request['id_serie']);
		$cont = 0;
		$suma = 0;
		foreach ($calificaciones as $calificacion) {
			$suma += $calificacion->calificacion;
			$cont++;			
		}
		$total = array(
			'calificacion' => $suma/$cont,	
		);
		$this->Serie_model->InsertCalificacionTotal($request['id_serie'],$total);
		
	}

	  public function MarcarPendiente(){
		$this->load->helper('url');
		$this->load->model('Serie_model');
		$this->load->model('User_model');
        header("Access-Control-Allow-Headers: *");
        header("Access-Control-Allow-Origin: *");
		$request = json_decode (file_get_contents ('php://input'), TRUE);
		$data = $this->User_model->CheckReg($request['usuario']);
		if($data){
		  $id_usuario = $this->User_model->getIdUsuario($request['usuario']);
	
		  $datos = array(
			'id_usuario' => $id_usuario[0]->id_usuario,
			'id_serie' => $request['id_serie'],			
		  );
		  $this->Serie_model->MarcarPendiente($datos);
		}else{
		  echo 0;
		} 
			
	  }
	
	  public function CheckSerieVista(){
		$this->load->helper('url');
		$this->load->model('Serie_model');
		$this->load->model('User_model');
        header("Access-Control-Allow-Headers: *");
        header("Access-Control-Allow-Origin: *");
		$request = json_decode (file_get_contents ('php://input'), TRUE);
		$data = $this->User_model->CheckReg($request['usuario']);
		if($data){
		  $id_usuario = $this->User_model->getIdUsuario($request['usuario']);
	
		  $datos = array(
			'id_usuario' => $id_usuario[0]->id_usuario,
			'id_serie' => $request['id_serie'],			
		  );
		  $result = $this->Serie_model->CheckSerieVista($datos);

		  echo json_encode($result);

		}else{
		  echo 0;
		} 
			
	  }

	  public function CheckSeriePendiente(){
		$this->load->helper('url');
		$this->load->model('Serie_model');
		$this->load->model('User_model');
        header("Access-Control-Allow-Headers: *");
        header("Access-Control-Allow-Origin: *");
		$request = json_decode (file_get_contents ('php://input'), TRUE);
		$data = $this->User_model->CheckReg($request['usuario']);
		if($data){
		  $id_usuario = $this->User_model->getIdUsuario($request['usuario']);
	
		  $datos = array(
			'id_usuario' => $id_usuario[0]->id_usuario,
			'id_serie' => $request['id_serie'],			
		  );
		  $result = $this->Serie_model->CheckSeriePendiente($datos);

		  echo json_encode($result);

		}else{
		  echo 0;
		} 
			
	  }

	  public function DeleteSerieVista(){
		$this->load->helper('url');
		$this->load->model('Serie_model');
		$this->load->model('User_model');
        header("Access-Control-Allow-Headers: *");
        header("Access-Control-Allow-Origin: *");
		$request = json_decode (file_get_contents ('php://input'), TRUE);
		$data = $this->User_model->CheckReg($request['usuario']);
		if($data){
		  $id_usuario = $this->User_model->getIdUsuario($request['usuario']);
	
		  $datos = array(
			'id_usuario' => $id_usuario[0]->id_usuario,
			'id_serie' => $request['id_serie'],			
		  );
		  $this->Serie_model->DeleteSerieVista($datos);

		}else{
		  echo 0;
		} 
	  }

	  public function DeleteSeriePendiente(){
		$this->load->helper('url');
		$this->load->model('Serie_model');
		$this->load->model('User_model');
        header("Access-Control-Allow-Headers: *");
        header("Access-Control-Allow-Origin: *");
		$request = json_decode (file_get_contents ('php://input'), TRUE);
		$data = $this->User_model->CheckReg($request['usuario']);
		if($data){
		  $id_usuario = $this->User_model->getIdUsuario($request['usuario']);
	
		  $datos = array(
			'id_usuario' => $id_usuario[0]->id_usuario,
			'id_serie' => $request['id_serie'],			
		  );
		  $this->Serie_model->DeleteSeriePendiente($datos);

		}else{
		  echo 0;
		} 
	  }
}