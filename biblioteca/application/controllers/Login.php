<?php
class Login extends CI_Controller {

    public function getUsuario(){

        $this->load->helper('url');
		$this->load->model('User_model');
		$this->load->library('JWT');
		$COMSUMER_SECRET ='xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
		$COMSUMER_TTL ='86400';
     	header("Access-Control-Allow-Headers: *");
      	header("Access-Control-Allow-Origin: *");
		$request = json_decode (file_get_contents ('php://input'), TRUE);
      	//print_r($request);
		$data = $this->User_model->login($request['user'],$request['password']);	
        
		if($data){
			$usuario = $this->User_model->login($request['user'],$request['password']);
			$usuario = $this->User_model->login('admin','admin');
			$clave = $this->jwt->encode(array(
				'userId' => $usuario->id_usuario,
				'issuedAt' => date(DATE_ISO8601, strtotime('now')),
				'ttl' => $COMSUMER_TTL
			),$COMSUMER_SECRET);
			echo $clave;
		}else{
			echo 0;
		}

	}	

	public static function validate($token){
        $this->load->helper('url');
		$this->load->library('JWT');
      	header("Access-Control-Allow-Headers: *");
      	header("Access-Control-Allow-Origin: *");
		$COMSUMER_SECRET ='xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
		return $this->jwt->decode($token,$COMSUMER_SECRET);
	}

	public function Register(){
		$this->load->helper('url');
		$this->load->model('User_model');
      	header("Access-Control-Allow-Headers: *");
      	header("Access-Control-Allow-Origin: *");
		$request = json_decode (file_get_contents ('php://input'), TRUE);
		$data = $this->User_model->CheckReg($request['user']);
		if(!$data){
			$datos = array(
				'usuario' => $request['user'],
				'correo' => $request['correo'],
				'password' => $request['password'],
				'admin' => 0
			);
			$this->User_model->registrar($datos);
		}else{
			echo 0;
		}
	}

	
}



?>
