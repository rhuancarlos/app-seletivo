<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cultos extends MY_Controller {

	public $data_view;
	private $tabela_id = 1417;
	private $tabela_id_cr_up = 1428;
	private $tabela_id_r = 1428;
	//private $tabela_id_u = 1428;
	private $tabela_id_d = null;

	public function __construct() {
		parent::__construct();
		// $this->permissoes->verificaLogado();
		$this->stringController = "cultos";
		$this->load->library("assets", array(
			'header' => array(
				'titulo_home' => "Equipes",
				'titulo_pagina_cadastro' => "Cadastro de Equipe", 
				'titulo_pagina_editar' => "Atualização de Equipe", 'subtitulo' => null
			),
			'js' => 'modulos/equipe/equipes'
		));
		$this->load->model(array('equipes_m', 'participantes_m'));
		$this->usuarioAdministrador = $this->rsession->get('usuario_logado')['usuario_administrador'];
		$this->layout_coluna_id     = $this->layout_listagem_id = 1;
		$this->title_page = EQUIPE_CABECALHO_PAGINA;
	}

	public function index() {
		// $this->permissoes->verificaAcesso($this->tabela_id_r, $this->seguranca->dec($this->rsession->get('usuario_logado')['grupo_usuario_id']));
		// $this->data_view['title_page'] = $this->title_page;
		// $this->data_view['titulo_home'] = $this->assets->header['titulo_home'];
		// $this->data_view['titulo_home2'] = null;
		// $this->data_view['controller'] = $this->stringController;
		// $this->data_view['participantes'] = $this->participantes_m->getAll();
		// $this->data_view['list_table_th'] = $this->cabecalhoListagemTabelas($this->layout_coluna_id);
		// $this->data_view['nivel_acoes'] = $this->permissoes->verificaAcesso($this->tabela_id_cr_up, $this->seguranca->dec($this->rsession->get('usuario_logado')['grupo_usuario_id']));
		// $this->loadView($this->data_view, false, false);
		$this->load->view('cultos/index');
	}

	private function cabecalhoListagemTabelas($layout_id) {
		if(empty($layout_id)) return false;

		$table_header = null;
		switch ($layout_id) {
			case '1':
				$table_header.= '<th style="width: 82px;">CÓDIGO</th>';
				$table_header.= '<th style="width: auto;">NOME DA EQUIPE</th>';
				$table_header.= '<th style="width: auto;">SIGLA</th>';
				$table_header.= '<th style="width: 90px;">AÇÕES</th>';
			break;
		}
		return $table_header;
	}
	
	public function cadastrar() {
		$this->data_view['title_page'] = $this->title_page;
		$this->data_view['titulo_pagina'] = $this->assets->header['titulo_pagina_cadastro'];
		$this->loadView($this->data_view);
	}

	public function salvarEquipe() {
		header('Content-type: application/json');
		$post = array($this->input->post());
		$dados_DataBase = array();
		foreach ($post as $propriedade) {
			if(empty($propriedade['equipe_nome'])) {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Você não informou o nome da equipe. Verifique e tente novamente.', 'input' => 'equipe_nome'));
				exit;
			}

			if(strlen($propriedade['equipe_nome']) > 30) {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Nome da equipe ultrapassa o limite permitido.', 'input' => 'equipe_nome'));
				exit;
			}

			if(empty($propriedade['equipe_sigla'])) {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Você não informou a sigla da equipe. Verifique e tente novamente.', 'input' => 'equipe_sigla'));
				exit;
			}

			if(strlen($propriedade['equipe_sigla']) > 6) {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'A sigla da equipe ultrapassa o limite permitido.', 'input' => 'equipe_nome'));
				exit;
			}
		}
		
		$dados_DataBase = array ('descricao' => $post[0]['equipe_nome'], 'sigla' => $post[0]['equipe_sigla'], 'status' => 1, 'style_backgroud_cor_1' => $post[0]['equipe_cor_1'], 'style_backgroud_cor_2' => $post[0]['equipe_cor_2'], 'mostrar_widget_tela_inicial' => isset($post[0]['equipe_mostra_tela_inicial']) ? true : false, 'style_font_cor' => '#ffffff');

		$codigo_equipe = !empty($post[0]['equipe_codigo']) ? $this->seguranca->dec($post[0]['equipe_codigo']) : false;
		if(!$codigo_equipe) {
			// Verifica se registro já existe, caso contrário continua o processo.
			if($this->equipes_m->getEquipe(false, $dados_DataBase['sigla'])) {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => ' Já existe uma equipe com a <strong>sigla</strong> especificada, verifique a listagem geral.'));
				exit;
				return;				
			}
			// Faz insert e seta na variavel o 'id' do participante.
			$idsigla = $this->_insertRegistro($dados_DataBase);
			if($idsigla) {
				print json_encode(array('status' => 'sucesso', 'title' => $this->swall_titulo_sucesso, 'tipo' => $this->swall_tipo[1], 'message' => 'Equipe '.$post[0]['equipe_nome'].' registrada com sucesso!', 'close' => $this->swall_timeout['nivel3']));
				exit;
			} else {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => 'Falha crítica ao salvar registro no banco de dados. Por favor contate a '.DESENVOLVEDOR_SISTEMA_NOME.'!!'));
				exit;
			}
		} else {
			if($this->_updateRegistro($dados_DataBase, $codigo_equipe)) {
				print json_encode(array('status' => 'sucesso', 'title' => $this->swall_titulo_sucesso, 'tipo' => $this->swall_tipo[1], 'message' => 'Participante atualizado com sucesso!', 'close' => $this->swall_timeout['nivel3']));
				exit;
			} else {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => 'Falha crítica ao atualizar o registro no banco de dados.<Br> Por favor contate a '.DESENVOLVEDOR_SISTEMA_NOME.'!!'));
				exit;
			}
		}
		exit;
	}

	private function _insertRegistro($dados_DataBase){
		if(!$dados_DataBase) {
			return false;
			exit;
		}
		$dados_DataBase['created'] = date('Y-m-d H:i:s');
		$IDPARTICIPANTE = $this->equipes_m->_insertRegistro($dados_DataBase);
		return (!$IDPARTICIPANTE) ? false : $IDPARTICIPANTE;
	}

	private function _updateRegistro($dados_DataBase, $codigo_equipe){
		if(!$dados_DataBase) {
			return false;
			exit;
		}
		#debug_array($codigo_equipe);
		$dados_DataBase['modified'] = date('Y-m-d H:i:s');
		return $this->equipes_m->_updateRegistro($dados_DataBase, $codigo_equipe) <= 0 ? false : true;
	}

	private function montaDadosLayout($layout_id, $dados) {
		if(!isset($dados)) {
			return false;
		}
		$nivel_acesso = $this->permissoes->verificaAcesso($this->tabela_id_cr_up, $this->seguranca->dec($this->rsession->get('usuario_logado')['grupo_usuario_id']));
		$detalhes = $dados->mostrar_widget_tela_inicial ? '    <i class="fa fa-thumb-tack" style="color: crimson;" title="Ativo na tela inicial"></i>' : '';
		$linha = $opcoes_botao = array();

		$ativa_inativa = $dados->status ? 
		array('icon' => '<i class="fa fa-times icon-inativar "></i></a>', 'link' => '#1', 'title' => 'Desativar', 'acao' => 'inativar') : 
		array('icon' =>'<i class="fa fa-check icon-ativar"></i></a>', 'link' => '#2', 'title' => 'Ativar', 'acao' => 'ativar');

		$botao_alterar_dados_membro = '<a onclick="editarRegistro(this)" id="'. $this->seguranca->enc($dados->idequipe).'" title="Atualizar">
		<i class="icon-feather-edit icons-size-2"></i></a>';
		
		$botao_ver_ficha_detalha = '<a onclick="abrirRegistro(this)" id="'.$this->seguranca->enc($dados->idequipe).'" title="Abrir registro">
		<i class="fa fa-eye icons-size-2"></i></a>';

		$botao_ativa_inativa = '<a class="icons-size-2" onclick="mudarStatus(this)" id="'.$this->seguranca->enc($dados->idequipe).'" title="'.$ativa_inativa['title'] .'" 
		data-value="'.$this->seguranca->enc($ativa_inativa['acao']).'">'.$ativa_inativa['icon'].'</a>'; 

		if($this->usuarioAdministrador) {
				$opcoes_botao[] = 
				'<div style="margin:5px; text-align: left !important;">'.$botao_ativa_inativa . $botao_ver_ficha_detalha . $botao_alterar_dados_membro .'</div>';
		} else {
			if($nivel_acesso >= 2 ) {
				$opcoes_botao[] = '<div style="margin:5px; text-align: left !important;">'.$botao_ver_ficha_detalha . $botao_alterar_dados_membro .'</div>';
			} else {
				$opcoes_botao[] = '<div style="margin:5px; text-align: left !important;">'.$botao_ver_ficha_detalha .'</div>';
			}
		}

		if($layout_id == 1) {
			$linha[$this->stringController.'_codigo']			= $dados->idequipe;
			$linha[$this->stringController.'_descricao']	= $dados->descricao.$detalhes;
			$linha[$this->stringController.'_sigla']			= $dados->sigla;
			$linha[$this->stringController.'_botoes']			= is_array($opcoes_botao) ? implode($opcoes_botao) : $opcoes_botao;
		}
		return $linha;
	}

	public function mudarStatus() {
		$post = json_decode(file_get_contents('php://input'));
		
		if(empty($post->equipe_id) && empty($post->acao)) {
			print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => ' Parametros inválido, verifique e tente novamente.'));
			exit;
		}

		$post = array( 'acao' => $this->seguranca->dec($post->acao), 'equipe_id' => $this->seguranca->dec($post->equipe_id));
		if(verificaUsoDeEquipe($post['equipe_id'])) {
			print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => 'Registro em uso, impossivel inativar.'));
			exit;			
		} else {
			if($this->_updateStatusEquipe($post)){
				print json_encode(array('status' => 'sucesso', 'title' => $this->swall_titulo_sucesso, 'tipo' => $this->swall_tipo[1], 'message' => 'Situação alterada com sucesso!', 'close' => $this->swall_timeout['nivel3']));
				exit;
			} else {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => ' Falha ao atualizar a situação desta equipe, verifique e tente novamente.'));
				exit;
			}
		}
	}

	private function _updateStatusEquipe($post) {
		if(!$post) {
			return false;
		} else {
			
			if($post['acao'] == "inativar") {
				return $this->equipes_m->_updateStatusEquipe($post['equipe_id'], array('status' => 0, 'modified' => date('Y-m-d H:i:s')));
			}
			if($post['acao'] == "ativar") {
				return $this->equipes_m->_updateStatusEquipe($post['equipe_id'], array('status' => 1, 'modified' => date('Y-m-d H:i:s')));
			}
		}
	}

	public function getListagemGeral() {
		$post = $this->input->post();
		$valueDefault = 25;
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
		
		$paramLimites = array('limite' => $limite, 'index' => $index);
		$participantes = $this->equipes_m->getAll($paramLimites, $search);
		
		$listagem = $this->layoutListagemGeralEquipes($participantes, $this->layout_coluna_id, $search);
		if(!$listagem) {
			print json_encode(array('status' => false, 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Nenhum dado encontrado'));
			exit;
		} else {
			print json_encode($listagem);
		}
	}

	private function layoutListagemGeralEquipes($dados, $layout_id, $search) {
		$ci	=& get_instance();
		if(empty($layout_id) || empty($dados)) {
			return false;
		}
		foreach($dados as $r) {
			$data[] = $this->montaDadosLayout($layout_id, $r);
		}
		$t = $ci->equipes_m->getAllCount($search);
		return array("recordsTotal" => $t, "recordsFiltered" => $t, "data" => $data, "layout_list" => $layout_id);
	}

	public function getEquipe() {
		$post = json_decode(file_get_contents('php://input'));
		$equipe_id = isset($post->equipe_id) ?  intval($this->seguranca->dec($post->equipe_id)) : false;
		if(isset($equipe_id) && is_integer($equipe_id)) {
			$dados_equipe = $this->equipes_m->getEquipe($equipe_id);
			if(!empty($dados_equipe)) {
				$dados_equipe->idequipe = $this->seguranca->enc($dados_equipe->idequipe);
				print json_encode(array('status' => 'sucesso', 'dados' => $dados_equipe));exit;
			} else {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => 'Não foi possivel encontrar nenhum registro. Verifique e tente novamente'));
				exit;
			}
		} else {
			print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => ' Parametros inválido, verifique e tente novamente'));
			exit;
		}
	}
}
