<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends MY_Controller {

	public $data_view;
	private $valorOfertaMin = 50;
	public function __construct() {
		parent::__construct();
		$this->load->library("assets", array(
			'header' => array('titulo' => "Página Principal", 'subtitulo' => null),
			'css' => 'agendamentoStyle',
			'libs_js' => '',
			'js' => 'login/LoginController|login/LoginService|configValue'
		));
		$this->stringController = "index";
		$this->load->helper('financeiro');
	}

	public function index() {
		$dados_pagina = $this->getElementosPagina();
		$this->data_view["elementos_pagina"] = array(
			'titulo' => 'INSCRIÇÃO TESTE SELETIVO', 
			'sub_titulo' => null,
			'conteudoStages' => $dados_pagina
		);
		$this->loadView($this->data_view);
	}

	private function getElementosPagina() {
		$dados['stage2']['serie'] = array(
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
			'3a' => '3º ano do Ens. Médio');
		$dados['myData']['title'] = "Meus Dados";
		return $dados;	
	}						
}
							