<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tarefas_processos extends MY_Controller {

	public $data_view;
  private $tabela_id = 1440;
  private $tabela_competicao_id = 1442;
	private $tabela_fianceiro_id = 1443;
	private $metodo;
  
	public function __construct() {
		parent::__construct();
		$this->permissoes->verificaLogado();
		$this->stringController = "tarefas_processos";
		$this->metodo = getNome_Method();
		$this->load->library("assets", array(
			'header' => array(
				'titulo_home' => "Tarefas e Processos", 
				'titulo_pagina_cadastro' => "Tarefas e Processos", 'subtitulo' => null,
				'titulo_pagina_editar' => "Tarefas e Processos", 'subtitulo' => null
			),
			'js' => 'modulos/tarefas_processos/'.$this->metodo.'/controllers/'.ucfirst($this->metodo).'Controller|modulos/tarefas_processos/'.$this->metodo.'/services/'.$this->metodo.'Service'
			
		));
		$this->load->model(array('materiais_m','situacao_pagamento_m','contas_receber_m', 'contas_pagar_m', 'tipo_documento_m'));
		$this->usuarioAdministrador = $this->rsession->get('usuario_logado')['usuario_administrador'];
		$this->layout_coluna_id     = $this->layout_listagem_id = 1;
		$this->title_page = TRF_PROCESSOS_CABECALHO_PAGINA;
	}

	public function index() {
		$this->permissoes->verificaAcesso($this->tabela_id, $this->seguranca->dec($this->rsession->get('usuario_logado')['grupo_usuario_id']));
		$this->data_view['title_page'] = $this->title_page;
		$this->data_view['titulo_home'] = $this->assets->header['titulo_home'];
		$this->data_view['titulo_home2'] = '';
		$this->data_view['controller'] = $this->stringController;
		$this->data_view['list_table_th'] = $this->cabecalhoListagemTabelas($this->layout_coluna_id);
		$this->data_view['nivel_acoes'] = $this->permissoes->verificaAcesso($this->tabela_id, $this->seguranca->dec($this->rsession->get('usuario_logado')['grupo_usuario_id']));
		$this->loadView($this->data_view);
	}

  public function competicao() {
    $this->permissoes->verificaAcesso($this->tabela_competicao_id, $this->seguranca->dec($this->rsession->get('usuario_logado')['grupo_usuario_id']));
		$this->data_view['title_page'] = TRF_PROCESSOS_COMPETICAO_CABECALHO_PAGINA;
		$this->data_view['titulo_home'] = TRF_PROCESSOS_COMPETICAO_TITULO_HOME;
		$this->data_view['controller'] = $this->stringController;
		$this->data_view['list_table_th'] = $this->cabecalhoListagemTabelas($this->layout_coluna_id);
		$this->data_view['nivel_acoes'] = $this->permissoes->verificaAcesso($this->tabela_competicao_id, $this->seguranca->dec($this->rsession->get('usuario_logado')['grupo_usuario_id']));
    
    $this->overwriteUrlView = VIEW_MODULO_TAREFAS_PROCESSOS_COMPETICAO.'index';
    $this->loadView($this->data_view);
  }

  public function financeiro() {
    $this->permissoes->verificaAcesso($this->tabela_fianceiro_id, $this->seguranca->dec($this->rsession->get('usuario_logado')['grupo_usuario_id']));
		$this->data_view['title_page'] = TRF_PROCESSOS_FINANCEIRO_CABECALHO_PAGINA;
		$this->data_view['titulo_home'] = TRF_PROCESSOS_FINANCEIRO_TITULO_HOME;
		$this->data_view['controller'] = $this->stringController;
		$this->data_view['list_table_th'] = $this->cabecalhoListagemTabelas($this->layout_coluna_id);
		$this->data_view['nivel_acoes'] = $this->permissoes->verificaAcesso($this->tabela_fianceiro_id, $this->seguranca->dec($this->rsession->get('usuario_logado')['grupo_usuario_id']));
		$this->data['situacoes_pagamento'] = $this->situacao_pagamento_m->getAll();
		$this->data['tipo_documento'] = $this->tipo_documento_m->getAll();
    $this->overwriteUrlView = VIEW_MODULO_TAREFAS_PROCESSOS_FINANCEIRO.'index';
    $this->loadView($this->data_view);
  }

	private function cabecalhoListagemTabelas($layout_id) {
		if(empty($layout_id)) return false;

		$table_header = null;
		switch ($layout_id) {
			case '1':
				$table_header.= '<th style="width: auto;">DESCRIÇÃO</th>';
				// $table_header.= '<th style="width: 20px;">D/R</th>';
				$table_header.= '<th style="width: 10%;">VALOR CONTA</th>';
				$table_header.= '<th style="width: 110px;">DT. LANÇAMENTO</th>';
				$table_header.= '<th style="width: 135px;">DT. PGTO/BXA</th>';
				$table_header.= '<th style="width: 15%">AÇÕES</th>';
			break;
		}
		return $table_header;
	}

	public function getListagemGeral() {
		$post = $this->input->post();
		$valueDefault = 25;
		$search = isset($post['search']) ? $post['search']['value'] : false;
		$length = isset($post['length']) ? $post['length'] : $valueDefault;
		$start = isset($post['start']) ? $post['start'] : 0;
		$paramPesquisaAvancada = array(
			'situacao_pagamento' => !empty($post['situacao_pagamento']) ? $this->seguranca->dec($post['situacao_pagamento']) : false,
			'tipo_conta' => !empty($post['tipo_conta']) ? $post['tipo_conta'] : false,
			// 'data' => !empty($post['data']) ? $post['data'] : false
		);
		// debug_array($paramPesquisaAvancada);
		// debug_array($search);

		if(empty($start)) {
			$limite = ((((int) $post['start'] / $length) + 1) * $length);
			$index = $start;
			//echo ($limite.'a');//exit;
		} else {
			$limite = $length;
			$index = $start;
			//echo ($limite.'b');//exit;
		}
		
		$paramLimites = array('limite' => $limite, 'index' => $index);

		switch($post['tipo_conta']){
			case 'conta_d':
				$lancamentos = $this->contas_pagar_m->getAll($paramLimites, $search, $paramPesquisaAvancada);
			break;
			case 'conta_r':
				$lancamentos = $this->contas_receber_m->getAll($paramLimites, $search, $paramPesquisaAvancada);
			break;
		}
		if(!empty($lancamentos)) {
			$listagem = $this->layoutListagemGeral($lancamentos, $this->layout_coluna_id, $search, $post, $paramPesquisaAvancada);
		} else {
			$listagem = false;
		}
		if(!$listagem) {
			print json_encode(array('status' => false, 'data' => array()));
			exit;
		} else {
			print json_encode($listagem);
		}
	}

	private function layoutListagemGeral($dados, $layout_id, $search, $post, $paramPesquisaAvancada) {
		if(empty($layout_id) || empty($dados)) {
			return false;
		}
		
		if($post['tipo_conta'] == 'conta_d') {
			foreach($dados as $r) {
				$data[] = $this->montaDadosCP($layout_id, $r);
			}
			$t = $this->contas_pagar_m->getAllCount($search, $paramPesquisaAvancada);
			return array("recordsTotal" => $t, "recordsFiltered" => $t, "data" => $data, "layout_list" => $layout_id);
			exit;
		}
		
		if($post['tipo_conta'] == 'conta_r') {
			foreach($dados as $r) {
				$data[] = $this->montaDadosCR($layout_id, $r);
			}
			$t = $this->contas_receber_m->getAllCount($search, $paramPesquisaAvancada);
			return array("recordsTotal" => $t, "recordsFiltered" => $t, "data" => $data, "layout_list" => $layout_id);
			exit;
		}
	}

	private function montaDadosCP($layout_id, $dados) {
		if(!isset($dados)) {
			return false;
		}

		$linha = $opcoes_botao = array();
		// $tipo_documento = null;
		// $tipo_documento = getDadosTipoDocumento($dados->tipo_documento_id);
		$iddoc = $this->seguranca->enc($dados->idcontapagar);

		$baixar_cancelar = empty($dados->data_pagamento) ? 
		array(
			'icon' 		=> '<i class="fa fa-circle icon-situacao-pagamento icon-situacao-pendente"></i> ', 
			'title'		=> 'Pendente Pagamento',
			'icon2' 	=> '<i class="fa fa-money icon-situacao-pagamento icon-situacao-pago"> Pagar</i> ', 
			'title2'		=> 'Pagar Conta',
			'link' 		=> '#1', 
			'acao' 		=> 'pagar',
			'tipo_lancamento' => 'conta_d',
			'funcao'	=> 'onclick="realizarPagamento(this)"') : ((empty($dados->data_cancelamento)) ?
			
		array(
			'icon' 		=> '<i class="fa fa-circle icon-situacao-pagamento icon-situacao-pago"></i> ',
			'title'		=> 'Conta Paga em '.formataParaData($dados->data_pagamento), 
			'icon2'		=> '<i class="fa fa-times icon-situacao-pagamento icon-situacao-pendente"> Can.Pgto</i> ', 
			'title2'		=> 'Cancelar Pagamento', 
			'link' 		=> '#2', 
			'acao' 		=> 'pagar', 
			'tipo_lancamento' => 'conta_d',
			'funcao' 	=> 'onclick="cancelarPagamento(this)"') 
			: 
			array(
				'icon' 		=> '<i class="fa fa-circle icon-situacao-pagamento icon-situacao-cancelado"></i> ',
				'title'		=> 'Pagamento cancelado, clique para ver', 
				'icon2'		=> '<i class="icon-feather-eye"></i> ', 
				'title2'		=> 'Pagamento Cancelado', 
				'link' 		=> '#', 
				'acao' 		=> '', 
				'tipo_lancamento' => '',
				'funcao' 	=> 'onclick="alert(\'inDevelopment\')"'));

		$botao_baixar_e_cancelar_conta = '<a style="font-size: 18px; cursor:pointer;"'.$baixar_cancelar['funcao'].' id="'.$iddoc.'" title="'.$baixar_cancelar['title2'] .'" data-acao="'.$this->seguranca->enc($baixar_cancelar['acao']).'" data-tipo_lancamento="'.$baixar_cancelar['tipo_lancamento'].'">'.$baixar_cancelar['icon2'].'</a>'; 

		if($this->usuarioAdministrador) {
			$opcoes_botao[] = '<div class="adjusted-buttons-table">'.$botao_baixar_e_cancelar_conta.'</div>';
		} else {
			$opcoes_botao[] = '<div class="adjusted-buttons-table">'.$baixar_cancelar . '</div>';
		}
		if($layout_id == 1) {
			$linha[$this->stringController.'_descricao']	= '<span title="'.$baixar_cancelar['title'].'">'.$baixar_cancelar['icon'].' <small style="font-size:10px;">('.$dados->idcontapagar.')</small> '.$dados->descricao.'</span>'/*.' <small style="font-size:10px; color: red;">'.$dados->detalhamento.'</small>'*/;
			// $linha[$this->stringController.'_tipo_conta']	= empty($tipo_documento) ? '- -' : $tipo_documento->tipo;
			$linha[$this->stringController.'_valor_conta'] = $dados->vlr_conta;
			$linha[$this->stringController.'_valor_conta'] = formataValorExibicao($dados->vlr_conta);
			$linha[$this->stringController.'_dt_lancamento'] = !empty($dados->data_lancamento) ? formataParaData($dados->data_lancamento) : '--';
			$linha[$this->stringController.'_dt_pagamento'] = !empty($dados->data_pagamento) ? formataParaData($dados->data_pagamento) : '--';
			$linha[$this->stringController.'_botoes'] = is_array($opcoes_botao) ? implode($opcoes_botao) : $opcoes_botao;
		}
		return $linha;
	}

	private function montaDadosCR($layout_id, $dados) {
		if(!isset($dados)) {
			return false;
		}

		$linha = $opcoes_botao = array();
		// $tipo_documento = null;
		// $tipo_documento = getDadosTipoDocumento($dados->tipo_documento_id);
		$iddoc = $this->seguranca->enc($dados->idcontareceber);

		$baixar_cancelar = empty($dados->data_pagamento) ? 
		array(
			'icon' 		=> '<i class="fa fa-circle icon-situacao-pagamento icon-situacao-pendente"></i> ', 
			'title'		=> 'Pendente Recebimento',
			'icon2' 	=> '<i class="fa fa-money icon-situacao-pagamento icon-situacao-pago"> Receber</i> ', 
			'title2'		=> 'Receber Conta',
			'link' 		=> '#1', 
			'acao' 		=> 'receber',
			'tipo_lancamento' => 'conta_r',
			'funcao'	=> 'onclick="recebimentoContas(this)"') : ((empty($dados->data_cancelamento)) ?
			
			array(
				'icon' 		=> '<i class="fa fa-circle icon-situacao-pagamento icon-situacao-pago"></i> ',
				'title'		=> 'Conta Recebida em '.formataParaData($dados->data_pagamento), 
				'icon2'		=> '<i class="fa fa-times icon-situacao-pagamento icon-situacao-pendente"> Can. Recbto</i> ', 
				'title2'		=> 'Cancelar Recebimento', 
				'link' 		=> '#2', 
				'acao' 		=> 'receber',
				'tipo_lancamento' => 'conta_r',
				'funcao' 	=> 'onclick="cancelarRecebimento(this)"') :

				array(
					'icon' 		=> '<i class="fa fa-circle icon-situacao-pagamento icon-situacao-cancelado"></i> ',
					'title'		=> 'Recebimento cancelado, clique para ver', 
					'icon2'		=> '<i class="icon-feather-eye"></i> ', 
					'title2'		=> 'Recebimento Cancelado', 
					'link' 		=> '#', 
					'acao' 		=> '', 
					'tipo_lancamento' => '',
					'funcao' 	=> 'onclick="alert(\'inDevelopment\')"')
			
);

		$botao_baixar_e_cancelar_conta = '<a style="font-size: 18px; cursor:pointer;"'.$baixar_cancelar['funcao'].' id="'.$iddoc.'" title="'.$baixar_cancelar['title2'] .'" data-acao="'.$this->seguranca->enc($baixar_cancelar['acao']).'" data-tipo_lancamento="'.$baixar_cancelar['tipo_lancamento'].'">'.$baixar_cancelar['icon2'].'</a>'; 

		if($this->usuarioAdministrador) {
			$opcoes_botao[] = '<div class="adjusted-buttons-table">'.$botao_baixar_e_cancelar_conta.'</div>';
		} else {
			$opcoes_botao[] = '<div class="adjusted-buttons-table">'.$baixar_cancelar . '</div>';
		}
		if($layout_id == 1) {
			$linha[$this->stringController.'_descricao']	= '<span title="'.$baixar_cancelar['title'].'">'.$baixar_cancelar['icon'].$dados->descricao.'</span>';
			//$linha[$this->stringController.'_tipo_conta']	= empty($tipo_documento) ? '- -' : $tipo_documento->tipo;
			$linha[$this->stringController.'_valor_conta'] = formataValorExibicao($dados->vlr_conta);
			$linha[$this->stringController.'_dt_lancamento'] = !empty($dados->data_lancamento) ? formataParaData($dados->data_lancamento) : '--';
			$linha[$this->stringController.'_dt_pagamento'] = !empty($dados->data_pagamento) ? formataParaData($dados->data_pagamento) : '--';
			$linha[$this->stringController.'_botoes'] = is_array($opcoes_botao) ? implode($opcoes_botao) : $opcoes_botao;
		}
		return $linha;
	}
}
