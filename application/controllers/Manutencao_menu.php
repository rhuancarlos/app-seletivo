<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manutencao_menu extends MY_Controller {

	public $data_view;
	private $tabela_id = 1420;
	private $tabela_id_r = 1437;
	private $tabela_id_cr_up = 1437;

	public function __construct() {
		parent::__construct();
		$this->permissoes->verificaLogado();
		$this->stringController = "manutencao_menu";
		$this->load->library("assets", array(
			'header' => array( 
				'titulo_home' => "Manutenção de menus", 
				'titulo_pagina_cadastro' => "Novos menus", 'subtitulo' => null,
				'titulo_pagina_editar' => "Atualização de menu", 'subtitulo' => null
			),
			'js' => 'modulos/manutencao/ManutencaoController|modulos/manutencao/ManutencaoService|configValue',
		));
		$this->load->model(array('menus_m', 'menus_itens_m'));
		$this->usuarioAdministrador = $this->rsession->get('usuario_logado')['usuario_administrador'];
		$this->layout_coluna_id     = $this->layout_listagem_id = 1;
	}

	public function index() {
		$this->permissoes->verificaAcesso($this->tabela_id_r, $this->seguranca->dec($this->rsession->get('usuario_logado')['grupo_usuario_id']));
		$this->data_view['title_page'] = MANUTENCAOMENU_CABECALHO_PAGINA;
		$this->data_view['titulo_home'] = $this->assets->header['titulo_home'];
		$this->data_view['titulo_home2'] = '';
		$this->data_view['controller'] = $this->stringController;
		$this->data_view['list_table_th'] = $this->cabecalhoListagemTabelas($this->layout_coluna_id);
		if($this->rsession->get('usuario_logado')['usuario_administrador']) {
			$n = 'full';
		} else{
			$n = $this->permissoes->verificaAcesso($this->tabela_id_cr_up, $this->seguranca->dec($this->rsession->get('usuario_logado')['grupo_usuario_id']));
		}
		$this->data_view['nivel_acoes'] = $n;
		$this->loadView($this->data_view);
	}

	private function cabecalhoListagemTabelas($layout_id) {
		if(empty($layout_id)) return false;

		$table_header = null;
		switch ($layout_id) {
			case '1':
				//$table_header.= '<th style="width: 82px;">CÓDIGO</th>';
				$table_header.= '<th style="width: auto;">NOME COMPLETO</th>';
				$table_header.= '<th style="width: auto;">GRUPO DE ACESSO</th>';
				//$table_header.= '<th style="width: auto;">EQUIPE</th>';
				$table_header.= '<th style="width: auto;">EMAIL</th>';
				$table_header.= '<th style="width: 90px;">AÇÕES</th>';
			break;
		}
		return $table_header;
	}

	public function getOpcoesMenus() {
		header('Content-type: application/json');
		$post = json_decode(file_get_contents('php://input'));
		$menu_tipo = isset($post->menu_tipo) && (!empty($post->menu_tipo)) ? $post->menu_tipo : false;

		if($menu_tipo) {
			if($menu_tipo == 2) {
				$dados = getSecoesMenus();
				if($dados) {
					print json_encode(array('status' => true, 'dados' => $dados));exit;
				}
				print json_encode(array('status' => false, 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Não foram encontrados seções de <b>menu cadastradas ou ativas</b>.'));
				exit;
			}
			if($menu_tipo == 3) {
				$dados = getMenusPai(true);
				if($dados) {
					print json_encode(array('status' => true, 'dados' => $dados));exit;
				}
				print json_encode(array('status' => false, 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Não foram encontrados seções de <b>menu cadastradas ou ativas</b>.'));
				exit;
			}
		}
	}
	
	public function getMenu () {
		header('Content-type: application/json');
		$menus_pai = $this->menus_m->getTabelasMenus(true);
		$menus_secoes = $this->menus_m->getMenuAncora();
		$menu = [];
		foreach ($menus_secoes as $key_s => $secao) {
			if(!array_key_exists($secao->descricao, $menu)) {
				$menu['secao'][$secao->descricao] = array();
			}
			$menus_pai = $this->menus_m->getItensSubMenus(false, false, $secao->id);
			foreach($menus_pai as $key_p => $menu_pai) {
				if($secao->id == $menu_pai->menu_id) {
					$menus_itens = $this->menus_m->getItensSubMenus($menu_pai->id, false, false);
					if(!array_key_exists($menu_pai->descricao, $menu['secao'][$secao->descricao])) {
						$menu['secao'][$secao->descricao][$menu_pai->descricao] = array();
					}
					foreach($menus_itens as $key_i => $menu_item) {
						if($menu_pai->id == $menu_item->iditem_sub_menu) {
							array_push($menu['secao'][$secao->descricao][$menu_pai->descricao], $menu_item);
						}
					}
				}
			}
		}
		print json_encode($menu);exit;
		
	}
	
	public function salvarMenu () {
		header('Content-type: application/json');
		$post = json_decode(file_get_contents('php://input'));
		$tipo_menu = isset($post->tipoSelect) ? $post->tipoSelect : false;
		$id = (isset($post->id) && (!empty($post->id))) ? $post->id : false;

		if($tipo_menu == 1) {
			$dados = array(
				'descricao' => $post->descricao,
				'sigla' => $post->sigla,
				'ordem' => count(getSecoesMenus())+1,
				'status' => $post->status
			);	
			
			$salvar = $this->_saveMenu($dados, $id);
			if($salvar && (!isset($post->menu_id))) {
				print json_encode(array('status' => true, 'title' => $this->swall_titulo_sucesso, 'tipo' => $this->swall_tipo[1], 'message' => 'Seção salva com sucesso</b>.', 'close' => $this->swall_timeout['nivel3']));
				exit;
			} else {
				print json_encode($salvar);exit;
			}
		}
		if($tipo_menu == 2) {
			$dados = array(
				'descricao' => $post->descricao,
				'descricao_completa' => $post->descricao_completa,
				'menu_id' => $post->secao_menu,
				'sub_menu' => 1,
				'icone' => 'os-icon os-icon-layout',
				'ordem' => count(getSecoesMenus())+1,
				'status' => $post->status
			);
			$salvar = $this->_saveItensMenu($dados, $id);
			if($salvar && (!isset($post->menu_id))) {
				print json_encode(array('status' => true, 'title' => $this->swall_titulo_sucesso, 'tipo' => $this->swall_tipo[1], 'message' => 'Seção salva com sucesso</b>.', 'close' => $this->swall_timeout['nivel3']));
				exit;
			} else {
				print json_encode($salvar);exit;
			}
		}
		if($tipo_menu == "3") {
			$dados = array(
				'descricao' => $post->descricao,
				'descricao_completa' => $post->descricao_completa,
				'menu_id' => $this->menus_itens_m->getById($post->menu_vinculo)->menu_id,
				'iditem_sub_menu' => $post->menu_vinculo,//$id_menu_filho $post->menu_vinculo->id,
				'sub_menu' => 0,
				'repositorio_link' => $post->path_servidor,
				'target' => isset($post->target) ? $post->target : null,
				// 'icone' => 'os-icon os-icon-layout',
				// 'ordem' => count(getSecoesMenus())+1,
				'status' => $post->status
			);
			$salvar = $this->_saveItensMenu($dados, $id);
			if($salvar && (!isset($post->menu_id))) {
				print json_encode(array('status' => true, 'title' => $this->swall_titulo_sucesso, 'tipo' => $this->swall_tipo[1], 'message' => 'Seção salva com sucesso</b>.', 'close' => $this->swall_timeout['nivel3']));
				exit;
			} else {
				print json_encode($salvar);exit;
			}
		}
	}

	private function _saveMenu($dados, $id = false) {
		if(!$dados) {return false;}

		if(!$id) {
			$dados['created'] = date('Y-m-d H:i:s');
			return $this->menus_m->_saveMenu($dados);
		} else {
			$dados['updated'] = date('Y-m-d H:i:s');
			return $this->menus_m->_saveMenu($dados, $id);
		}

	}

	private function _saveItensMenu($dados, $id = false) {
		if(!$dados) {return false;}
		
		if(!$id) {
			$dados['created'] = date('Y-m-d H:i:s');
			return $this->menus_itens_m->_saveMenu($dados);
		} else {
			$dados['updated'] = date('Y-m-d H:i:s');
			return $this->menus_itens_m->_saveMenu($dados, $id);
		}

	}

	public function getDados() {
		header('Content-type: application/json');
		$post = json_decode(file_get_contents('php://input'));
		$retorno = array();
		if($post->tipo == 1) {
			$secao_id = null;
			if(isset($post->dados->itens_secao) && (!empty($post->dados->itens_secao))) {
				foreach($post->dados->itens_secao as $key_s => $secao) {
					if(empty($secao_id)) {
						$secao_id = $secao[0]->menu_id;
					}
				}
			}
			$secao = $this->menus_m->getSecao($secao_id);
			if(!$secao) {
				$retorno = array('status' => false);
			} else {
				$retorno = array('status' => true, 'dados' => $secao);
			}
			print json_encode($retorno);
		}
		if($post->tipo == 2) {
			$secao_id = null;
			if(isset($post->dados->itens_secao) && (!empty($post->dados->itens_secao))) {
				foreach($post->dados->itens_secao as $key_s => $secao) {
					// var_dump($secao);
					if(empty($secao_id)) {
						$secao_id = $secao->iditem_sub_menu;
					}
				}
			}
			$secao = $this->menus_m->getMenu($secao_id);
			if(!$secao) {
				$retorno = array('status' => false);
			} else {
				$retorno = array('status' => true, 'dados' => $secao, 'secoesMenus' => getSecoesMenus());
			}
			print json_encode($retorno);
		}
		if($post->tipo == 3) {
			$secao_id = null;
			if(isset($post->dados->itens_secao) && (!empty($post->dados->itens_secao))) {
				// foreach($post->dados->itens_secao as $key_s => $secao) {
					// var_dump($secao);
					if(empty($secao_id)) {
						$secao_id = $post->dados->itens_secao;
					}
				// }
			}
			$secao = $this->menus_m->getMenu($secao_id);
			if(!$secao) {
				$retorno = array('status' => false);
			} else {
				$retorno = array('status' => true, 'dados' => $secao, 'itensMenus' => getMenusPai(true));
				;
			}
			print json_encode($retorno);
		}
	}

}
