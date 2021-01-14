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

	public function autenticacao() {
		$post = $this->input->post();
		$email = $post['email'];
		$senha = $post['senha'];

		if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
			if($this->validaDadosLogin($email, $senha)) {
				redirect(base_url() .'administrador.php/painel');
			} else {
				$this->setMensagemStatus("<b>Login Inválido</b>. Verifique os dados fornecidos e tente novamente",false);
				redirect (base_url().'administrador.php');
			}
		} else {
			$this->setMensagemStatus("<b>E-mail</b> de acesso inválido",false);
			redirect (base_url().'administrador.php');
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
				$usuario = $this->usuarios_m->validarUsuario($dadosLogin);
				if(!empty($usuario)) {
					$this->rsession->set('logged', true);
					$this->rsession->set('user_id', $usuario->idusuario);
					$this->rsession->set('user_name', $usuario->login);
					return true;
				}
				return false;
			}		
			return false;
		}
		return false;
	}

	public function sair() {
		$this->rsession->destruir_sessoes();
		redirect(base_url(). 'administrador.php');
	}
}