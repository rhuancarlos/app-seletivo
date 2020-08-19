<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paginas extends MY_Controller {

	public $data_view;
	private $tabela_id = 1420;
	private $tabela_id_r = 1437;
	private $tabela_id_cr_up = 1437;

	public function __construct() {
		parent::__construct();
		$this->permissoes->verificaLogado();
		$this->stringController = "usuarios";
		$this->load->library("assets", array(
			'header' => array( 
				'titulo_home' => "Usuários", 
				'titulo_pagina_cadastro' => "Cadastro de Usuários", 'subtitulo' => null,
				'titulo_pagina_editar' => "Atualização de Usuários", 'subtitulo' => null
			),
			'js' => 'modulos/usuarios/usuarios'
		));
		$this->load->model(array('usuarios_m','participantes_m', 'grupos_usuarios_m', 'usuarios_perfil_m','atribuicoes_m'));
		$this->usuarioAdministrador = $this->rsession->get('usuario_logado')['usuario_administrador'];
		$this->layout_coluna_id     = $this->layout_listagem_id = 1;
	}

	public function index() {
		$this->permissoes->verificaAcesso($this->tabela_id_r, $this->seguranca->dec($this->rsession->get('usuario_logado')['grupo_usuario_id']));
		$this->data_view['title_page'] = USUARIO_CABECALHO_PAGINA;
		$this->data_view['titulo_home'] = $this->assets->header['titulo_home'];
		$this->data_view['titulo_home2'] = '';
		$this->data_view['controller'] = $this->stringController;
		$this->data_view['participantes'] = $this->participantes_m->getAll();
		$this->data_view['grupos_acessos'] = $this->grupos_usuarios_m->getAll();
		$this->data_view['atribuicoes'] = $this->atribuicoes_m->getAll();
		$this->data_view['list_table_th'] = $this->cabecalhoListagemTabelas($this->layout_coluna_id);
		if($this->rsession->get('usuario_logado')['usuario_administrador']) {
			$n = 'full';
		} else{
			$n = $this->permissoes->verificaAcesso($this->tabela_id_cr_up, $this->seguranca->dec($this->rsession->get('usuario_logado')['grupo_usuario_id']));
		}
		$this->data_view['nivel_acoes'] = $n;#$this->permissoes->verificaAcesso($this->tabela_id_cr_up, $this->seguranca->dec($this->rsession->get('usuario_logado')['grupo_usuario_id']));
		$this->loadView($this->data_view);
	}
	
	public function cadastrar() {
		$this->data_view['title_page'] = USUARIO_CABECALHO_PAGINA;
		$this->data_view['titulo_home'] = $this->assets->header['titulo_home'];
		$this->data_view['titulo_home2'] = PARTICIPANTE_TITULO_REGISTRO;
		$this->data_view['titulo_pagina'] = $this->assets->header['titulo_pagina_cadastro'];
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

	/**
	 * Está rotina atuará como insert e update dos registros:
	 * Levando em consideração que:
	 *  - Quando for passando o ID do registro irá fazer o UPDATE.
	 */
	public function salvarUsuario() {
		header('Content-type: application/json');
		$post = array($this->input->post());
		$dados_tabela_usuario = $dados_tabela_perfil_usuario = array();
		
		#debug_array($post[0]);
		foreach ($post as $propriedade) {
			if(empty($propriedade['usuario_vinculo_participante'])) {
				if(!empty($propriedade['usuario_nome'])) {
					if(strlen($propriedade['usuario_nome']) < 10) {
						print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Informe um sobrenome', 'input' => 'usuario_nome'));
						exit;
					}
				} else {
					print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'É necessário vincular um participante ao usuário ou informar o nome completo do usuário.', 'input' => 'usuario_nome'));
					exit;
				}
			}

			if(!empty($propriedade['usuario_nome_display'])) {
				if(strlen($propriedade['usuario_nome_display']) < 2) {
					print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Nome display muito curto, favor informe mais dados.', 'input' => 'usuario_nome_display'));
					exit;
				}
				if(strlen($propriedade['usuario_nome_display']) > 20) {
					print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Nome display muito longo, o limite permitido é de apenas 20 caracteres.', 'input' => 'usuario_nome_display'));
					exit;
				}
			}

			if(empty($propriedade['usuario_grupo_acesso'])) {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Favor defina o grupo de acesso', 'input' => 'usuario_grupo_acesso'));
				exit;
			}

			if(!filter_var($propriedade['usuario_email'], FILTER_VALIDATE_EMAIL)){
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'E-mail inválido. Verifique a informação fornecida e tente novamente.', 'input' => 'usuario_email'));
				exit;
			}

			if(!empty($propriedade['usuario_telefone'])) { 
				if(strlen(removePontuacao($propriedade['usuario_telefone'], 'telefone')) != 11) {
					print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Telefone inválido. Verifique a informação fornecida e tente novamente.', 'input' => 'participante_telefone'));
					exit;					
				}
			}

			if(!empty($propriedade['usuario_senha'])){
				if($propriedade['usuario_senha'] != $propriedade['usuario_senha_repetir']) {
					print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => '<b>As senhas não coincidem</b>.Verifique e tente novamente.', 'input' => 'usuario_senha_repetir'));
					exit;	
				}
			}
		}
		
		$dadosParcicipante = isset($post[0]['usuario_vinculo_participante']) ? getDadosParticipante($this->seguranca->dec($post[0]['usuario_vinculo_participante'])) : false;

		$dados_tabela_usuario  = array (
			'grupo_usuario_id' => $this->seguranca->dec($post[0]['usuario_grupo_acesso']),
			'login' => $post[0]['usuario_email'],
			'id_cadparticipante' => isset($post[0]['usuario_vinculo_participante']) ? $this->seguranca->dec($post[0]['usuario_vinculo_participante']) : false,
			'status' => 1,
			'administrador' => isset($post[0]['usuario_administrador']) ? $post[0]['usuario_administrador'] == 'on' ? 1 : 0 : 0,
			'ip_cadastro' => getInfoServerAmbience('REMOTE_ADDR')
		);
		if(!empty($post[0]['usuario_senha'])) {
			$dados_tabela_usuario['senha'] = $this->seguranca->geraSenha($post[0]['usuario_senha'], strtolower($post[0]['usuario_email']));
		}

		$dados_tabela_perfil_usuario = array (
			'usuario_primeiro_nome' => !empty($post[0]['usuario_nome']) ? $post[0]['usuario_nome'] : $dadosParcicipante->prt_nomecompleto,
			'usuario_nome_display' => empty($post[0]['usuario_nome_display']) ? 'Visitante '.substr($dadosParcicipante->prt_nomecompleto,0,5) : $post[0]['usuario_nome_display'],
			'usuario_telefone' => removePontuacao($post[0]['usuario_telefone'], 'telefone'),
			'genero' => isset($post[0]['usuario_genero']) ? $post[0]['usuario_genero'] : '',
			'atribuicao_id' => isset($post[0]['usuario_atribuicao']) ? $this->seguranca->dec($post[0]['usuario_atribuicao']) : ''
		);

		$codigo_usuario = isset($post[0]['usuario_codigo']) ? $this->seguranca->dec($post[0]['usuario_codigo']) : false;
		if(!$codigo_usuario) {
			// Verifica se registro já existe, caso contrário continua o processo
			if($this->usuarios_m->getUsuario(false, $dados_tabela_usuario['login'])) {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => ' Usuário <b>'.$dados_tabela_usuario['login'].'</b> já existe. Verifique a informação fornecida e tente novamente.'));
				exit;
				return;				
			}
			// Faz insert e seta na variavel o 'id' do usuário .
			$idusuario = $this->_insertRegistro($dados_tabela_usuario, $dados_tabela_perfil_usuario);
			if($idusuario) {
				print json_encode(array('status' => 'sucesso', 'title' => $this->swall_titulo_sucesso, 'tipo' => $this->swall_tipo[1], 'message' => 'Usuário registrado com sucesso !', 'close' => $this->swall_timeout['nivel2']));
				exit;
			} else {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => 'Falha crítica ao salvar registro no banco de dados. Por favor contate a '.DESENVOLVEDOR_SISTEMA_NOME.'!!'));
				exit;
			}		
		} else {
			if($this->_updateRegistro($dados_tabela_usuario, $dados_tabela_perfil_usuario, $codigo_usuario)) {
				print json_encode(array('status' => 'sucesso', 'title' => $this->swall_titulo_sucesso, 'tipo' => $this->swall_tipo[1], 'message' => 'Usuário atualizado com sucesso!', 'close' => $this->swall_timeout['nivel3']));
				exit;
			}
		}
	}

	public function getListUsers() {
		$post = $this->input->post();
		//$tipoDados  = array('ativo', 'inativo', 'removido');
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
		$usuarios = $this->usuarios_m->getAll($paramLimites, $search);
		$listagem = $this->layoutListagemGeralUsuarios($usuarios, $this->layout_coluna_id, $search);
		if(!$listagem) {
			print json_encode(array('status' => false, 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Nenhum dado encontrado'));
			exit;
		} else {
			$listagem['status'] = 'sucesso';
			print json_encode($listagem);
		}
	}

	private function layoutListagemGeralUsuarios($dados, $layout_id, $search) {
		$ci	=& get_instance();
		if(empty($layout_id) || (!$dados)) {
			return false;
		}
		foreach($dados as $r) {
			$data[] = $this->montaDadosLayout($layout_id, $r);
		}
		$t = $ci->usuarios_m->getAllCount($search);
		return array("recordsTotal" => $t, "recordsFiltered" => $t, "data" => $data, "layout_list" => $layout_id);
	}

	public function detalhe_registro($id_participante) {
		if($id_participante) {
			try{
				$dadosParticipante = $this->participantes_m->getParticipante($this->seguranca->dec($id_participante));
				if($dadosParticipante) {
					$dadosParticipante->idparticipante = $this->seguranca->enc($dadosParticipante->idparticipante);
					$this->data_view['title_page'] = USUARIO_CABECALHO_PAGINA;
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

	public function getUsuario() {
		$post = json_decode(file_get_contents('php://input'));
		$usuario_id = isset($post->usuario_id) ?  intval($this->seguranca->dec($post->usuario_id)) : false;
		if(isset($usuario_id) && is_integer($usuario_id)) {
			$dados_usuario = $this->usuarios_m->getUsuario($usuario_id);
			if(!empty($dados_usuario)) {
				$dados_usuario->idusuario = $this->seguranca->enc($dados_usuario->idusuario);
				$dados_usuario->grupo_usuario_id = $this->seguranca->enc($dados_usuario->grupo_usuario_id);
				$dados_usuario->id_cadparticipante = $this->seguranca->enc($dados_usuario->id_cadparticipante);
				$dados_usuario->atribuicao_id = $this->seguranca->enc($dados_usuario->atribuicao_id);
				$dados_usuario->idperfilusuario = $this->seguranca->enc($dados_usuario->idperfilusuario);
				print json_encode(array('status' => 'sucesso', 'dados' => $dados_usuario));exit;
			} else {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => 'Não foi possivel encontrar nenhum registro. Verifique e tente novamente'));
				exit;
			}
		} else {
			print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => ' Parametros inválido, verifique e tente novamente'));
			exit;
		}
	}

	private function montaDadosLayout($layout_id, $dados) {
		if(!isset($dados)) {
			return false;
		}
		$dados->idusuario = $this->seguranca->enc($dados->idusuario);
		$dados->grupo_usuario_id = $this->seguranca->enc($dados->grupo_usuario_id);
		$dados->idperfilusuario = $this->seguranca->enc($dados->idperfilusuario);
		$linha = $opcoes_botao = array();

		$ativa_inativa = $dados->status ? 
		array('icon' => '<i class="fa fa-times icon-inativar "></i></a>', 'link' => '#1', 'title' => 'Desativar', 'acao' => 'inativar') : 
		array('icon' =>'<i class="fa fa-check icon-ativar"></i></a>', 'link' => '#2', 'title' => 'Ativar', 'acao' => 'ativar');

		/*$botao_remover = '<a onclick="removerRegistro(this)" id="'. $dados->idusuario.'" title="Remover">
		<i class="icon-feather-trash-2 icons-size-2"></i></a>';*/

		$botao_alterar = '<a onclick="editarRegistro(this)" id="'. $dados->idusuario.'" title="Atualizar">
		<i class="icon-feather-edit icons-size-2"></i></a>';
		/* 		
			$botao_ver_ficha = '<a onclick="abrirRegistro(this)" id="'.$dados->idusuario.'" title="Abrir registro">
			<i class="fa fa-eye icons-size-2"></i></a>';
		*/
		$botao_ativa_inativa = '<a class="icons-size-2" onclick="mudarStatus(this)" id="'.$dados->idusuario.'" title="'.$ativa_inativa['title'] .'" 
		data-value="'.$this->seguranca->enc($ativa_inativa['acao']).'">'.$ativa_inativa['icon'].'</a>'; 

		if($this->usuarioAdministrador) {
			$opcoes_botao[] = 
			'<div style="margin:5px; text-align: left !important;">'.$botao_ativa_inativa . $botao_alterar . /*$botao_remover .*/ '</div>';
		} else {
			$opcoes_botao[] = 
			'<div style="margin:5px; text-align: left !important;">'. $botao_alterar .'</div>';
		}

		if($layout_id == 1) {
			$linha[$this->stringController.'_nomecompleto']	= $dados->usuario_primeiro_nome;
			$linha[$this->stringController.'_grupo_acesso'] = $dados->grupo_usuario_descricao;
			$linha[$this->stringController.'_email']				= $dados->login;
			$linha[$this->stringController.'_botoes']				= is_array($opcoes_botao) ? implode($opcoes_botao) : $opcoes_botao;
		}
		return $linha;
	}

	private function _insertRegistro($dados_tabela_usuario, $dados_tabela_perfil_usuario){
		if(!$dados_tabela_usuario && $dados_tabela_perfil_usuario) {
			return false;
			exit;
		}
		$dados_tabela_usuario['criacao'] = date('Y-m-d H:i:s');
		$dados_tabela_usuario['usuario_criacao'] = $this->seguranca->dec($this->rsession->get('usuario_logado')['id_usuario']);
		$idusuario = $this->usuarios_m->_insertRegistro($dados_tabela_usuario, $dados_tabela_perfil_usuario);
		return (!$idusuario) ? false : $idusuario;
	}

	private function _updateRegistro($dados_tabela_usuario, $dados_tabela_perfil_usuario, $codigo_usuario){
    if(!$dados_tabela_usuario && !$dados_tabela_perfil_usuario && !$codigo_usuario) {
			return false;
			exit;
		}
		$dados_tabela_usuario['data_modificacao'] = date('Y-m-d H:i:s');
		$dados_tabela_usuario['usuario_modificacao'] = $this->seguranca->dec($this->rsession->get('usuario_logado')['id_usuario']);
		return $this->usuarios_m->_updateRegistro($dados_tabela_usuario, $dados_tabela_perfil_usuario, $codigo_usuario);
	}

	public function mudarStatus() {
		$post = json_decode(file_get_contents('php://input'));
		
		if(empty($post->usuario_id) && empty($post->acao)) {
			print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => ' Parametros inválido, verifique e tente novamente.'));
			exit;
		}

		$post = array( 'acao' => $this->seguranca->dec($post->acao), 'usuario_id' => $this->seguranca->dec($post->usuario_id));
		if($this->_updateStatusUsuario($post)){
			print json_encode(array('status' => 'sucesso', 'title' => $this->swall_titulo_sucesso, 'tipo' => $this->swall_tipo[1], 'message' => 'Situação alterada com sucesso!', 'close' => $this->swall_timeout['nivel3']));
			exit;
		} else {
			print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => ' Falha ao atualizar a situação desta equipe, verifique e tente novamente.'));
			exit;
		}
	}

	private function _updateStatusUsuario($post) {
		if(!$post) {
			return false;
		} else {
			
			if($post['acao'] == "inativar") {
				return $this->usuarios_m->_updateStatusUsuario($post['usuario_id'], array('status' => 0, 'data_modificacao' => date('Y-m-d H:i:s'), 'usuario_modificacao' => $this->seguranca->dec($this->rsession->get('usuario_logado')['id_usuario'])));
			}
			if($post['acao'] == "ativar") {
				return $this->usuarios_m->_updateStatusUsuario($post['usuario_id'], array('status' => 1, 'data_modificacao' => date('Y-m-d H:i:s'), 'usuario_modificacao' => $this->seguranca->dec($this->rsession->get('usuario_logado')['id_usuario'])));
			}
		}
	}

	public function validarCredenciaisUsuario() {
		header('Content-type: application/json');
		$post = array(json_decode(file_get_contents('php://input')));

		if(empty($post) || !isset($post)){
			print json_encode(array('status' => false, 'message' => 'Error: Estes dados são inválidos'));
			exit;
		}

		foreach($post as $propriedade) {
			//Aqui verifica se o login existe ou se a string não é do tipo email
			if(!isset($propriedade->login) || (!filter_var($propriedade->login, FILTER_VALIDATE_EMAIL))) {
				print json_encode(array('status' => false, 'message' => 'E-mail inválido. Favor informe um email válido para continuar.'));
				exit;
			} else {
				//Caso seja valido faz get no banco para pegar o dados do usuário, conforme email, e atribui a varivel '$_getDBUser'
				$_getDBUser = getDadosUsuario(false,strtolower($propriedade->login),true);
				if(!$_getDBUser){
					print json_encode(array('status' => false, 'message' => 'E-mail não encontrado. Favor verifique e tente novamente.'));
					exit;
				}
			}
			//Aqui verifica se a senha existe ou se é um campo vazio
			if(!isset($propriedade->senha) || (empty($propriedade->senha))) {
				print json_encode(array('status' => false, 'message' => 'Senha inválida. Favor verifique e tente novamente.'));
				exit;
			}else {
				//Aqui depois de validar o email --> pegar os dados --> validar se a senha passada é a mesma registrada no banco, então dar a autenticação como ok
				$_credencial_senha = $this->seguranca->geraSenha($propriedade->senha, strtolower($propriedade->login));
				if($propriedade->login == $_getDBUser->login && $_credencial_senha == $_getDBUser->senha) {
					print json_encode(array('status' => true, 'message' => 'Credenciais Autorizada'));
					exit;
				} else {
					print json_encode(array('status' => false, 'message' => 'Credenciais não autorizadas. Favor verifique e tente novamente.'));
					exit;
				}
			}
		}
	}
}
