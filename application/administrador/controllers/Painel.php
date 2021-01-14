<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Painel extends MY_Controller {
	
	public $data_view;

	public function __construct() {
		parent::__construct();
		$this->load->library("assets", array(
			'header' => array('titulo' => null, 'subtitulo' => null),
			'css' => '',
			'libs_js' => '',
			'js' => ''
		));
		$this->permissoes->verificaLogado();
		$this->stringController = "painel";
		$this->load->model(array("inscricoes_m"));
	}

	public function index() {
		$this->loadView(false, false, false);
	}

	public function getInscricoes() {
		header('Content-type: application/json');
		$dados = $this->inscricoes_m->getInscricoes();
		foreach ($dados as $key => $d) {
			$dados[$key]->created = formataParaData($d->created);
			foreach($this->getListaSeriesEnsino() as $keys => $serie) {
				if($d->serie == $keys) {
					$dados[$key]->serie_descricao_completa = $serie;
				}
			}
		}
		print json_encode(array('status' => true, 'inscricoes' => $dados));exit;
	}

	public function removerItem() {
		header('Content-type: application/json');
		$post = json_decode(file_get_contents('php://input'));
		if(!isset($post->idItem)) {print json_encode(array('status' => false, 'mensagem' => 'Registro Inválido'));exit;}
		if($this->inscricoes_m->_updateRegistro(array('status' => 0, 'updated' => date('Y-m-d H:i:s')), $post->idItem)) {
			print json_encode(array('status' => true));exit;
		}
	}

	public function salvarAlteracoes() {
		header('Content-type: application/json');
		$post = json_decode(file_get_contents('php://input'));
		if(!isset($post)) {print json_encode(array('status' => false, 'mensagem' => 'Registro Inválido'));exit;}
		if($this->inscricoes_m->_updateRegistro(array(
			'nome_completo' => isset($post->nome_completo) ? $post->nome_completo : null,
			'email' => isset($post->email) ? $post->email : null,
			'telefone' => isset($post->telefone) ? $post->telefone : null,
			'colegio_atual' => isset($post->colegio_atual) ? $post->colegio_atual : null,
			'serie' => isset($post->serie) ? $post->serie : null,
			'updated' => date('Y-m-d H:i:s')), 
			$post->idinscricao)) {
			print json_encode(array('status' => true));exit;
		}
	}

	private function getListaSeriesEnsino() {
		return(array(
			'1s' => '1º ano do Ens. Fundamental',
			'2s' => '2º ano do Ens. Fundamental',
			'3s' => '3º ano do Ens. Fundamental',
			'4s' => '4º ano do Ens. Fundamental',
			'5s' => '5º ano do Ens. Fundamental',
			'6s' => '6º ano do Ens. Fundamental',
			'7s' => '7º ano do Ens. Fundamental',
			'8s' => '8º ano do Ens. Fundamental',
			'9s' => '9º ano do Ens. Fundamental',
			'1a' => '1º ano do Ens. Médio',
			'2a' => '2º ano do Ens. Médio',
			'3a' => '3º ano do Ens. Médio'));
		}

		public function getListaCursos(){
			header('Content-type: application/json');
			print json_encode(array('status' => true, 'cursos' => array(
			'1s' => '1º ano do Ens. Fundamental',
			'2s' => '2º ano do Ens. Fundamental',
			'3s' => '3º ano do Ens. Fundamental',
			'4s' => '4º ano do Ens. Fundamental',
			'5s' => '5º ano do Ens. Fundamental',
			'6s' => '6º ano do Ens. Fundamental',
			'7s' => '7º ano do Ens. Fundamental',
			'8s' => '8º ano do Ens. Fundamental',
			'9s' => '9º ano do Ens. Fundamental',
			'1a' => '1º ano do Ens. Médio',
			'2a' => '2º ano do Ens. Médio',
			'3a' => '3º ano do Ens. Médio')));exit;
		}
	
}
