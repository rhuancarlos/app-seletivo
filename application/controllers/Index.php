<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends MY_Controller {

	public $data_view;

	public function __construct() {
		parent::__construct();
		$this->load->library("assets", array(
			'header' => array('titulo' => "Página Principal", 'subtitulo' => null),
			'css' => 'agendamentoStyle',
			'libs_js' => '',
			'js' => 'agendamento/controllers/AgendamentoController|agendamento/services/AgendamentoService'
		));
		$this->stringController = "index";
	}

	public function index() {
        $this->data_view["elementos_pagina"] = array('titulo' => 'Agendamento de Culto', 'sub_titulo' => '"Melhor um dia na Tua Casa, do que mil em outro lugar". - Salmos 84:10');
        #print_r($this->data_view);
		$this->loadView($this->data_view);
	}
}
