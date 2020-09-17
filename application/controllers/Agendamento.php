<?php
require_once APPPATH.'mailjet/vendor/autoload.php';
use \Mailjet\Resources;
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
			$parametro->definicoes = $this->_tratarDados($parametro->definicoes);
			if(!array_key_exists($parametro->secao, $parametros_agrupados)) {
				$parametros_agrupados[$parametro->secao] = array();
			}

			if($parametro->descricao_parametro == 'EnviarConfirmacao' || ($parametro->descricao_parametro == 'habilitar_agendamento')) {
				$parametro->definicoes = intval($parametro->definicoes);
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

	public function getVagancyCount($returnJSON = true, $dia_celebracao = false) {
		header('Content-type: application/json');
		$post = json_decode(file_get_contents('php://input'));
		$dia_celebracao = isset($post->dia_celebracao) && !empty($post->dia_celebracao) ? formate_date($post->dia_celebracao) : $dia_celebracao;
		$total_agendamentos_feitos = 0;
		if($dia_celebracao) {
			$getCounts = $this->agendamentos_m->getTotalAgendamentosPorPeriodo($dia_celebracao);
			$vagas_agendadas = intval($getCounts->total_agendamentos);
			$total_acompanhantes = intval($getCounts->total_acompanhantes);
			$vagas_ofertadas = intval(getParametroPorDescricao('total_vagas_ofertadas')->definicoes);
			$vagas_disponiveis = intval($vagas_ofertadas - ($vagas_agendadas + $total_acompanhantes));
			// var_dump($returnJSON);exit;
			if($returnJSON) {
				print json_encode(
					array(
						'status' => $vagas_disponiveis <= 0 ? false : true,
						'qtd_agendamentos_disponiveis' => $vagas_disponiveis > 0 ? $vagas_disponiveis : 0
						)
					);exit;
				} else {
				return $vagas_disponiveis > 0 ? $vagas_disponiveis : 0;
			}
		}
	}

	public function saveScheduling() {
		header('Content-type: application/json');
		$post = json_decode(file_get_contents('php://input'));

		// var_dump($this->getVagancyCount(false));
		if(!empty($this->getVagancyCount(false, $post->dia_celebracao))) {
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
					$_save = $this->_actionSaveScheduling($dados);
					if($_save) {
						$notificado = null;
						if(intval(getParametroPorDescricao('EnviarConfirmacao')->definicoes)) {
							$notificado = 'Lamentamos mas não conseguimos te enviar o e-mail de confirmação. Favor entre em contato com a '.EMPRESA_UTILIZADORA.'.';
							if($this->sendNotification('email', $_save)) {
								$this->agendamentos_m->_updateRegistro(array('notificado' => true), $_save);
								$notificado = 'Por favor aguarde a confirmação em seu e-mail.';
							}
						}
						print json_encode(array('status' => true, 'mensagem' => 'Parabéns, agendamento realizado com sucesso.<br> '.$notificado, 'codigoAgendamento' => $_save));exit;
					} else {
						print json_encode(array('status' => false, 'mensagem' => 'Lamentamos, mas não conseguimos efetivar seu agendamento, por favor tente mais tarde.'));exit;
					}
			} else {
				if(is_array($validacaoDados)) {
					print json_encode(array('status' => false, 'mensagem' => $validacaoDados['mensagem']));exit;
				}
				print json_encode(array('status' => false, 'mensagem' => 'Existe erros de preenchimento, por favor verifique as informações fornecidas e tente novamente.'));exit;
			}
		} else {
			print json_encode(array('status' => false, 'mensagem' => 'Lamentamos mas não há vagas disponiveis para agendamento. <strong>Novas vagas estaram disponíveis aos domingos as 21h</strong>.'));exit;
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
					return array('mensagem' => 'Você já possui um agendamento para o dia '.formataParaData($celebracao_atual->definicoes).'. Caso ainda não tenha recebido seu e-mail de confirmação, entre em contato com a <b>'.EMPRESA_UTILIZADORA.'</b> através do whatsapp (86) 99438-9003.<br><br>Abraço, Deus abençoe.');
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
					return array('mensagem' => 'Você já possui um agendamento para o dia '.formataParaData($celebracao_atual->definicoes).'. Caso ainda não tenha recebido seu e-mail de confirmação, entre em contato com a <b>'.EMPRESA_UTILIZADORA.'</b> através do whatsapp (86) 99438-9003.<br><br>Abraço, Deus abençoe.');
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
					return array('mensagem' => 'Você já possui um agendamento para o dia '.formataParaData($celebracao_atual->definicoes).'. Caso ainda não tenha recebido seu e-mail de confirmação, entre em contato com a <b>'.EMPRESA_UTILIZADORA.'</b> através do whatsapp (86) 99438-9003<br><br>Abraço, Deus abençoe.');
				}
			}

			return true;
		}
		return false;
	}

	private function _tratarDados($dado) {
		if(strtotime($dado)) {
			// incrementa_dia($data, $qtd = 1)
			// print_r($dado);
			return formataParaData($dado);
		}
		return $dado;
	}

	private function _actionSaveScheduling($dados) {
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

	private function sendNotification($tipo, $codeAgendamento) {
		if(!$codeAgendamento) {return false;}
		$MailJetParametros['scheduling'] = array();
		$MailJetParametros['parameters'] = array();
		$getParametrosIntegracaoEmail = getParametros(false, 'IntegracaoEmail', false);
		if($getParametrosIntegracaoEmail) {
			foreach ($getParametrosIntegracaoEmail as $key => $value) {
				if(!array_key_exists($value->descricao_parametro, $MailJetParametros['parameters'])) {
					$MailJetParametros['parameters'][$value->descricao_parametro] = $value->definicoes;
				}
			}
			array_push($MailJetParametros['scheduling'], $this->agendamentos_m->getAgendamento($codeAgendamento));
		}
		return $this->_actionSend($MailJetParametros);
	}
	
	private function _actionSend($MailJetParametros) {
		$inputEmpty = 0;
		foreach($MailJetParametros['scheduling'] as $key => $value) {
			if(empty($value)) {
				++$inputEmpty;
			}
		}
		if($inputEmpty > 0) {
			return false;
		}
		$API_Key = $MailJetParametros['parameters']['API_Key'];
		$API_Secret = $MailJetParametros['parameters']['API_Secret'];
		$Parameters_From_Email = $MailJetParametros['parameters']['From_Email'];
		$Parameters_From_Name = $MailJetParametros['parameters']['From_Name'];
		$Scheduling_email = $MailJetParametros['scheduling'][0]->email;
		$Scheduling_nome_completo = $MailJetParametros['scheduling'][0]->nome_completo;
		$Scheduling_dia_celebracao = formataParaData($MailJetParametros['scheduling'][0]->dia_celebracao);
		$Scheduling_culto_horario = $MailJetParametros['scheduling'][0]->culto_horario;
		$Parameters_TemplateID = intval($MailJetParametros['parameters']['TemplateID']);
		$Parameters_TemplateLanguage = boolval($MailJetParametros['parameters']['TemplateLanguage']);
		$Parameters_Subject = $MailJetParametros['parameters']['Subject'];

		$mj = new \Mailjet\Client($API_Key,$API_Secret,true,['version' => 'v3.1']);
		$body = [
			'Messages' => [
				[
					'From' => [
						'Email' => $Parameters_From_Email,
						'Name' => $Parameters_From_Name
					],
					'To' => [
						[
							'Email' => $Scheduling_email,
							'Name' => $Scheduling_nome_completo
						]
					],
					'TemplateID' => $Parameters_TemplateID,
					'TemplateLanguage' => $Parameters_TemplateLanguage,
					'Subject' => $Parameters_Subject,
					'Variables' => array(
						'NOME_PARTICIPANTE' => $Scheduling_nome_completo,
						'DATA_CELEBRACAO' => $Scheduling_dia_celebracao,
						'HORARIO_AGENDADO' => $Scheduling_culto_horario
					)
				]
			]
		];
		$response = $mj->post(Resources::$Email, ['body' => $body]);
		return $response->success();// && var_dump($response->getData());
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
