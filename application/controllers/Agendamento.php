<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agendamento extends MY_Controller {
	
	private $debugEmail = false;
	public $data_view;

	public function __construct() {
		parent::__construct();
		$this->load->library("assets", array(
			'header' => array('titulo' => null, 'subtitulo' => null),
			'css' => '',
			'libs_js' => '',
			'js' => ''
		));
		$this->stringController = "agendamento";
		$this->load->model(array("parametros_m", "inscricoes_m"));
	}

	public function saveScheduling() {
		header('Content-type: application/json');
		$post = json_decode(file_get_contents('php://input'));
		$validacaoDados = $this->_validarDados($post->dados_pessoais);
		if(!is_array($validacaoDados)) {
			$dados = array(
				'nome_completo' => strtoupper($post->dados_pessoais->nome_completo),
				'colegio_atual' => strtoupper($post->dados_pessoais->colegio_atual),
				'email' => $post->dados_pessoais->email,
				'telefone' => $post->dados_pessoais->telefone,
				'serie' => $post->dados_pessoais->serie,
			);
			
			try {
				$_save = $this->_actionSaveScheduling($dados);
				if(!$_save) {
					throw new Exception($dados['nome_completo']." lamentamos mas não conseguimos efetivar sua inscrição. Tente novamente mais tarde.",1);
				}
				if($_save) {
					$inscricao = $this->inscricoes_m->getInscricao($_save);
					print json_encode(
						array('status' => true, 'mensagem' => 'Parabéns '.$dados['nome_completo'].' sua inscrição foi realizada com sucesso.', 
							'dados_inscricao' => array(
								'codigoInscricao' => strtoupper($inscricao->token), 
								'data_inscricao' => formataParaData($inscricao->created) ), 'tipo' => $this->swall_tipo[1]));exit;
				} else {
					print json_encode(array('status' => false, 'tipo' => $this->swall_tipo[0], 'mensagem' => 'Lamentamos, mas não conseguimos efetivar sua inscrição, por favor tente mais tarde.'));exit;
				}
			} catch(Exception $e) {
				print json_encode(array('status' => false, 'tipo' => $this->swall_tipo[0], 'mensagem' => $e->getMessage()));exit;
			}
		} else {
			if(is_array($validacaoDados)) {
				print json_encode(array('status' => false, 'tipo' => $this->swall_tipo[2], 'mensagem' => $validacaoDados['mensagem']));exit;
			}
			print json_encode(array('status' => false, 'tipo' => $this->swall_tipo[2], 'mensagem' => 'Existe erros de preenchimento, por favor verifique as informações fornecidas e tente novamente.'));exit;
		}
	}

	private function _validarDados($dados) {
		if($dados) {
			if(isset($dados->nome_completo) && (empty($dados->nome_completo))) {
				return false;
			}
			/**
			* 
			* @param 1: email
			*/
			if($this->verificarSeExisteInscricao(array('email' => $dados->email))) {
				return array('mensagem' => $dados->nome_completo.' já consta em nossos registros sua inscrição. Caso ainda não tenha recebido seu e-mail de confirmação, entre em contato com a <b>'.EMPRESA_UTILIZADORA.'</b>.', 'tipo' => $this->swall_tipo[3]);
			}

			if(isset($dados->email) && (empty($dados->email))) {
				return false;
			} else {
				if(!filter_var($dados->email, FILTER_VALIDATE_EMAIL)) {
					return false;
				}
			}
			if(isset($dados->telefone) && (empty($dados->telefone))) {
				if(strlen($dados->telefone < 11)) {
					return false;
				}
			}
			return true;
		}
		return false;
	}

	private function verificarSeExisteInscricao($termoValidacao) {
		if($termoValidacao) {
			return $this->inscricoes_m->verificarSeExisteInscricao($termoValidacao);
		}
	}
	
	private function _actionSaveScheduling($dados) {
		if(!$dados) {return false;}
		$dados['created'] = date('Y-m-d H:i:s');
		$inscricao_id = $this->inscricoes_m->_insertRegistro($dados);
		$this->inscricoes_m->_updateRegistro(array('token'=> geraCodigoTamanhoPersonalizado($dados['email'], $inscricao_id, 10)), $inscricao_id);
		return $inscricao_id;
	}
	
}
