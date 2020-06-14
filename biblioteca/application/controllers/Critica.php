<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Critica extends CI_Controller {

	public function getCriticas()
	{	
		$this->load->helper('url');
		$this->load->model('Critica_model');
      	header("Access-Control-Allow-Headers: *");
      	header("Access-Control-Allow-Origin: *");
        $data = $this->Critica_model->getCriticas();
        echo json_encode($data);
	}

	public function getCriticaByIdDePelicula($id){
		$this->load->helper('url');
		$this->load->model('Critica_model');
      	header("Access-Control-Allow-Headers: *");
      	header("Access-Control-Allow-Origin: *");
		$data = $this->Critica_model->getCriticaByIdDePelicula($id);
		echo json_encode($data);
    }
    
    public function getCriticaByIdDeSerie($id){
		$this->load->helper('url');
		$this->load->model('Critica_model');
      	header("Access-Control-Allow-Headers: *");
      	header("Access-Control-Allow-Origin: *");
		$data = $this->Critica_model->getCriticaByIdDeSerie($id);
		echo json_encode($data);
	}
	
	public function insertComentPelicula(){
		$this->load->helper('url');
		$this->load->model('Critica_model');
		$this->load->model('User_model');
      	header("Access-Control-Allow-Headers: *");
      	header("Access-Control-Allow-Origin: *");
		$request = json_decode (file_get_contents ('php://input'), TRUE);
		$data = $this->User_model->CheckReg($request['usuario']);
		if($data){
			$id_usuario = $this->User_model->getIdUsuario($request['usuario']);

			$datos = array(
				'id_pelicula' => $request['id_pelicula'],
				'id_usuario' => $id_usuario[0]->id_usuario,
				'Mensaje' => $request['mensaje'],
				'fecha' => date('yy-m-d'),
			);
			$this->Critica_model->insertarComentarioPeli($datos);
		}else{
			echo 0;
		} 
        
	}

	public function insertComentSerie(){
		$this->load->helper('url');
		$this->load->model('Critica_model');
		$this->load->model('User_model');
      	header("Access-Control-Allow-Headers: *");
      	header("Access-Control-Allow-Origin: *");
		$request = json_decode (file_get_contents ('php://input'), TRUE);
		$data = $this->User_model->CheckReg($request['usuario']);
		if($data){
			$id_usuario = $this->User_model->getIdUsuario($request['usuario']);

			$datos = array(
				'id_serie' => $request['id_serie'],
				'id_usuario' => $id_usuario[0]->id_usuario,
				'Mensaje' => $request['mensaje'],
				'fecha' => date('yy-m-d'),
			);
			$this->Critica_model->insertarComentarioSerie($datos);
		}else{
			echo 0;
		} 
        
	}
}