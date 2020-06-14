<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Genero extends CI_Controller {

	public function getGeneros()
	{	
		$this->load->helper('url');
		$this->load->model('Genero_model');
      	header("Access-Control-Allow-Headers: *");
     	header("Access-Control-Allow-Origin: *");
        $data = $this->Genero_model->getGeneros();
        echo json_encode($data);
	}
	public function getGeneroById($id){
		$this->load->helper('url');
		$this->load->model('Genero_model');
      	header("Access-Control-Allow-Headers: *");
      	header("Access-Control-Allow-Origin: *");
		$data = $this->Genero_model->getGeneroById($id);
		echo json_encode($data);
	}
	
	public function InsertGenero(){
		$this->load->helper('url');
		$this->load->model('Genero_model');
      	header("Access-Control-Allow-Headers: *");
      	header("Access-Control-Allow-Origin: *");
		$request = json_decode (file_get_contents ('php://input'), TRUE);
      	print_r($request);
		$datos = array(
			'genero' => $request['genero'],			
		  );
		$this->Genero_model->InsertGenero($datos);
	}

	public function EliminarGenero(){
		$this->load->helper('url');
		$this->load->model('Genero_model');
      	header("Access-Control-Allow-Headers: *");
      	header("Access-Control-Allow-Origin: *");
		$request = json_decode (file_get_contents ('php://input'), TRUE);
		$this->Genero_model->EliminarGenero($request['id']);
	}
}