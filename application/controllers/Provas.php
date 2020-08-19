<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Provas extends MY_Controller {

	public $data_view;
	private $tabela_id_c = null;
	private $tabela_id = 1433;
	private $tabela_id_u = null;

	public function __construct() {
		parent::__construct();
		$this->permissoes->verificaLogado();
		$this->stringController = "provas";
		$this->load->library("assets", array(
			'header' => array(
				'titulo_home' => "Provas", 
				'titulo_pagina_cadastro' => "Cadastro de Provas", 'subtitulo' => null,
				'titulo_pagina_editar' => "Atualização de Provas", 'subtitulo' => null
			),
			'js' => 'modulos/prova/provas'
		));
		$this->load->model(array('provas_m'));
		$this->usuarioAdministrador = $this->rsession->get('usuario_logado')['usuario_administrador'];
		$this->layout_coluna_id     = $this->layout_listagem_id = 1;
		$this->title_page = PROVA_CABECALHO_PAGINA;
	}

	public function index() {
		$this->permissoes->verificaAcesso($this->tabela_id, $this->seguranca->dec($this->rsession->get('usuario_logado')['grupo_usuario_id']));
		$this->data_view['title_page'] = $this->title_page;
		$this->data_view['titulo_home'] = $this->assets->header['titulo_home'];
		$this->data_view['titulo_home2'] = '';
		$this->data_view['controller'] = $this->stringController;
		$this->data_view['provas'] = $this->provas_m->getAll();
		$this->data_view['list_table_th'] = $this->cabecalhoListagemTabelas($this->layout_coluna_id);
		$this->data_view['nivel_acoes'] = $this->permissoes->verificaAcesso($this->tabela_id, $this->seguranca->dec($this->rsession->get('usuario_logado')['grupo_usuario_id']));
		$this->loadView($this->data_view);
	}

	private function cabecalhoListagemTabelas($layout_id) {
		if(empty($layout_id)) return false;

		$table_header = null;
		switch ($layout_id) {
			case '1':
				$table_header.= '<th style="width: 82px;">CÓDIGO</th>';
				$table_header.= '<th style="width: auto;">DESCRIÇÃO</th>';
				$table_header.= '<th style="width: 90px;">AÇÕES</th>';
			break;
		}
		return $table_header;
	}

	/**
	 * Está rotina atuará como insert e update dos registros:
	 * Levando em consideração que:
	 *  - Quando for passando o ID do registro irá fazer o UPDATE.
	 */
	public function salvarProva() {
		header('Content-type: application/json');
		$post = array($this->input->post());
		$dados_DataBase = array();
		foreach ($post as $propriedade) {
			if(strlen($propriedade['prova_descricao']) < 2) {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Descrição inválida ou incompleta.', 'input' => 'prova_descricao'));
				exit;
			}

			if(empty($propriedade['prova_tipo'])) {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Falta informar o tipo de prova', 'input' => 'prova_tipo'));
				exit;
			}

			if(empty($propriedade['prova_qtd_pontos'])) {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Falta a quantidade de pontos desta prova', 'input' => 'prova_qtd_pontos'));
				exit;
			}
		}
		$dados_DataBase = array (
			'descricao' => $post[0]['prova_descricao'],
			'detalhamento' => $post[0]['prova_detalhamento'],
			'tipo_disputa' => $post[0]['prova_tipo'],
			'qtd_pontos' => $post[0]['prova_qtd_pontos'],
			'status' => isset($post[0]['prova_status']) ? $post[0]['prova_status'] : false
		);

		$prova_id = !empty($post[0]['prova_id']) ? $this->seguranca->dec($post[0]['prova_id']) : false;
		if(!$prova_id) {
			// Faz insert e seta na variavel o 'id' da prova.
			$IDPROVA = $this->_insertRegistro($dados_DataBase);
			if($IDPROVA) {
				print json_encode(array('status' => 'sucesso', 'title' => $this->swall_titulo_sucesso, 'tipo' => $this->swall_tipo[1], 'message' => 'Prova registrada com sucesso!<br><b>Código:</b> '.$IDPROVA));
			} else {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => 'Falha crítica ao salvar registro no banco de dados. Por favor contate a '.DESENVOLVEDOR_SISTEMA_NOME.'!!'));
				exit;
			}
		} else {
			if($this->_updateRegistro($dados_DataBase, $prova_id)) {
				print json_encode(array('status' => 'sucesso', 'title' => $this->swall_titulo_sucesso, 'tipo' => $this->swall_tipo[1], 'message' => 'Prova atualizada com sucesso!', 'close' => $this->swall_timeout['nivel3']));
				exit;
			}
		}
		exit;
	}

	public function getListagemGeral() {
		$post = $this->input->post();
		$valueDefault = 25;
		$tipoDados  = array('ativo', 'inativo', 'removido');
		$search = isset($post['search']) ? $post['search']['value'] : false;
		$length = isset($post['length']) ? $post['length'] : $valueDefault;
		$start = isset($post['start']) ? $post['start'] : 0;
		if(empty($start)) {
			$limite = ((((int) $post['start'] / $length) + 1) * $length);
			$index = $start;
			//echo ($limite.'a');//exit;
		} else {
			$limite = $length;
			$index = 0;
			//echo ($limite.'b');//exit;
		}
		$filtro_prova = isset($post['filtro_prova']) ? $post['filtro_prova'] : false;
		
		$paramLimites = array('limite' => $limite, 'index' => $index);

		$paramPesquisaAvancada = array("filtro_prova" => $filtro_prova);
		$provas = $this->provas_m->getAll($paramLimites, $search, $paramPesquisaAvancada);
		
		$listagem = $this->layoutListagemGeralProvas($provas, $this->layout_coluna_id, $search, $paramPesquisaAvancada);
		if(!$listagem) {
			print json_encode(array('status' => false, 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Nenhum dado encontrado'));
			exit;
		} else {
			print json_encode($listagem);
		}
	}

	private function layoutListagemGeralProvas($dados, $layout_id, $search, $paramPesquisaAvancada) {
		$ci	=& get_instance();
		if(empty($layout_id) || empty($dados)) {
			return false;
		}
		foreach($dados as $r) {
			$data[] = $this->montaDadosLayout($layout_id, $r);
		}
		$t = $ci->provas_m->getAllCount($search, $paramPesquisaAvancada);
		return array("recordsTotal" => $t, "recordsFiltered" => $t, "data" => $data, "layout_list" => $layout_id);
	}

	private function montaDadosLayout($layout_id, $dados) {
		if(!isset($dados)) {
			return false;
		}

		$linha = $opcoes_botao = array();
		$ativa_inativa = $dados->status ? 
		array('icon' => '<i class="fa fa-times icon-inativar "></i></a>', 'link' => '#1', 'title' => 'Desativar', 'acao' => 'inativar') : 
		array('icon' =>'<i class="fa fa-check icon-ativar"></i></a>', 'link' => '#2', 'title' => 'Ativar', 'acao' => 'ativar');
		
		//$botao_alterar_dados = '<a href="'. base_url('prova/editar/' . $this->seguranca->enc($dados->idprova)) . '" title="Editar registro: '.$dados->idprova.'" class="icons-size-2"> <i class="icon-feather-edit"></i></a>';
		
		$botao_alterar_dados = '<a onclick="editarRegistro(this)" id="'. $this->seguranca->enc($dados->idprova).' title="Atualizar" class="icons-size-2"><i class="icon-feather-edit icons-size-2"></i></a>';

		$botao_ativa_inativa = '<a class="icons-size-2" onclick="mudarStatus(this)" id="'.$this->seguranca->enc($dados->idprova).'" title="'.$ativa_inativa['title'] .'" 
		data-value="'.$this->seguranca->enc($ativa_inativa['acao']).'">'.$ativa_inativa['icon'].'</a>'; 

		if($this->usuarioAdministrador) {
				$opcoes_botao[] = '<div style="margin:5px; text-align: left !important;">'.$botao_ativa_inativa.'&nbsp;'.'&nbsp;'.$botao_alterar_dados . '</div>';
			} else {
				$opcoes_botao[] = '<div style="margin:5px; text-align: left !important;">'.$botao_alterar_dados . '</div>';
		}

		if($layout_id == 1) {
			$linha[$this->stringController.'_codigo']			= !empty($dados->codigo) ? strtoupper($dados->codigo) : '--';
			$linha[$this->stringController.'_descricao']	= $dados->descricao;
			$linha[$this->stringController.'_botoes']			= is_array($opcoes_botao) ? implode($opcoes_botao) : $opcoes_botao;
		}
		return $linha;
	}

	private function _insertRegistro($dados_DataBase){
		if(!$dados_DataBase) {
			return false;
			exit;
		}
		$dados_DataBase['created'] = date('Y-m-d H:i:s');
		$dados_DataBase['usuario_created'] = $this->seguranca->dec($this->rsession->get('usuario_logado')['id_usuario']);
		$IDPROVA = $this->provas_m->_insertRegistro($dados_DataBase);
		return (!$IDPROVA) ? false : $IDPROVA;
	}

	private function _updateRegistro($dados_DataBase, $prova_id){
		if(!$dados_DataBase) {
			return false;
			exit;
		}
		$dados_DataBase['modification'] = date('Y-m-d H:i:s');
		$dados_DataBase['usuario_modification'] = $this->seguranca->dec($this->rsession->get('usuario_logado')['id_usuario']);
		return $this->provas_m->_updateRegistro($dados_DataBase, $prova_id) || false;
	}
	
	public function getProva() {
		$post = json_decode(file_get_contents('php://input'));
		$prova_id = isset($post->prova_id) ?  intval($this->seguranca->dec($post->prova_id)) : false;
		if(isset($prova_id) && is_integer($prova_id)) {
			$dados_prova = $this->provas_m->getProva($prova_id);
			if(!empty($dados_prova)) {
				$dados_prova->idprova = $this->seguranca->enc($dados_prova->idprova);
				$dados_prova->usuario_created = $this->seguranca->enc($dados_prova->usuario_created);
				$dados_prova->codigo = strtoupper($dados_prova->codigo);
				print json_encode(array('status' => 'sucesso', 'dados' => $dados_prova));exit;
			} else {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => 'Não foi possivel encontrar nenhum registro. Verifique e tente novamente'));
				exit;
			}
		} else {
			print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => ' Parametros inválido, verifique e tente novamente'));
			exit;
		}
	}


	public function mudarStatus() {
		$post = json_decode(file_get_contents('php://input'));
		
		if(empty($post->prova_id) && empty($post->acao)) {
			print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => ' Parametros inválido, verifique e tente novamente.'));
			exit;
		}

		$post = array( 'acao' => $this->seguranca->dec($post->acao), 'prova_id' => $this->seguranca->dec($post->prova_id));
	//	if(verificaUsoDeProva($post['prova_id'])) {
		//	print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => 'Registro em uso, impossivel inativar.'));
	//		exit;			
		//} else {
			if($this->_updateStatusProva($post)){
				print json_encode(array('status' => 'sucesso', 'title' => $this->swall_titulo_sucesso, 'tipo' => $this->swall_tipo[1], 'message' => 'Situação alterada com sucesso!', 'close' => $this->swall_timeout['nivel3']));
				exit;
			} else {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => ' Falha ao atualizar a situação desta equipe, verifique e tente novamente.'));
				exit;
			}
		//}
	}

	private function _updateStatusProva($post) {
		if(!$post) {
			return false;
		} else {
			
			if($post['acao'] == "inativar") {
				return $this->provas_m->_updateStatusProva($post['prova_id'], array('status' => 0, 'modification' => date('Y-m-d H:i:s')));
			}
			if($post['acao'] == "ativar") {
				return $this->provas_m->_updateStatusProva($post['prova_id'], array('status' => 1, 'modification' => date('Y-m-d H:i:s')));
			}
		}
	}

}
