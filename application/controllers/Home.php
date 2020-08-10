<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	public $data_view;

	public function __construct() {
		parent::__construct();
		$this->load->library("assets", array(
			'header' => array('titulo' => "Página Principal", 'subtitulo' => null),
			'css' => 'application',
			'libs_js' => '',
			'js' => ''
		));
		$this->stringController = "home";
	}

	public function index() {
        $this->data_view["conteudo"] = 'conteudo_aqui';
        //print_r($this->data_view);
		$this->loadView($this->data_view);
	}

	public function funcao() {
		$this->loadView('home');
	}

	public function informacao($tipo = false){
		if(!$tipo){
			$tipo = 'REMOTE_ADDR';
		}
		echo getInfoServerAmbience($tipo);
	}
}
