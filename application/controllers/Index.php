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
			'titulo' => 'INSCRIÇÃO TESTE SELETIVO', 
			'sub_titulo' => null,
			'conteudoStages' => $dados_pagina
		);
		$this->loadView($this->data_view);
	}

	private function getElementosPagina() {
		$dados['stage1']['texto_area_principal'] = '<img src="'.URL_IMAGES_IGREJA.'img_campanha_contruindo_algo_maior.jpeg" style="width: inherit;border-radius: 23px;">';
		
		$dados['stage2']['title'] = "SOBRE VOCÊ";
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
		$dados['stage3']['title'] = "SEU ENDEREÇO";
		$dados['stage3']['texto_area_principal'] = "<p>Nossos cultos serão em duas sessões, escolha a mais ideal. Será uma noite especial.</p>";
		$dados['stage3']['texto_area_qtd_pessoas'] = "<p>Aqui você pode colocar quantas pessoas irão com você ao total, assim facilitamos o agendamento de cadeiras de você e sua Família.</p>";
		$dados['stage4']['tamanhosCamisas'] = array('P','M','G','GG','XGG');
		$dados['stage4']['img_stage_4'] = '<img src="'.URL_IMAGES_IGREJA.'img_campanha_contruindo_algo_maior.jpeg" style="width: 100%;border-radius: 23px;margin-bottom: 30px;">';
		$dados['myData']['title'] = "Meus Dados";
		return $dados;	
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
							