<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Get_dados extends MY_Controller {

	public $data_view;

	public function __construct() {
		parent::__construct();
		$this->permissoes->verificaLogado();
		// $this->usuarioAdministrador = $this->rsession->get('usuario_logado')['usuario_administrador'];
	}

	public function index() {
		header('Content-type: application/json');
		print json_encode(array('status' => false));
		exit;
  }

  public function json(){
		header('Content-type: application/json');
		try{
			$post = $this->input->post();
			$type = (!isset($post['type']) || (!empty($post['type'] ))) ? $post['type'].'_m' : false;
			$method = (!isset($post['method']) || (!empty($post['method']))) ? $post['method'] : false;
			$searchTerm = (!isset($post['searchTerm']) || (!empty($post['searchTerm']))) ? $post['searchTerm'] : false;

			$this->load->model($type);
			//caso a pessoa não tenha digitado um texto, não faz a consulta
			if(!$searchTerm) {print(json_encode(array('status' => false)));exit;}

			//Com base no tipo e metodo enviado no post, será feita a conexão com o model e retornar os dados
			$retorno = $this->$type->$method($searchTerm);
			//só imprime o json_encode se teve resultado
			if(!$retorno) {print(json_encode(array('status' => false)));exit;}

			print json_encode($retorno);
		} catch(Exception $e) {
			print('{}');exit;
		}
  }
    
}