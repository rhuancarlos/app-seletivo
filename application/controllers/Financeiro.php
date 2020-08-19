<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Financeiro extends MY_Controller {

	public $data_view;
  private $tabela_id = 0;
  private $tabela_competicao_id = 0;
	private $tabela_fianceiro_id = 0;
	private $metodo;
  
	public function __construct() {
		parent::__construct();
		$this->permissoes->verificaLogado();
		$this->stringController = "financeiro";
		$this->metodo = getNome_Method();
		$this->load->library("assets", array(
			'header' => array(
				'titulo_home' => "Financeiro", 
				'titulo_pagina_cadastro' => "Financeiro", 'subtitulo' => null,
				'titulo_pagina_editar' => "Financeiro", 'subtitulo' => null
			),
			'js' => 'modulos/tarefas_processos/'.$this->metodo.'/'.$this->metodo
		));
		$this->load->model(array('materiais_m','contas_receber_m', 'contas_pagar_m', 'situacao_pagamento_m', 'tipo_documento_m'));
		$this->usuarioAdministrador = $this->rsession->get('usuario_logado')['usuario_administrador'];
		$this->title_page = null;
	}

	public function index() {
		$this->permissoes->verificaAcesso($this->tabela_id, $this->seguranca->dec($this->rsession->get('usuario_logado')['grupo_usuario_id']));
		$this->loadView($this->data_view);
  }
 
	public function getDocumento(){
		header('Content-type: application/json');
		$post = json_decode(file_get_contents('php://input'));
		if(isset($post->documento_id) && (!empty($post->documento_id)) && (!is_numeric($post->documento_id))) {
			$post->documento_id = $this->seguranca->dec($post->documento_id);
			if($post->tipo_lancamento == 'conta_d') {
				$documento = $this->contas_pagar_m->getById($post->documento_id);
				$documento->codigo_conta = $documento->idcontapagar;
				$documento->idcontapagar = $this->seguranca->enc($documento->idcontapagar);
			} else if ($post->tipo_lancamento == 'conta_r') {
				$documento = $this->contas_receber_m->getById($post->documento_id);
				$titular_documento = getDadosParticipante($documento->titular_id);
				$documento->titular_nome = $titular_documento->prt_nomecompleto;
				$documento->codigo_conta = $documento->idcontareceber;
				$documento->idcontareceber = $this->seguranca->enc($documento->idcontareceber);
			}
			if($documento) {
				$documento->situacao_pagamento_id = $this->seguranca->enc($documento->situacao_pagamento_id);
				$documento->tipo_documento_id = $this->seguranca->enc($documento->tipo_documento_id);
				$documento->user_created = $this->seguranca->enc($documento->user_created);
				$documento->vlr_conta = trim($documento->vlr_conta);
				$documento->data_lancamento = date('d/m/Y', strtotime($documento->data_lancamento));
				//$documento->data_lancamento = $documento->data_lancamento;
				print json_encode(array('status' => 'sucesso', 'dados' => $documento));
				exit;
			} else {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Nenhum documento corresponde ao <b>código informado</b>.'));
				exit;
			}
		} else {
			print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Dados inválidos para <b>consulta de documento</b>.'));
			exit;
		}
	}

	/**
	 * Está rotina atuará como insert e update dos registros:
	 * Levando em consideração que:
	 *  - Quando for passando o ID do registro irá fazer o UPDATE.
	 */
	public function financeiroLancamentoConta() {
		header('Content-type: application/json');
    $post = array($this->input->post());
    //debug_array($post);exit;
		foreach ($post as $propriedade) {
			if(strlen($propriedade['conta_descricao']) < 4) {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Descrição inválida ou incompleta.', 'input' => 'lancamento_descricao'));
				exit;
			}

			if(empty($propriedade['conta_tipo'])) {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'O <b>tipo da conta</b> não foi informado.', 'input' => 'conta_tipo'));
				exit;
			}

			if(empty($propriedade['conta_valor'])) {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => '<b>Valor da Conta</b> não informado', 'input' => 'conta_valor'));
				exit;
			}
		}
		$dadosConta = array (
			'descricao' => $post[0]['conta_descricao'],
			'tipo' => $post[0]['conta_tipo'],
			'vlr_conta' => formataValorDB($post[0]['conta_valor']),
			'data_lancamento' => isset($post[0]['data_lancamento']) ? $post[0]['data_lancamento'] : date('Y-m-d'),
			'detalhamento' => isset($post[0]['conta_detalhamento']) ? $post[0]['conta_detalhamento'] : '',
			
			/** Verifica se o form esta passando o tipo de documento, se não, procura no banco pela situação PAGO e seta o id */
			'tipo_documento_id' => !empty($post[0]['conta_tipo_documento']) ? $this->seguranca->dec($post[0]['conta_tipo_documento']) : $this->tipo_documento_m->getTipoDocumento(false, 'FAT')->idtipodocumento,

			/** Verifica se o form esta passando a situação de pagamento, se não, procura no banco pela situação ABERTO e seta o id */
			'situacao_pagamento_id' => isset($post[0]['conta_situacaopagamento']) ? $this->seguranca->dec($post[0]['conta_situacaopagamento']) : $this->situacao_pagamento_m->getSituacaoPagamento(false, 'ABR')->idsituacaopagamento
		);
		// $conta_id = !empty($post[0]['conta_id']) ? $this->seguranca->dec($post[0]['conta_id']) : false;
		// if(!$conta_id) {
			// Faz insert e seta na variavel o 'id' da prova.
			if($post[0]['conta_tipo'] == 'conta_d') {
				unset($dadosConta['tipo']);
				$tipo_lancamento = 'Despesa';
				$IDCONTA = $this->_insertRegistroContaPagar($dadosConta); 
			} else if($post[0]['conta_tipo'] == 'conta_r') {
				unset($dadosConta['tipo']);
				$tipo_lancamento = 'Receita';
				$IDCONTA = $this->_insertRegistroContaReceber($dadosConta); 
			} else { 
				$IDCONTA = false; 
			}

			if($IDCONTA) {
				print json_encode(array('status' => 'sucesso', 'title' => $this->swall_titulo_sucesso, 'tipo' => $this->swall_tipo[1], 'message' => 'Lançamento <b>'.$tipo_lancamento.'</b> feito com sucesso!'));
			} else {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => 'Falha crítica ao salvar registro no banco de dados. Por favor contate a '.DESENVOLVEDOR_SISTEMA_NOME.'!!'));
				exit;
			}
		// } else {
		// 	if($this->_updateRegistro($Cad_ProdutoDados, $material_id)) {
		// 		print json_encode(array('status' => 'sucesso', 'title' => $this->swall_titulo_sucesso, 'tipo' => $this->swall_tipo[1], 'message' => 'Material atualizado com sucesso!', 'close' => $this->swall_timeout['nivel3']));
		// 		exit;
		// 	} else {
		// 		print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => 'Falha crítica ao atualizar registro no banco de dados. Por favor contate a '.DESENVOLVEDOR_SISTEMA_NOME.'!!'));
		// 		exit;
		// 	}
		// }
		exit;
  }

	



	/**
	 * ROTINAS REFERENTE A DESPESAS
	 * --> Lançamentos
	 * --> Pagamentos
	 * --> Cancelamento
	 */
	public function PagamentoDespesa() {
		header('Content-type: application/json');
    $post = array($this->input->post());
		foreach ($post as $propriedade) {
			if(strlen($propriedade['bx_conta_descricao']) < 4) {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Descrição inválida ou incompleta.', 'input' => 'bx_conta_descricao'));
				exit;
			}
			// if(empty($propriedade['bx_conta_datapagamento'])) {
			// 	print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Favor informe a <b>data de pagamento</b>.', 'input' => 'bx_conta_datapagamento'));
			// 	exit;
			// }

			if(!isset($propriedade['bx_conta_paga'])) {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Para finalizar o processo você precisa <b>informar se a conta esta paga</b>, caso contrário seu pagamento não será efetivado.', 'input' => 'bx_conta_paga'));
				exit;
			}
			
		}
		$dadosContaPagamento = array (
			'descricao' => $post[0]['bx_conta_descricao'],
			'detalhamento' => $post[0]['bx_conta_detalhamento'],
			// 'data_pagamento' => formate_date($post[0]['bx_conta_datapagamento']),
			'vlr_pago' => getContaAPagar($this->seguranca->dec($post[0]['bxconta_id']))->vlr_conta,

			/** Verifica se o form esta passando a situação de pagamento, se não, procura no banco pela situação ABERTO e seta o id */
			'situacao_pagamento_id' => isset($post[0]['conta_situacaopagamento']) ? $this->seguranca->dec($post[0]['conta_situacaopagamento']) : $this->situacao_pagamento_m->getSituacaoPagamento(false, 'PAG')->idsituacaopagamento
		);
		$conta_id = !empty($post[0]['bxconta_id']) ? $this->seguranca->dec($post[0]['bxconta_id']) : false;

		if($this->_registraPagamentoDespesa($dadosContaPagamento, $conta_id)) {
			print json_encode(array('status' => true, 'title' => $this->swall_titulo_sucesso, 'tipo' => $this->swall_tipo[1], 'message' => 'Pagamento de <b>despesa#'.$conta_id.'</b> feito com sucesso!', 'close' => $this->swall_timeout['nivel3']));
			exit;
		} else {
			print json_encode(array('status' => false, 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => 'Falha crítica ao atualizar registro(s) no banco de dados. Por favor contate a '.DESENVOLVEDOR_SISTEMA_NOME.'!!'));
			exit;
		}
		exit;
	}
	
	private function _insertRegistroContaPagar($dadosConta){
		if(!$dadosConta) {
			return false;
			exit;
		}
		$dadosConta['created'] = date('Y-m-d H:i:s');
		$dadosConta['user_created'] = $this->seguranca->dec($this->rsession->get('usuario_logado')['id_usuario']);
		
		//INSERT AND RETURN(ID) MATERIAL
		$IDCONTA = $this->contas_pagar_m->_insertRegistro($dadosConta);
		if($IDCONTA) {
			return $IDCONTA;
		}
		return false;
	}

	private function _registraPagamentoDespesa($dadosContaPagamento, $id_despesa) {
		if(!$dadosContaPagamento && !$id_despesa) {
			return false;
			exit;
		}
		//debug_array($dadosContaPagamento);exit;
		$dadosContaPagamento['updated'] = date('Y-m-d H:i:s');
		$dadosContaPagamento['data_pagamento'] = date('Y-m-d H:i:s');
		$dadosContaPagamento['usuario_pagamento'] = $this->seguranca->dec($this->rsession->get('usuario_logado')['id_usuario']);
		return $this->contas_pagar_m->_updateRegistro($dadosContaPagamento, $id_despesa);
	}

	public function cancelamentoPagamentoDespesa() {
		$post = json_decode(file_get_contents('php://input'));
		
		$codigo_documento = isset($post->codigo_documento) ? ((!empty($post->codigo_documento)) ? $post->codigo_documento : false) : false;
		if($codigo_documento) {
			$documento = getContaAPagar($this->seguranca->dec($codigo_documento));
			if(!$documento) {
				print json_encode(array('status' => false, 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Nenhum documento corresponde ao <b>código informado</b>.'));
				exit;
			}

			if($this->_cancelamentoPagamentoDespesa($this->seguranca->dec($codigo_documento), $documento)) {
				print json_encode(array('status' => true, 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[1], 'message' => 'Pagamento cancelado com sucesso.<br><b>N.Documento:</b> '.$this->seguranca->dec($codigo_documento)));
				exit;
			} else {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => 'Falha crítica ao salvar registro no banco de dados. Por favor contate a '.DESENVOLVEDOR_SISTEMA_NOME.'!!'));
				exit;
			}
		}
	}

	private function _cancelamentoPagamentoDespesa($codigo_documento, $documento) {
		$dadosContaCancelamento['updated'] = date('Y-m-d H:i:s');
		$dadosContaCancelamento['data_cancelamento'] = date('Y-m-d H:i:s');
		$dadosContaCancelamento['usuario_cancelamento'] = $this->seguranca->dec($this->rsession->get('usuario_logado')['id_usuario']);
		/** Verifica se o form esta passando a situação de pagamento, se não, procura no banco pela situação CANCELADO e seta o id */
		$dadosContaCancelamento['situacao_pagamento_id'] = $this->situacao_pagamento_m->getSituacaoPagamento(false, 'CAN')->idsituacaopagamento;
		$dadosContaCancelamento['descricao'] = '[pagamento cancelado '.date('d-m-Y H:i:s').'] --> '.$documento->descricao;
		return $this->contas_pagar_m->_updateRegistro($dadosContaCancelamento, $codigo_documento) || false;
	}

	/**
	 * ROTINAS REFERENTE A RECEITAS
	 * -> Lançamento
	 * -> Recebimento
	 * -> Cancelamento 
	 */
	public function RecebimentoConta() {
		header('Content-type: application/json');
    $post = array($this->input->post());

		foreach ($post as $propriedade) {
			if(strlen($propriedade['rcb_conta_descricao']) < 4) {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Descrição inválida ou incompleta.', 'input' => 'rcb_conta_descricao'));
				exit;
			}
			if(!isset($propriedade['rcb_conta_titular_conta']) || (empty($propriedade['rcb_conta_titular_conta']))) {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Por favor informe o <b>titular</b> para esta conta.', 'input' => 'rcb_conta_titular_conta'));
				exit;
			}
			if(!isset($propriedade['rcb_conta_paga'])) {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Para finalizar o processo você precisa <b>informar se a conta esta paga</b>, caso contrário seu pagamento não será efetivado.', 'input' => 'rcb_conta_paga'));
				exit;
			}
			// if(empty($propriedade['bx_conta_datapagamento'])) {
			// 	print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Favor informe a <b>data de pagamento</b>.', 'input' => 'bx_conta_datapagamento'));
			// 	exit;
			// }

			
		}
		$dadosContaRecebimento = array (
			'descricao' => $post[0]['rcb_conta_descricao'],
			'detalhamento' => $post[0]['rcb_conta_detalhamento'],
			'titular_id' => $post[0]['rcb_conta_titular_conta'],
			'vlr_pago' => getContaAReceber($this->seguranca->dec($post[0]['recebeconta_id']))->vlr_conta,
			/** Verifica se o form esta passando a situação de pagamento, se não, procura no banco pela situação PAGO e seta o id */
			'situacao_pagamento_id' => isset($post[0]['conta_situacaopagamento']) ? $this->seguranca->dec($post[0]['conta_situacaopagamento']) : $this->situacao_pagamento_m->getSituacaoPagamento(false, 'PAG')->idsituacaopagamento
		);
		$conta_id = !empty($post[0]['recebeconta_id']) ? $this->seguranca->dec($post[0]['recebeconta_id']) : false;

		if($this->_registraRecebimentoConta($dadosContaRecebimento, $conta_id)) {
			print json_encode(array('status' => true, 'title' => $this->swall_titulo_sucesso, 'tipo' => $this->swall_tipo[1], 'message' => 'Recebimento de <b>conta#'.$conta_id.'</b> feito com sucesso!', 'close' => $this->swall_timeout['nivel3']));
			exit;
		} else {
			print json_encode(array('status' => false, 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => 'Falha crítica ao atualizar registro(s) no banco de dados. Por favor contate a '.DESENVOLVEDOR_SISTEMA_NOME.'!!'));
			exit;
		}
		exit;
	}

	private function _registraRecebimentoConta($dadosContaRecebimento, $id_conta) {
		if(!$dadosContaRecebimento && !$id_conta) {
			return false;
			exit;
		}
		// print_r($dadosContaRecebimento);exit;
		$dadosContaRecebimento['updated'] = date('Y-m-d H:i:s');
		$dadosContaRecebimento['data_pagamento'] = date('Y-m-d H:i:s');
		$dadosContaRecebimento['usuario_recebimento'] = $this->seguranca->dec($this->rsession->get('usuario_logado')['id_usuario']);
		return $this->contas_receber_m->_updateRegistro($dadosContaRecebimento, $id_conta) ? true : false;
	}
	
	private function _insertRegistroContaReceber($dadosConta){ 
		if(!$dadosConta) {
			return false;
			exit;
		}
		$dadosConta['created'] = date('Y-m-d H:i:s');
		$dadosConta['user_created'] = $this->seguranca->dec($this->rsession->get('usuario_logado')['id_usuario']);
		
		//INSERT AND RETURN(ID) MATERIAL
		$IDCONTA = $this->contas_receber_m->_insertRegistro($dadosConta);
		if($IDCONTA) {
			return $IDCONTA;
		}
		return false;
	}

	public function cancelamentoRecebimentoConta() {
		$post = json_decode(file_get_contents('php://input'));
		
		$codigo_documento = isset($post->codigo_documento) ? ((!empty($post->codigo_documento)) ? $post->codigo_documento : false) : false;
		if($codigo_documento) {
			$documento = getContaAReceber($this->seguranca->dec($codigo_documento));
			if(!$documento) {
				print json_encode(array('status' => false, 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Nenhum documento corresponde ao <b>código informado</b>.'));
				exit;
			}

			if($this->_cancelamentoRecebimentoConta($this->seguranca->dec($codigo_documento), $documento)) {
				print json_encode(array('status' => true, 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[1], 'message' => 'Recebimento cancelado com sucesso.<br><b>N.Documento:</b> '.$this->seguranca->dec($codigo_documento)));
				exit;
			} else {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => 'Falha crítica ao salvar registro no banco de dados.<br> Por favor contate a '.DESENVOLVEDOR_SISTEMA_NOME.'!!'));
				exit;
			}
		}
	}

	private function _cancelamentoRecebimentoConta($codigo_documento, $documento) {
		$dadosContaCancelamento['updated'] = date('Y-m-d H:i:s');
		$dadosContaCancelamento['data_cancelamento'] = date('Y-m-d H:i:s');
		$dadosContaCancelamento['usuario_cancelamento'] = $this->seguranca->dec($this->rsession->get('usuario_logado')['id_usuario']);
		/** Verifica se o form esta passando a situação de pagamento, se não, procura no banco pela situação CANCELADO e seta o id */
		$dadosContaCancelamento['situacao_pagamento_id'] = $this->situacao_pagamento_m->getSituacaoPagamento(false, 'CAN')->idsituacaopagamento;
		$dadosContaCancelamento['detalhamento'] = '[recebimento cancelado '.date('d-m-Y H:i:s').'] --> '.$documento->detalhamento;
		return $this->contas_receber_m->_updateRegistro($dadosContaCancelamento, $codigo_documento) || false;
	}
}

  