<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

	public $data_view;

	public function __construct() {
		parent::__construct();
		$this->load->library("assets", array(
			'header' => array('titulo' => "Login", 'subtitulo' => null),
			'libs_js' => null,
			'js' => "modulos/login/LoginController"
		));
		if(!empty($_SESSION['erro'.SIGLA_SESSAO_SISTEMA])) {
			$this->data_view['erro'] = $this->rsession->get('erro');
		}
		$this->stringController = "login";
		$this->load->model(array('usuarios_m','permissoes_m'));
	}

	public function index() {
		if($this->rsession->get("logged")) {
			redirect(base_url() . "index");
		}		
		// $this->data['title_form_login'] = NOME_CURTO_SISTEMA.'<br><small>Identifique-se para começar!</small>';
		$this->loadView(false, false, false);
	}

	public function autenticacao() {
		$post = $this->input->post();
		$email = $post['email'];
		$senha = $post['senha'];

		if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
			if($this->validaDadosLogin($email, $senha)) {
				redirect(base_url() .'index');
			} else {
				$this->setMensagemStatus("<b>Login Inválido</b>. Verifique os dados fornecidos e tente novamente",false);
				redirect (base_url().'login');				
			}
		} else {
			$this->setMensagemStatus("<b>E-mail</b> de acesso inválido",false);
			redirect (base_url().'login');
		}
	}

	private function validaDadosLogin($email, $senha){
		if(!isset($email) || (empty($email))) {
			return false;
			exit;
		}
		if(!isset($senha) || (empty($senha))) {
			return false;
			exit;
		}
		
		//VERIFICAR SE ESTRUTURA DE EMAIL É VÁLIDA
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			return false;
		}

		//VERIFICAR SE SENHA É VÁLIDA
		if(!isset($senha) || empty($senha)){
			return false;
		}
		return $this->_getDadosDB($senha, $email);
	}

	private function _getDadosDB($senha, $email){
		if(isset($senha) || (!empty($senha))) {
			if(isset($email) || (!empty($email))) {
				$dadosLogin = new stdClass();
				$email = strtolower($email);
				$dadosLogin->senha = $this->seguranca->geraSenha($senha, $email);
				$dadosLogin->email = $email;
				//debug_array($dadosLogin);exit;
				$id_usuario = $this->usuarios_m->validarUsuario($dadosLogin);
				//debug_array($id_usuario);exit;
				if(!empty($id_usuario)) {
					$this->rsession->set('logged', true);
					$this->setAcessosUsuario($this->seguranca->enc($id_usuario));
					return true;
				}
				return false;
			}		
			return false;
		}
		return false;
	}

	private function setAcessosUsuario($id_usuario) {
		if(!$id_usuario) {
			return false;
		}
	
		
		/*** GERA A QUANTIDADE DE ACESSOS REALIZADOS PELO USUARIO NO SISTEMA */
		$dados_usuario = getDadosUsuario($this->seguranca->dec($id_usuario));
		$coutAcessos['acessos'] = (empty($dados_usuario->acessos)) ? 1 : $dados_usuario->acessos + 1;
		$this->usuarios_m->coutAcessos($coutAcessos, $this->seguranca->dec($id_usuario));
		/*** FIM - GERA A QUANTIDADE DE ACESSOS REALIZADOS PELO USUARIO NO SISTEMA */
		
		if(!$dados_usuario) {
			return false;
			exit;
		}
		
		/*** REGISTRA DADOS DO USUARIO EM VARIAVEIS DE SESSÃO */
		$sessao_dados_usuario = array(
			'id_usuario' => $this->seguranca->enc($dados_usuario->idusuario),
			'email_usuario' => $dados_usuario->login,
			'usuario_display' => $dados_usuario->usuario_nome_display,
			'usuario_nomecompleto' => $dados_usuario->usuario_primeiro_nome,
			'usuario_atribuicao_funcao' => $dados_usuario->descricao_curta_atribuicao,
			'usuario_foto' => $this->fotoPerfilUsuario($dados_usuario),
			'usuario_genero' => $dados_usuario->genero,
			'grupo_usuario_id' => $this->seguranca->enc($dados_usuario->grupo_usuario_id),
			'usuario_administrador' => $dados_usuario->administrador ? true : false,
			'permissoes' => array(
				'id_tabelas' => getTabelasComPermissaoDeAcesso_ByGrupoAcessoId($dados_usuario->grupo_usuario_id)
			)
		);
		/*** FIM - REGISTRA DADOS DO USUARIO EM VARIAVEIS DE SESSÃO */
		$this->rsession->set('usuario_logado',$sessao_dados_usuario);
	}

	private function fotoPerfilUsuario($dados_usuario) {
		if(!$dados_usuario) {
			return false;
		}
		if(empty($dados_usuario->usuario_foto_nome)) {
			if($dados_usuario->genero == 'm') {
				$foto = 'user_m.jpg';
			} else {
				$foto = 'user_f.jpg';
			}
		} else {
			$foto = $dados_usuario->usuario_foto_nome.$dados_usuario->usuario_foto_extensao;
		}
		return $foto;
	}


	public function sair() {
		$this->rsession->destruir_sessoes();
		redirect(base_url(). 'login');
	}
}