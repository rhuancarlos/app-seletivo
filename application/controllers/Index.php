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
			'js' => 'agendamento/controllers/AgendamentoController|agendamento/services/AgendamentoService|configValue'
		));
		$this->stringController = "index";
		$this->load->model('Index_m');
		$this->load->helper('financeiro');
	}

	public function index() {
		$dados_pagina = $this->getElementosPagina();
		$this->data_view["elementos_pagina"] = array(
			'titulo' => 'Construindo Algo Maior', 
			'sub_titulo' => '"Melhor um dia na Tua Casa, do que mil em outro lugar". - Salmos 84:10',
			'conteudoStages' => $dados_pagina
		);
		$this->loadView($this->data_view);
	}

	private function getElementosPagina() {

		// $dados['stage1']['texto_area_principal'] = "<p><strong>Graça e Paz!</strong><br><br>
		// É com imensa alegria que informamos nosso retorno aos cultos presenciais, adequados com todas as medidas de segurança, estamos abertos para adorar livremente o nosso Deus.
		// Como a expectativa está grande para essa CELEBRAÇÃO HISTÓRICA, e pensando no seu conforto e segurança`. <br>Seguiremos com um agendamento para nossos cultos, pois estamos com vagas limitadas devido as medidas de segurança.<br>
		// Assim, juntamente com sua Família estaremos todos reunidos da melhor forma possível.<br><br>
		// Esperamos você e sua Família, estamos com saudades de adorarmos todos juntos como Igreja!</p>";
		$dados['stage1']['texto_area_principal'] = '<img src="'.URL_IMAGES_IGREJA.'img_campanha_contruindo_algo_maior.jpeg" style="width: inherit;border-radius: 23px;">';
		
		$dados['stage2']['title'] = "SOBRE VOCÊ";
		$dados['stage2']['descendencia'] = array
		(
			'DD' => 'Doador',
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
			'F12' => 'Aroldo e Raquel'
		);
		$dados['stage3']['title'] = "SEU ENDEREÇO";
		$dados['stage3']['texto_area_principal'] = "<p>Nossos cultos serão em duas sessões, escolha a mais ideal. Será uma noite especial.</p>";
		$dados['stage3']['texto_area_qtd_pessoas'] = "<p>Aqui você pode colocar quantas pessoas irão com você ao total, assim facilitamos o agendamento de cadeiras de você e sua Família.</p>";
		$dados['stage4']['tamanhosCamisas'] = array('P','M','G','GG','XGG');
		$dados['stage4']['img_stage_4'] = '<img src="'.URL_IMAGES_IGREJA.'img_campanha_contruindo_algo_maior.jpeg" style="width: 100%;border-radius: 23px;margin-bottom: 30px;">';
		$dados['myData']['title'] = "Meus Dados";
		return $dados;	
	}
					
	public function getDataStages() {
		header('Content-type: application/json');
		$post = json_decode(file_get_contents('php://input'));
		switch($stage = $post->stage) {
			case '4':
				print json_encode ($this->_getDataOfertas($stage));
			break;
		}
	}

	private function _getDataOfertas($stage) {
		if(!$stage) {return false;}
		
		if($stage == 4 ) {
			$dados['name'] = 'stage4';
			$dados['conteudo']['tiposOfertas'] = array(
				array(
					'name' => 'Bronze', 
					'descricao' => 'Você ganhará uma camisa da campanha (Construindo algo maior).', 
					'compromisso' => '10 mensalidades de '.formataValorExibicao($this->valorOfertaMin), 
					'valorOpcao' => $this->seguranca->enc($this->valorOfertaMin), 
					'css' => 'bronze',
					'img' => URL_IMAGES_IGREJA.'img_campanha_brinde_bronze.jpeg'),
				array(
					'name' => 'Prata', 
					'descricao' => 'Você ganhará uma camisa e caneca da campanha (Construindo algo maior).', 
					'compromisso' => '10 mensalidades de '.formataValorExibicao($this->valorOfertaMin*=2), 
					'valorOpcao' => $this->seguranca->enc($this->valorOfertaMin), 
					'css' => 'prata',
					'img' => URL_IMAGES_IGREJA.'img_campanha_brinde_prata.jpeg'),
				array(
					'name' => 'Ouro', 
					'descricao' => 'Você ganhará uma camisa, caneca da campanha (Construindo algo maior) e uma bíblia com a dedicatória pessoal de nosso Ap.Soares.', 
					'compromisso' => '10 mensalidades de '.formataValorExibicao($this->valorOfertaMin+=$this->valorOfertaMin/2), 
					'valorOpcao' => $this->seguranca->enc($this->valorOfertaMin), 
					'css' => 'ouro',
					'img' => URL_IMAGES_IGREJA.'img_campanha_brinde_ouro.jpeg')
				);
		}
		return array('status' => true, 'dados' => $dados);
	}							
}
							