<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Materiais extends MY_Controller {

	public $data_view;
	private $tabela_id = 1440;

	public function __construct() {
		parent::__construct();
		$this->permissoes->verificaLogado();
		$this->stringController = "materiais";
		$this->load->library("assets", array(
			'header' => array(
				'titulo_home' => "Materiais", 
				'titulo_pagina_cadastro' => "Cadastro de Materiais", 'subtitulo' => null,
				'titulo_pagina_editar' => "Atualização de Materiais", 'subtitulo' => null
			),
			'js' => 'modulos/materiais/materiais'
		));
		$this->load->model(array('materiais_m'));
		$this->usuarioAdministrador = $this->rsession->get('usuario_logado')['usuario_administrador'];
		$this->layout_coluna_id     = $this->layout_listagem_id = 1;
		$this->title_page = MATERIAIS_CABECALHO_PAGINA;
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

	private function cabecalhoListagemTabelas($layout_id) {
		if(empty($layout_id)) return false;

		$table_header = null;
		switch ($layout_id) {
			case '1':
				$table_header.= '<th style="width: auto;">DESCRIÇÃO</th>';
				$table_header.= '<th style="width: 100px;">QTD.ESTOQUE</th>';
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
	public function salvarMaterial() {
		header('Content-type: application/json');
		$post = array($this->input->post());
		$dados_DataBase = array();
		foreach ($post as $propriedade) {
			if(strlen($propriedade['material_descricao']) < 8) {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Descrição inválida ou incompleta.', 'input' => 'material_descricao'));
				exit;
			}

			if(empty($propriedade['material_quantidade'])) {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Falta a quantidade para este material', 'input' => 'material_quantidade'));
				exit;
			}

			if(empty($propriedade['material_unidade'])) {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Falta especificar a unidade deste produto', 'input' => 'material_unidade'));
				exit;
			}
		}
		$Cad_ProdutoDados = array (
			'descricao' => $post[0]['material_descricao'],
			'detalhamento' => $post[0]['material_detalhes'],
			'tipo_medida' => $post[0]['material_unidade'],
			'status' => isset($post[0]['material_status']) ? $post[0]['material_status'] : false
		);

		$Cad_ProdutoEstoque = array (
			'qtd_estoque' => $post[0]['material_quantidade']
		);

		$material_id = !empty($post[0]['material_id']) ? $this->seguranca->dec($post[0]['material_id']) : false;
		if(!$material_id) {
			// Faz insert e seta na variavel o 'id' da prova.
			$IDMATERIAL = $this->_insertRegistro($Cad_ProdutoDados, $Cad_ProdutoEstoque);
			if($IDMATERIAL) {
				print json_encode(array('status' => 'sucesso', 'title' => $this->swall_titulo_sucesso, 'tipo' => $this->swall_tipo[1], 'message' => 'Material registrado com sucesso!<br><b>Código:</b> '.$IDMATERIAL));
			} else {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => 'Falha crítica ao salvar registro no banco de dados. Por favor contate a '.DESENVOLVEDOR_SISTEMA_NOME.'!!'));
				exit;
			}
		} else {
			if($this->_updateRegistro($Cad_ProdutoDados, $Cad_ProdutoEstoque, $material_id)) {
				print json_encode(array('status' => 'sucesso', 'title' => $this->swall_titulo_sucesso, 'tipo' => $this->swall_tipo[1], 'message' => 'Material atualizado com sucesso!', 'close' => $this->swall_timeout['nivel3']));
				exit;
			} else {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => 'Falha crítica ao atualizar registro no banco de dados. Por favor contate a '.DESENVOLVEDOR_SISTEMA_NOME.'!!'));
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
		
		$paramLimites = array('limite' => $limite, 'index' => $index);

		$materiais = $this->materiais_m->getAll($paramLimites, $search);
		
		$listagem = $this->layoutListagemGeralMateriais($materiais, $this->layout_coluna_id, $search);
		if(!$listagem) {
			print json_encode(array('status' => false, 'data' => array()));
			exit;
		} else {
			print json_encode($listagem);
		}
	}

	private function layoutListagemGeralMateriais($dados, $layout_id, $search) {
		$ci	=& get_instance();
		if(empty($layout_id) || empty($dados)) {
			return false;
		}
		foreach($dados as $r) {
			$data[] = $this->montaDadosLayout($layout_id, $r);
		}
		$t = $ci->materiais_m->getAllCount($search);
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
		$dados_estoque = !empty($dados->qtd_estoque) ? '<span class="badge badge-primary" style="font-size: 11px; !importante;">'.$dados->qtd_estoque.'</span>':'<span class="badge badge-danger" style="font-size: 11px; !importante;">0</span>';
		
		//$botao_alterar_dados = '<a href="'. base_url('prova/editar/' . $this->seguranca->enc($dados->idmaterial)) . '" title="Editar registro: '.$dados->idmaterial.'" class="icons-size-2"> <i class="icon-feather-edit"></i></a>';
		
		$botao_alterar_dados = '<a onclick="editarRegistro(this)" id="'.$this->seguranca->enc($dados->idmaterial).'" title="Atualizar" class="icons-size-2"><i class="icon-feather-edit icons-size-2"></i></a>';

		$botao_ativa_inativa = '<a class="icons-size-2" onclick="mudarStatus(this)" id="'.$this->seguranca->enc($dados->idmaterial).'" title="'.$ativa_inativa['title'] .'" 
		data-value="'.$this->seguranca->enc($ativa_inativa['acao']).'">'.$ativa_inativa['icon'].'</a>'; 

		if($this->usuarioAdministrador) {
				$opcoes_botao[] = '<div style="margin:5px; text-align: left !important;">'.$botao_ativa_inativa.'&nbsp;'.'&nbsp;'.$botao_alterar_dados . '</div>';
			} else {
				$opcoes_botao[] = '<div style="margin:5px; text-align: left !important;">'.$botao_alterar_dados . '</div>';
		}

		if($layout_id == 1) {
			$linha[$this->stringController.'_descricao']	= $dados->descricao;
			$linha[$this->stringController.'_qtd_estoque']	= $dados_estoque.' <b>'.$dados->tipo_medida.'</b>';
			$linha[$this->stringController.'_botoes']			= is_array($opcoes_botao) ? implode($opcoes_botao) : $opcoes_botao;
		}
		return $linha;
	}

	private function _insertRegistro($Cad_ProdutoDados, $Cad_ProdutoEstoque){
		if(!$Cad_ProdutoDados) {
			return false;
			exit;
		}
		$Cad_ProdutoDados['created'] = date('Y-m-d H:i:s');
		$Cad_ProdutoDados['user_created'] = $this->seguranca->dec($this->rsession->get('usuario_logado')['id_usuario']);
		
		//INSERT AND RETURN(ID) MATERIAL
		$IDMATERIAL = $this->materiais_m->_insertRegistro($Cad_ProdutoDados);
		if($IDMATERIAL) {
			return $IDMATERIAL;
		}
		return false;
	}

	private function _updateRegistro($Cad_ProdutoDados, $Cad_ProdutoEstoque, $material_id){
		if(!$material_id && (!$Cad_ProdutoDados || !$Cad_ProdutoEstoque)) {
			return false;
			exit;
		}
		$Cad_ProdutoDados['updated'] = date('Y-m-d H:i:s');
		$Cad_ProdutoDados['user_updated'] = $this->seguranca->dec($this->rsession->get('usuario_logado')['id_usuario']);
		return $this->materiais_m->_updateRegistro($Cad_ProdutoDados, $Cad_ProdutoEstoque, $material_id) || false;
	}
	
	public function getMaterial() {
		$post = json_decode(file_get_contents('php://input'));
		$material_id = isset($post->material_id) ?  intval($this->seguranca->dec($post->material_id)) : false;
		if(isset($material_id) && is_integer($material_id)) {
			$dados_material = $this->materiais_m->getMaterial($material_id);
			if(!empty($dados_material)) {
				$dados_material->idmaterial = $this->seguranca->enc($dados_material->idmaterial);
				$dados_material->idestoquemateriais = $this->seguranca->enc($dados_material->idestoquemateriais);
				$dados_material->user_created = $this->seguranca->enc($dados_material->user_created);
				print json_encode(array('status' => 'sucesso', 'dados' => $dados_material));exit;
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
		
		if(empty($post->material_id) && empty($post->acao)) {
			print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => ' Parametros inválido, verifique e tente novamente.'));
			exit;
		}

		$post = array( 'acao' => $this->seguranca->dec($post->acao), 'material_id' => $this->seguranca->dec($post->material_id));
	//	if(verificaUsoDeProva($post['material_id'])) {
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
				return $this->materiais_m->_updateStatusProva($post['material_id'], array('status' => 0, 'modification' => date('Y-m-d H:i:s')));
			}
			if($post['acao'] == "ativar") {
				return $this->materiais_m->_updateStatusProva($post['material_id'], array('status' => 1, 'modification' => date('Y-m-d H:i:s')));
			}
		}
	}

}
