<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Permissoes {

	/**
	 * Variavel para armazenar os tipo de usuarios que poderão ter acesso
	 *
	 * @var array
	 */
	private $tipo_usuarios = array();

	/**
	 * Armazena a instancia do codeigniter dentro da classe
	 *
	 * @var string
	 */
	private $CI;

	public function __construct() {
		$this->CI = &get_instance();
		$this->CI->load->model(array('permissoes_m'));
	}

	public function verificaLogado($url_redirect = false) {
		$logado = $this->CI->rsession->get("logged");
		$acesso = false;
		$paginaAtual = $_SERVER["REQUEST_URI"];
		if ($logado == "true") {
			$acesso = true;
		}
		if(!$acesso) {
			$this->CI->rsession->set("erro", "Você precisa estar logado para continuar, realize login.");
			if ($url_redirect) {
				redirect($url_redirect);
			} else {
				redirect(base_url() . "administrador.php/");
			}
		}
	}

	public function verificaAcesso($tabela_id = false, $grupo_usuario_id = false) {
		if(!$tabela_id && !$grupo_usuario_id) {
			return false;
		} else { 
			$retorno = $this->CI->permissoes_m->verificaAcesso($tabela_id, (int) $grupo_usuario_id);
			if (empty($retorno->permissao_tipo)) {
				$_SESSION['acesso_negado'] = '<strong>Opss!!</strong> Você não tem permissão para esta página.'; 
				echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL= ' . URL . '">';
				exit;
				//header("Location: ../index.php");
			} else if ($retorno->permissao_tipo == 1) {
				//echo '[Acesso a somente leitura]';
			} else if ($retorno->permissao_tipo == 2) {
				//echo '[Acesso a leitura e salvar dados]';
			} else if ($retorno->permissao_tipo == 3) {
				//echo '[Acesso total]';
			} return $retorno->permissao_tipo;
			//} $_SESSION['nivel_acoes_permissao'] = $retorno->permissao_tipo;
		}
	}
	
}
