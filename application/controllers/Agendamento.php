<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Agendamento extends MY_Controller {

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
		$this->load->model(array("parametros_m", "agendamentos_m"));
	}

	public function getDataDefault() {
		header('Content-type: application/json');
		$parametrosSecao = $this->parametros_m->getParametros(false, 'agendamento');
		$parametros_agrupados = array();
		foreach($parametrosSecao as $key => $parametro) {
			if(isset($parametro->status)){
				unset($parametro->status);
			}
			$parametro->definicoes = $this->_tratarDados($parametro->definicoes); //formataParaData($parametro->definicoes);
			if(!array_key_exists($parametro->secao, $parametros_agrupados)) {
				$parametros_agrupados[$parametro->secao] = array();
			}
			array_push($parametros_agrupados[$parametro->secao], array('parametro' => $parametro->descricao_parametro, 'value' => $parametro->definicoes));
		}
		if(!$parametro) {
			$return['status'] = false;
		} else {
			$return['status'] = true;
			$return['dados'] = $parametros_agrupados;
		}
		print json_encode($return);
	}

	public function saveScheduling() {
		header('Content-type: application/json');
		$post = json_decode(file_get_contents('php://input'));

		// print_r($post);exit;
		$validacaoDados = $this->_validarDados($post);
		if(!is_array($validacaoDados)) {
				/**
				 * O objetivo da função abaixo é após todas as devidas validações realizadas conforme parametros, efetivar o então agendamento com os dados informados
				 * via formulário.
				 */
				$dados = array(
					'nome_completo' => strtoupper($post->nome_completo),
					'email' => $post->email,
					'cpf' => isset($post->cpf) ? $post->cpf : false,
					'telefone' => $post->telefone,
					'descendencia' => $post->descendencia,
					'culto_horario' => $post->culto_horario,
					'qtd_acompanhante' => $post->qtd_pessoas
				);
				$_save =  $this->_saveAgendamento($dados);
				if($_save) {
					print json_encode(array('status' => true, 'mensagem' => 'Parabéns, agendamento efetivado com sucesso. Por favor aguarde o recebimento do seu e-mail de confirmação', 'codigoAgendamento' => $_save));exit;
				} else {
					print json_encode(array('status' => false, 'mensagem' => 'Lamentamos, mas não conseguimos efetivar seu agendamento, por favor tente mais tarde.'));exit;
				}
		} else {
			if(is_array($validacaoDados)) {
				print json_encode(array('status' => false, 'mensagem' => $validacaoDados['mensagem']));exit;
			}
			print json_encode(array('status' => false, 'mensagem' => 'Existe erros de preenchimento, por favor verifique as informações fornecidas e tente novamente.'));exit;
		}
	}

	private function _validarDados($dados) {
		if($dados) {
			if(isset($dados->nome_completo) && (empty($dados->nome_completo))) {
				return false;
			}
			if(getParametroPorDescricao('validar_autenticidade_por')->definicoes == 'cpf') {
				if(isset($dados->cpf) && (empty($dados->cpf))) {
					return false;
				} else {
					if(strlen($dados->cpf) < 11) {
						return false;
					}
				}
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
			$celebracao_atual = $this->parametros_m->getParametroPorDescricao('dia_celebracao');

			/**
			 * O objetivo da função abaixo baseia-se no parametro 'validar_autenticidade_por', que se definido como cpf, irá verificar se a pessoa já tem um agendamento 
			 * realizado na data e com o cpf informado, se sim. rejeita a nova intenção e retorna uma mensagem p/ solicitar confirmação junto a igreja, 
			 * com isso anula a possibilidade de repetição.
			 * 
			 * @param 1: cpf
			 * @param 2: data_celebracao
			 */
			if(getParametroPorDescricao('validar_autenticidade_por')->definicoes == 'cpf') {
				if($this->verificarSeExisteAgendamentoNaData(array('cpf' => removePontuacao($dados->cpf, 'cpf')), $celebracao_atual->definicoes)) {
					return array('mensagem' => 'Você já possui um agendamento para o dia '.formataParaData($celebracao_atual->definicoes).'. Caso ainda não tenha recebido seu e-mail de confirmação, entre em contato com a <b>'.EMPRESA_UTILIZADORA.'</b> através do whatsapp em nosso site.<br><br>Abraço, Deus abençoe.');
				}
			}

			/**
			 * O objetivo da função abaixo baseia-se também no parametro 'validar_autenticidade_por', se definido como nome_completo, irá verificar se a pessoa 
			 * já tem um agendamento realizado na data e com o nome completo informado, se sim. rejeita a nova intenção e retorna uma mensagem p/ solicitar confirmação junto a igreja, 
			 * com isso anula a possibilidade de repetição.
			 * 
			 * @param 1: nome_completo
			 * @param 2: data_celebracao
			 */
			if(getParametroPorDescricao('validar_autenticidade_por')->definicoes == 'nome_completo') {
				if($this->verificarSeExisteAgendamentoNaData(array('nome_completo' => $dados->nome_completo), $celebracao_atual->definicoes)) {
					return array('mensagem' => 'Você já possui um agendamento para o dia '.formataParaData($celebracao_atual->definicoes).'. Caso ainda não tenha recebido seu e-mail de confirmação, entre em contato com a <b>'.EMPRESA_UTILIZADORA.'</b> através do whatsapp em nosso site.<br><br>Abraço, Deus abençoe.');
				}
			}

			/**
			 * O objetivo da função abaixo baseia-se também no parametro 'validar_autenticidade_por', se definido como email, irá verificar se a pessoa 
			 * já tem um agendamento realizado na data e com o nome completo informado, se sim. rejeita a nova intenção e retorna uma mensagem p/ solicitar confirmação junto a igreja, 
			 * com isso anula a possibilidade de repetição.
			 * 
			 * @param 1: email
			 * @param 2: data_celebracao
			 */
			if(getParametroPorDescricao('validar_autenticidade_por')->definicoes == 'email') {
				if($this->verificarSeExisteAgendamentoNaData(array('email' => $dados->email), $celebracao_atual->definicoes)) {
					return array('mensagem' => 'Você já possui um agendamento para o dia '.formataParaData($celebracao_atual->definicoes).'. Caso ainda não tenha recebido seu e-mail de confirmação, entre em contato com a <b>'.EMPRESA_UTILIZADORA.'</b> através do whatsapp em nosso site.<br><br>Abraço, Deus abençoe.');
				}
			}

			return true;
		}
		return false;
	}

	private function _tratarDados($dado) {
		if(strtotime($dado)) {
			return formataParaData($dado);
		}
		return $dado;
	}

	private function _saveAgendamento($dados) {
		if(!$dados) {return false;}
		$celebracao_atual = $this->parametros_m->getParametroPorDescricao('dia_celebracao');
		$dados['created'] = date('Y-m-d H:i:s');
		$dados['dia_celebracao'] = $celebracao_atual->definicoes;
		// print_r($dados);exit;
		$agendamento_id = $this->agendamentos_m->_insertRegistro($dados);
		if($agendamento_id) {
			return $agendamento_id;
		}
		return false;
	}

	private function verificarSeExisteAgendamentoNaData($termoValidacao, $data) {
		if($termoValidacao) {
			if($this->agendamentos_m->verificarSeExisteAgendamentoNaData($termoValidacao, $data)) {
				return true;
			} else {
				return false;
			}
		}

	}
	
}
