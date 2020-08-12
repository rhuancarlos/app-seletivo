<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends MY_Controller {

	public $data_view;

	public function __construct() {
		parent::__construct();
		$this->load->library("assets", array(
			'header' => array('titulo' => "Página Principal", 'subtitulo' => null),
			'css' => '',
			'libs_js' => '',
			'js' => ''
		));
		$this->stringController = "index";
	}

	public function index() {
        $this->data_view["conteudo"] = 'conteudo_aqui';
        #print_r($this->data_view);
		$this->loadView($this->data_view);
	}
}
