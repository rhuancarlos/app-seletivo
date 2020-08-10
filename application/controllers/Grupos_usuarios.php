<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grupos_usuarios extends MY_Controller {

	public $data_view;
	private $tabela_id = 1421;
	private $tabela_id_r = 1438;
	private $tabela_id_cr_up = 1438;

	public function __construct() {
		parent::__construct();
		$this->permissoes->verificaLogado();
		$this->stringController = "grupos_usuarios";
		$this->load->library("assets", array(
			'header' => array( 
				'titulo_home' => GRP_USUARIO_NOME_MODULO,
			),
			'js' => 'modulos/grupo_usuario/grupo_usuario'
		));
		$this->load->model(array('usuarios_m','participantes_m', 'grupos_usuarios_m', 'usuarios_perfil_m','atribuicoes_m', 'menus_m',	'grupos_usuarios_acessos_m'));
		$this->usuarioAdministrador = $this->rsession->get('usuario_logado')['usuario_administrador'];
		$this->layout_coluna_id     = $this->layout_listagem_id = 1;
	}

	private function getItensSubMenus($id_sub_menu_pai, $grupousuario = false, $submenu = false){
		//echo $id_sub_menu_pai;exit;
		return $this->menus_m->getItensSubMenus($id_sub_menu_pai, $grupousuario, $submenu);
	}

	public function index() {
		$this->permissoes->verificaAcesso($this->tabela_id_r, $this->seguranca->dec($this->rsession->get('usuario_logado')['grupo_usuario_id']));
		$Tabelas_ancoras = $this->menus_m->getMenuAncora();
		$Tabelas_itens = $this->menus_m->getTabelasMenus(true);

		if($Tabelas_itens) {
			$tabela = '<div class="table-responsive">';
			foreach ($Tabelas_ancoras as $ta) {
				$tabela .= '<h6 class="element-header">'.$ta->descricao.'</h6>';
				$tabela .= '<table class="table table-striped table-bordered table-hover">';
				$tabela	.= '<tr>';
				if(empty($this->getItensSubMenus(false, false, $ta->id))) {
					$tabela .= '
					<td>
					<div class="form-desc" style="margin-bottom: 0; text-align: center; padding: 5px;">Este menu não possui nenhuma permissão configurada para em sua matriz de opções. Favor contactar a '.DESENVOLVEDOR_SISTEMA_NOME.'</div>
					</td>';
					$tabela .= '</tr>';
				} else {
					$tabela .= '<thead>';
					$tabela .= $this->cabecalhoListagemTabelas(2);
					$tabela .= '</tr>';
					$tabela .= '</thead>';
					$tabela .= '<tbody>';
					foreach ($Tabelas_itens as $ti) {
						if($ta->id == $ti->menu_id) {
							$tabela	.= '<tr>';
							$tabela .= '<td colspan="3"><i class="icon-feather-home"></i> '.'<small>( '.$ti->id.' )</small>  '.$ti->descricao.'</td>';
							$tabela .= '</tr>';
							foreach($this->getItensSubMenus($ti->id, false, false) as $item_f) {
								if($ti->id == $item_f->iditem_sub_menu) {
									$tabela	.= '<tr>';
									$tabela .= '<td>&nbsp;&nbsp;<i class="icon-feather-chevrons-right"></i>
									<i class="icon-feather-slash" style="cursor:pointer; color: red;" title="Cancelar opção marcada" onclick="cancelaOpcao('.$item_f->id.')"></i> '
									.'<small style="color: #3326ce;">('.$item_f->id.')</small>  '.$item_f->descricao.'</td>';
									$tabela .= '<td>
									<input type="radio" name="permissao_'.$item_f->id.'" value="1" data-permissao="'.$item_f->id.'" data-menu_pai="'.$ti->id.'"> Leitura
									<input type="radio" name="permissao_'.$item_f->id.'" value="2" data-permissao="'.$item_f->id.'" data-menu_pai="'.$ti->id.'"> Escrita
									<input type="radio" name="permissao_'.$item_f->id.'" value="3" data-permissao="'.$item_f->id.'" data-menu_pai="'.$ti->id.'"> L/E
									</td>';
									$tabela .= '</tr>';
									
									//GERA ITENS DE SUB-MENU 2º NIVEL
									foreach($this->getItensSubMenus($item_f->id, false, false) as $key => $m_nivel2) {
										if($m_nivel2->iditem_sub_menu == $item_f->id) {
											$tabela	.= '<tr>';
											$tabela .= '<td style="padding-left: 25px !important;"><i class="icon-feather-chevrons-right"></i>
											<i class="icon-feather-slash" style="cursor:pointer; color: red;" title="Cancelar opção marcada" onclick="cancelaOpcao('.$m_nivel2->id.')"></i> '
											.'<small style="color: #3326ce;">('.$m_nivel2->id.')</small>  '.$m_nivel2->descricao.'</td>';
											$tabela .= '<td>
											<input type="radio" name="permissao_'.$m_nivel2->id.'" value="1" data-permissao="'.$m_nivel2->id.'" data-menu_pai="'.$item_f->id.'"> Leitura
											<input type="radio" name="permissao_'.$m_nivel2->id.'" value="2" data-permissao="'.$m_nivel2->id.'" data-menu_pai="'.$item_f->id.'"> Escrita
											<input type="radio" name="permissao_'.$m_nivel2->id.'" value="3" data-permissao="'.$m_nivel2->id.'" data-menu_pai="'.$item_f->id.'"> L/E
											</td>';
										}
									} ///
									$tabela .= '</tr>';

								}
							}
						}
					}
					$tabela .= '</tbody>';
				}
				$tabela .= '</table>';
			}
			$tabela .= '</div>';
		}

		$this->data_view['title_page'] = GRP_USUARIO_CABECALHO_PAGINA;
		$this->data_view['titulo_home'] = $this->assets->header['titulo_home'];
		$this->data_view['titulo_home2'] = '';
		$this->data_view['controller'] = $this->stringController;
		$this->data_view['participantes'] = $this->participantes_m->getAll();
		$this->data_view['grupos_acessos'] = $this->grupos_usuarios_m->getAll();
		$this->data_view['atribuicoes'] = $this->atribuicoes_m->getAll();
		$this->data_view['list_table_th'] = $this->cabecalhoListagemTabelas($this->layout_coluna_id);
		$this->data_view['TabelasMenus'] = $tabela;
		if($this->rsession->get('usuario_logado')['usuario_administrador']) {
			$n = 'full';
		} else{
			$n = $this->permissoes->verificaAcesso($this->tabela_id_cr_up, $this->seguranca->dec($this->rsession->get('usuario_logado')['grupo_usuario_id']));
		}
		$this->data_view['nivel_acoes'] = $n;
		$this->loadView($this->data_view);
	}
	
	public function cadastrar() {
		$this->data_view['title_page'] = GRP_USUARIO_CABECALHO_PAGINA;
		$this->data_view['titulo_home'] = $this->assets->header['titulo_home'];
		$this->data_view['titulo_home2'] = GRP_USUARIO_TITULO_REGISTRO;
		$this->data_view['titulo_pagina'] = GRP_USUARIO_TITULO_REGISTRO;
		$this->data_view['estados'] = $this->estados_m->getAll();
		$this->data_view['estado_civil'] = $this->estado_civil_m->getAll();
		$this->data_view['equipes'] = $this->usuarios_m->getAll();
		$this->data_view['faixa_etaria'] = $this->faixa_etaria_m->getAll();
		$this->loadView($this->data_view);
	}

	private function cabecalhoListagemTabelas($layout_id) {
		if(empty($layout_id)) return false;

		$table_header = null;
		switch ($layout_id) {
			case '1':
				$table_header.= '<th style="width: auto;">DESCRIÇÃO</th>';
				$table_header.= '<th style="width: 90px;">AÇÕES</th>';
			break;
			case '2':
				#$table_header.= '<th style="width: 70px;">ID TABELA</th>';
				$table_header.= '<th style="width: 72%;">DESCRIÇÃO MENU</th>';
				$table_header.= '<th style="width: auto;">NIVEL DE AÇÕES</th>';
		}
		return $table_header;
	}

	public function salvarGrupoUsuario() {
		/**
		 * Está rotina atuará como insert e update dos registros:
		 * Levando em consideração que:
		 *  - Quando for passando o ID do registro irá fazer o UPDATE.
		 */
		header('Content-type: application/json');
		$post = array($this->input->post());
		foreach ($post as $propriedade) {
			if(!empty($propriedade['grupo_descricao'])) {
				if(strlen($propriedade['grupo_descricao']) > 30) {
					print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => '<b>Campo Descrição</b> ultrapassou o limite permitido de 30 caracteres. Verifique e tente novamente', 'input' => 'grupo_descricao'));
					exit;
				}
			} else {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'É necessário informar um nome para este grupo de usuário.', 'input' => 'grupo_descricao'));
				exit;
			}

			if($propriedade['grupo_status'] == '') {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Favor defina o status do grupo de acesso', 'input' => 'grupo_status'));
				exit;
			}
		}

		$dados_grupo_usuario  = array (
			'descricao' => $post[0]['grupo_descricao'],
			'status' => isset($post[0]['grupo_status']) ? $post[0]['grupo_status'] : false
		);

		$grupo_codigo = isset($post[0]['grupo_codigo']) ? $this->seguranca->dec($post[0]['grupo_codigo']) : false;

		if(!$grupo_codigo) {
			// Faz insert e seta na variavel o 'id' do usuário .
			$idgrupousuario = $this->_insertRegistro($dados_grupo_usuario);
			if($idgrupousuario) {
				print json_encode(array('status' => 'sucesso', 'title' => $this->swall_titulo_sucesso, 'tipo' => $this->swall_tipo[1], 'message' => 'Grupo de usuário registrado com sucesso !', 'close' => $this->swall_timeout['nivel2']));
				exit;
			} else {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => 'Falha crítica ao salvar registro no banco de dados. Por favor contate a '.DESENVOLVEDOR_SISTEMA_NOME.'!!'));
				exit;
			}		
		} else {
			if($this->_updateRegistro($dados_grupo_usuario, $grupo_codigo)) {
				print json_encode(array('status' => 'sucesso', 'title' => $this->swall_titulo_sucesso, 'tipo' => $this->swall_tipo[1], 'message' => 'Grupo de usuário atualizado com sucesso!', 'close' => $this->swall_timeout['nivel3']));
				exit;
			}
		}
	}

	public function salvarDadosPermissoes() {
		header('Content-type: application/json');
		$post = json_decode(file_get_contents('php://input'), true);
		$grupo_usuario = $this->seguranca->dec($post['grupo_usuario_id']);

		if(!isset($post['dados']['acessos']) || (empty($post['dados']['acessos']))) {
			print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => '<b>Opções de acesso</b> não informadas. Por favor selecione pelo menos uma opção de menu', 'close' => $this->swall_timeout['nivel3']));
			exit;
		}
		if(!isset($post['grupo_usuario_id']) || (empty($post['grupo_usuario_id']))) {
			print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => '<b>Grupo de Usuário</b> não informado. Por favor selecione pelo menos uma opção', 'close' => $this->swall_timeout['nivel3']));
			exit;
		}
		$this->load->model('grupos_usuarios_acessos_m');
		foreach ($post['dados']['acessos'] as $key => $opcao) {
			//AQUI FUTURAMENTE DEVERÁ SER FATORADO.
			//EM RESUMO, VERIFICA SE O CONTEUDO PASSADO NO POST EXISTE NO BANCO, SE SIM, REMOVE-O. CASO CONTRARIO FAZ O INSERT APENAS DOS DADOS QUE NÃO EXISTE.
			$this->grupos_usuarios_m->_updateRegistro(array('modificacao' => date('Y-m-d H:i:s')), $grupo_usuario);
			if(!$this->grupos_usuarios_acessos_m->verificaSePermissaoExiste($grupo_usuario, $key)){
				$this->grupos_usuarios_acessos_m->_insertRegistro(array('grupo_usuario_id' => $grupo_usuario, 'permissao_tipo' => 1, 'menu_item_id' => $key));
			}
			
			foreach($opcao as $v) {
				if(!$this->grupos_usuarios_acessos_m->verificaSePermissaoExiste($grupo_usuario, $v['menu_item'])) {
					$this->grupos_usuarios_acessos_m->_insertRegistro(array('grupo_usuario_id' => $grupo_usuario, 'permissao_tipo' => $v['nivel_acesso'], 'menu_item_id' => $v['menu_item']));
				} else {
					//debug_array($v);exit;
					$this->grupos_usuarios_acessos_m->_updateRegistro(array('permissao_tipo' => $v['nivel_acesso']), $grupo_usuario, $v['menu_item']);
				}
			}
		}
		print json_encode(array('status' => 'sucesso', 'title' => $this->swall_titulo_sucesso, 'tipo' => $this->swall_tipo[1], 'message' => 'Definições de acesso realizadas com sucesso!', 'close' => $this->swall_timeout['nivel3']));
		exit;
	}

	private function _insertRegistro($dados_grupo_usuario){
		if(!$dados_grupo_usuario) {
			return false;
			exit;
		}
		$dados_grupo_usuario['criacao'] = date('Y-m-d H:i:s');
		$dados_grupo_usuario['usuario_criacao'] = $this->seguranca->dec($this->rsession->get('usuario_logado')['id_usuario']);
		$idgrupousuario = $this->grupos_usuarios_m->_insertRegistro($dados_grupo_usuario);
		return (!$idgrupousuario) ? false : $idgrupousuario;
	}

	private function _updateRegistro($dados_grupo_usuario, $grupo_codigo){
    if(!$dados_grupo_usuario && !$grupo_codigo) {
			return false;
			exit;
		}
		$dados_grupo_usuario['modificacao'] = date('Y-m-d H:i:s');
		$dados_grupo_usuario['usuario_modificacao'] = $this->seguranca->dec($this->rsession->get('usuario_logado')['id_usuario']);
		return $this->grupos_usuarios_m->_updateRegistro($dados_grupo_usuario, $grupo_codigo);
	}

	public function getListGroup() {
		$post = $this->input->post();
		$search = isset($post['search']) ? $post['search']['value'] : false;
		$length = isset($post['length']) ? $post['length'] : 25;
		$start = isset($post['start']) ? $post['start'] : 0;

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
		$grupos_usuarios = $this->grupos_usuarios_m->getAll($paramLimites, $search, $this->usuarioAdministrador);
		$listagem = $this->layoutListagemGeralGruposUsuarios($grupos_usuarios, $this->layout_coluna_id, $search);
		if(!$listagem) {
			print json_encode(array('status' => false, 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Nenhum dado encontrado'));
			exit;
		} else {
			$listagem['status'] = 'sucesso';
			print json_encode($listagem);
		}
	}

	private function layoutListagemGeralGruposUsuarios($dados, $layout_id, $search) {
		$ci	=& get_instance();
		if(empty($layout_id) || (!$dados)) {	
			return false;
		}
		foreach($dados as $r) {
			$data[] = $this->montaDadosLayout($layout_id, $r);
		}
		$t = $ci->grupos_usuarios_m->getAllCount($search, $this->usuarioAdministrador);
		return array("recordsTotal" => $t, "recordsFiltered" => $t, "data" => $data, "layout_list" => $layout_id);
	}

	private function montaDadosLayout($layout_id, $dados) {
		if(!isset($dados)) {
			return false;
		}
		$nivel_acesso = $this->permissoes->verificaAcesso($this->tabela_id_cr_up, $this->seguranca->dec($this->rsession->get('usuario_logado')['grupo_usuario_id']));
		$dados->idgrupousuario = $this->seguranca->enc($dados->id);
		$linha = $opcoes_botao = $delete = array();
		$delete_icon = $ativa_inativa = null;
		$total_usuarios_em_grupo =  getTotalUsuariosPorGrupo($dados->id) ? '  <small><b>Usuários neste grupo: </b></small><span class="badge badge-primary">'.getTotalUsuariosPorGrupo($dados->id).'</span>' : '';

		$delete = !$dados->deletado ? array(
			'd' => 'onclick="removerRegistro(this)" id="'. $dados->idgrupousuario.'" ',
			'a'	=> 'onclick="editarRegistro(this)" id="'. $dados->idgrupousuario.'"',
			'i' => 'onclick="mudarStatus(this)" id="'.$dados->idgrupousuario.'" data-value="'.$this->seguranca->enc($ativa_inativa['acao']).'"') : null;
		$delete_icon = $dados->deletado ? ' style="cursor: none; color:#C9C9C9;"' : '';

		$ativa_inativa = $dados->status ? 
		array('icon' => '<i class="fa fa-times icon-inativar"'.$delete_icon.'></i></a>', 'link' => '#1', 'title' => 'Desativar', 'acao' => 'inativar') : 
		array('icon' =>'<i class="fa fa-check icon-ativar"'.$delete_icon.'></i></a>', 'link' => '#2', 'title' => 'Ativar', 'acao' => 'ativar');

		$botao_delete = '<a '.$delete['d'].' title="Remover"><i class="icon-feather-trash-2 icons-size-2"'.$delete_icon.'></i></a>';
		$botao_alterar = '<a '.$delete['a'].' title="Atualizar"><i class="icon-feather-edit icons-size-2"'.$delete_icon.'></i></a>';
		$botao_ativa_inativa = '<a '.$delete['i'].' title="'.$ativa_inativa['title'].'" class="icons-size-2">'.$ativa_inativa['icon'].'</a>'; 

		/* 		$botao_ver_ficha = '<a onclick="abrirRegistro(this)" id="'.$dados->idgrupousuario.'" title="Abrir registro">
		<i class="fa fa-eye icons-size-2"></i></a>'; */

		$botao_alterar_permissoes = '<a onclick="alterarPermissoesGrupo(this)" id="'.$dados->idgrupousuario.'" title="Alterar permissões de acesso do grupo">
		<i class="fa fa-unlock icons-size-2"></i></a>';

		if($this->usuarioAdministrador) {
			$opcoes_botao[] = 
			'<div style="margin:5px; text-align: left !important;">'. $botao_alterar_permissoes . $botao_ativa_inativa . $botao_alterar . $botao_delete . '</div>';
		} else {
			if($nivel_acesso >= 2 ) {
				$opcoes_botao[] = '<div style="margin:5px; text-align: left !important;">'. $botao_alterar .'</div>';
			} else {
				$opcoes_botao[] = '<div style="margin:5px; text-align: left !important;">'.$botao_alterar .'</div>';
			}
		}

		if($layout_id == 1) {
			$linha[$this->stringController.'_descricao']	= $dados->descricao . $total_usuarios_em_grupo;
			$linha[$this->stringController.'_botoes']	= is_array($opcoes_botao) ? implode($opcoes_botao) : $opcoes_botao;
		}
		return $linha;
	}

	public function removerRegistro() {
		$post = json_decode(file_get_contents('php://input'));
		
		if(empty($post->grupo_usuario_id)) {
			print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => ' Parametros inválido, verifique e tente novamente.'));
			exit;
		}

		$post = array('grupo_usuario_id' => $this->seguranca->dec($post->grupo_usuario_id));
		// Verifica se registro esta em uso, caso contrário continua o processo
 		if(!empty(verificaUsoGrupoUsuario($post['grupo_usuario_id']))) {
			print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => 'Existe usuário(s) vinculados a este grupo. Desfaça os vinculos destes usuários para que seja possivel fazer a remoção.'));
			exit;
			return;				
		}/*

		FAZER AQUI A LÓGICA PARA REMOÇÃO DO GRUPO DE USUARIO BASEANDO-SE NA QUESTÃO DE NÃO HAVER MOVIMENTAÇÃO COM O CÓDIGO DO USUÁRIO,*/
		if($this->_deleteGrupoUsuario($post)){
			print json_encode(array('status' => 'sucesso', 'title' => $this->swall_titulo_sucesso, 'tipo' => $this->swall_tipo[1], 'message' => 'Grupo de Usuário removido com sucesso!', 'close' => $this->swall_timeout['nivel3']));
			exit;
		} else {
			print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => ' Falha ao atualizar a situação desta equipe, verifique e tente novamente.'));
			exit;
		}
	}

	public function detalhe_registro($id_participante) {
		if($id_participante) {
			try{
				$dadosParticipante = $this->participantes_m->getParticipante($this->seguranca->dec($id_participante));
				if($dadosParticipante) {
					$dadosParticipante->idparticipante = $this->seguranca->enc($dadosParticipante->idparticipante);
					$this->data_view['title_page'] = GRP_USUARIO_CABECALHO_PAGINA;
					$this->data_view['titulo_home'] = $this->assets->header['titulo_home'];
					$this->data_view['titulo_home2'] = PARTICIPANTE_TITULO_DETALHES;
					$this->data_view['dadosParticipante'] = $dadosParticipante;
					$this->data_view['estados'] = $this->estados_m->getAll();
					$this->data_view['estado_civil'] = $this->estado_civil_m->getAll();
					$this->data_view['equipes'] = $this->usuarios_m->getAll();
					$this->data_view['faixa_etaria'] = $this->faixa_etaria_m->getAll();
					$this->data_view['disabled_input'] = "readonly";
					$this->loadView($this->data_view);
				} else {
					redirect('/participante');
				}
			} catch (Exception $e) {
				return false;
			}
		}
	}

	public function getGrupoUsuario() {
		$post = json_decode(file_get_contents('php://input'));
		
		//GET ID DO GRUPO DE USUARIO VIA REQUISIÇÃO
		$grupo_usuario_id = isset($post->grupo_usuario_id) ?  intval($this->seguranca->dec($post->grupo_usuario_id)) : false;

		if(isset($grupo_usuario_id) && is_integer($grupo_usuario_id)) {
			$dados_grupo = $this->grupos_usuarios_m->getById($grupo_usuario_id);
			if(!empty($dados_grupo)) {
				$dados_grupo->id = $this->seguranca->enc($dados_grupo->id);
				$dados_grupo->usuario_criacao = $this->seguranca->enc($dados_grupo->usuario_criacao);
				$dados_grupo->usuario_modificacao = $this->seguranca->enc($dados_grupo->usuario_modificacao);
				$dados_grupo->usuario_deletado = $this->seguranca->enc($dados_grupo->usuario_deletado);
				print json_encode(array('status' => 'sucesso', 'dados' => $dados_grupo));exit;
			} else {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => 'Não foi possivel encontrar nenhum registro. Verifique e tente novamente'));
				exit;
			}
		} else {
			print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => ' Parametros inválido, verifique e tente novamente'));
			exit;
		}
	}

	public function getPermissoesGrupoUsuario() {
		$post = json_decode(file_get_contents('php://input'));
		
		//GET ID DO GRUPO DE USUARIO VIA REQUISIÇÃO
		$grupo_usuario_id = isset($post->grupo_usuario_id) ?  intval($this->seguranca->dec($post->grupo_usuario_id)) : false;
		if(isset($grupo_usuario_id) && is_integer($grupo_usuario_id)) {
			
			//GET PERMISSÕES DE ACESSO DO GRUPO
			$dados_permissoes_grupo = $this->grupos_usuarios_acessos_m->getAcessosGrupoUsuarioById($grupo_usuario_id);
			if(!empty($dados_permissoes_grupo)) {
				$permissoes = array();
				$opcoes = [];
				
				foreach($dados_permissoes_grupo as $opcao) {
					
					//PERCORRE AS PERMISSÕES DO GRUPO E VERIFICA SE UM DOS ITENS É SUB-MENU E COM ISSO FAZ DELE UMA CHAVE DO OBJETO.
					if($opcao->sub_menu == 1) {

						//VERIFICA SE CHAVE EXISTE NO ARRAY DE PERMISSÕES
						if(!array_key_exists($opcao->menu_item_id, $permissoes)) {

							//CRIA O OBJETO COM O MENU PAI
							$opcoes['acessos'][$opcao->menu_item_id] = array();
							$id_pai = $opcao->menu_item_id;
						}
					}
					
					//ADICIONA AS PERMISSÕES PERTENCENTES AO ARRAY DO MENU PAI CORRESPONDENTE.
					array_push($opcoes['acessos'][$id_pai], array('menu_item' => $opcao->menu_item_id, 'nivel_acesso' => $opcao->permissao_tipo));
				}
				print json_encode(array('status' => 'sucesso', 'dados' => $opcoes));
				exit;
			} else {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Este grupo não possui nenhuma permissão de acesso definida. Deseja fazer agora ?'));
				exit;
			}
		} else {
			print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => ' Parametros inválido, verifique e tente novamente'));
			exit;
		}
	}
	
	public function mudarStatus() {
		$post = json_decode(file_get_contents('php://input'));
		
		if(empty($post->grupo_usuario_id) && empty($post->acao)) {
			print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => ' Parametros inválido, verifique e tente novamente.'));
			exit;
		}

		$post = array( 'acao' => $this->seguranca->dec($post->acao), 'grupo_usuario_id' => $this->seguranca->dec($post->grupo_usuario_id));
		if($this->_updateStatusGrupoUsuario($post)){
			print json_encode(array('status' => 'sucesso', 'title' => $this->swall_titulo_sucesso, 'tipo' => $this->swall_tipo[1], 'message' => 'Situação alterada com sucesso!', 'close' => $this->swall_timeout['nivel3']));
			exit;
		} else {
			print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => ' Falha ao atualizar a situação desta equipe, verifique e tente novamente.'));
			exit;
		}
	}

	public function cancelarOpcaoDeAcesso() {
		$post = json_decode(file_get_contents('php://input'));
		
		if(empty($post->permissao_id) && empty($post->grupo_usuario)) {
			print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => ' Parametros inválido, verifique e tente novamente.'));
			exit;
		}

		$post = array('grupo_usuario_id' => $this->seguranca->dec($post->grupo_usuario), 'menu_item_id' => $post->permissao_id);
		if($this->_deleteOpcaoAcesso($post)){
			print json_encode(array('status' => 'sucesso', 'title' => $this->swall_titulo_sucesso, 'tipo' => $this->swall_tipo[1], 'message' => 'Permissão de acesso removida com sucesso!', 'close' => $this->swall_timeout['nivel3']));
			exit;
		} else {
			print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => ' Falha ao remover a permissão deste grupo de usuário, verifique e tente novamente.'));
			exit;
		}
	}

	private function _updateStatusGrupoUsuario($post) {
		if(!$post) {
			return false;
		} else {
			
			if($post['acao'] == "inativar") {
				return $this->grupos_usuarios_m->_updateStatusGrupoUsuario($post['grupo_usuario_id'], array('status' => 0, 'modificacao' => date('Y-m-d H:i:s'), 'usuario_modificacao' => $this->seguranca->dec($this->rsession->get('usuario_logado')['id_usuario'])));
			}
			if($post['acao'] == "ativar") {
				return $this->grupos_usuarios_m->_updateStatusGrupoUsuario($post['grupo_usuario_id'], array('status' => 1, 'modificacao' => date('Y-m-d H:i:s'), 'usuario_modificacao' => $this->seguranca->dec($this->rsession->get('usuario_logado')['id_usuario'])));
			}
		}
	}

	private function _deleteOpcaoAcesso($post) {
		if(!$post) {
			return false;
		} else {
			return $this->grupos_usuarios_acessos_m->_deleteOpcaoAcesso($post);
		}
	}

	private function _deleteGrupoUsuario($post) {
		if(!$post) {
			return false;
		} else {
			return $this->grupos_usuarios_m->_deleteGrupoUsuario($post['grupo_usuario_id'], array('status' => false, 'deletado' => true, 'deletado_data' => date('Y-m-d H:i:s'), 'usuario_deletado' => $this->seguranca->dec($this->rsession->get('usuario_logado')['id_usuario'])));
		}
	}
}