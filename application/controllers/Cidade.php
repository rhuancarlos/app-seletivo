<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

class Cidade extends MY_Controller{
	public $data_view;

	public function __construct() {
		parent::__construct();
		$this->stringController = "cidade";
		$this->load->library("assets", array(
			'header' => array(
				'titulo_home' => "Cidades", 
				'titulo_pagina_cadastro' => "", 
				'subtitulo' => null
			),
			'libs_css' => '',
			'css' => '',
			'libs_js' => '',
			'js' => ''
		));
		$this->load->model(array('estados_m','cidades_m'));
        $this->permissoes->verificaLogado();
    }

	public function getCidadesByEstado(){
		header('Content-Type: application/json');
		try{
			$post = (array) json_decode(file_get_contents('php://input'), true);
			if(!isset($post)) {
				throw new Exception("Dados invalidos para consulta",1);
			} else {
				$estado_id      = isset($post['estado_id']) ? $post['estado_id'] : false;
				$estado_sigla   = isset($post['estado_sigla']) ? $post['estado_sigla'] : false;
				if((!$estado_id) && !$estado_sigla) {
					print json_encode(array('status' => 'falha', 'message' => 'Dados invalidos para consulta'));
					exit;
				} else {
					$cidades = $this->cidades_m->getCidadesByEstado($estado_id, $estado_sigla);
				}
				$retorno = !$cidades ? 
				(array('status' => 'falha', 'message' => 'Nenhum registro encontrado', 'cidades' => 'Não encontrada', 'total_registros' => 0)) : 
				(array('status' => 'sucesso', 'cidades' => $cidades, 'total_registros' => 'Registro(s): '.count($cidades)));
				print json_encode($retorno);
			}
		} catch(Exception $e){
			$return['status']	= 'falha';
			$return['mensagem']	= $e->getMessage();
			echo json_encode($return);
			return;
		}
	}
}