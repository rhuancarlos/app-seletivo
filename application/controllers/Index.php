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
			'js' => 'agendamento/controllers/AgendamentoController|agendamento/services/AgendamentoService|configValue'
		));
		$this->stringController = "index";
		$this->load->model('Index_m');
	}

	public function index() {
		$dados_pagina = $this->getElementosPagina();
		$this->data_view["elementos_pagina"] = array(
			'titulo' => 'Agendamento de Celebração', 
			'sub_titulo' => '"Melhor um dia na Tua Casa, do que mil em outro lugar". - Salmos 84:10',
			'conteudoStages' => $dados_pagina
		);
		#print_r($this->data_view);
		$this->loadView($this->data_view);
	}

	private function getElementosPagina() {

		// $dados['stage1']['texto_area_principal'] = "<p><strong>Graça e Paz!</strong><br><br>
		// É com imensa alegria que informamos nosso retorno aos cultos presenciais, adequados com todas as medidas de segurança, estamos abertos para adorar livremente o nosso Deus.
		// Como a expectativa está grande para essa CELEBRAÇÃO HISTÓRICA, e pensando no seu conforto e segurança`. <br>Seguiremos com um agendamento para nossos cultos, pois estamos com vagas limitadas devido as medidas de segurança.<br>
		// Assim, juntamente com sua Família estaremos todos reunidos da melhor forma possível.<br><br>
		// Esperamos você e sua Família, estamos com saudades de adorarmos todos juntos como Igreja!</p>";
		$dados['stage1']['texto_area_principal'] = "<p><strong>Graça e Paz!</strong><br><br>
		Estamos a todo vapor em nosso retorno aos cultos presenciais, adequados com todas as medidas de segurança, estamos abertos para adorar livremente o nosso Deus. Pensando no seu conforto e segurança. Seguiremos com um agendamento para nossos cultos, pois estamos com vagas limitadas devido as medidas de segurança.
		Assim, juntamente com sua Família estaremos todos reunidos da melhor forma possível. <b>Esperamos você e sua Família, estamos com saudades de adorarmos todos juntos como Igreja!</b><br><br>
		<b style='color: red;'>Obs: Agora temos agendamento somente no culto das 16h. O culto das 18h está liberado sem agendamento. Avise seus amigos e discípulos.</b>
		</p>";
		


		
		$dados['stage2']['title'] = "SOBRE VOCÊ";
		$dados['stage2']['descendencia'] = array
			(
			'FV' => 'Visitante',
			'F1' => 'Marcos Teodoro e Cristiane',
			'F2' => 'Francisco e Chaguinha',
			'F3' => 'Sued e Jaqueline',
			'F4' => 'Lucivaldo e Célia',
			'F5' => 'Cesar Oliveira e Liliane',
			'F6' => 'Jozafá e Késia',
			'F7' => 'Junior e Raquel',
			'F8' => 'Filho e Jane',
			'F9' => 'Marcos Vieira e Emilene',
			'F10' => 'Aurifran e Ana',
			'F11' => 'Márcio e Jucélia',
			'F12' => 'Aroldo e Raquel');
			$dados['stage3']['title'] = "SOBRE A CELEBRAÇÃO";
			$dados['stage3']['texto_area_principal'] = "<p>Nossos cultos serão em duas sessões, escolha a mais ideal. Será uma noite especial.</p>";
			$dados['stage3']['texto_area_qtd_pessoas'] = "<p>Aqui você pode colocar quantas pessoas irão com você ao total, assim facilitamos o agendamento de cadeiras de você e sua Família.</p>";
			
		return $dados;	
	}
	
}
