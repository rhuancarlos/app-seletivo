<?php
// require_once APPPATH.'mailjet/vendor/autoload.php';
// use \Mailjet\Resources;
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

	public function getDataDefault() {
		header('Content-type: application/json');
		$parametrosSecao = $this->parametros_m->getParametros(false, 'Campanhas');
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

	public function saveScheduling() {
		header('Content-type: application/json');
		$post = json_decode(file_get_contents('php://input'));
		$validacaoDados = $this->_validarDados($post->dados_pessoais);
		if(!is_array($validacaoDados)) {
			$dados = array(
				'nome_completo' => strtoupper($post->dados_pessoais->nome_completo),
				'email' => $post->dados_pessoais->email,
				'cpf' => isset($post->dados_pessoais->cpf) ? $post->dados_pessoais->cpf : false,
				'telefone' => $post->dados_pessoais->telefone,
				'data_nascimento' => $this->_tratarDados(isset($post->dados_pessoais->data_nascimento) ? $post->dados_pessoais : false),
				'descendencia' => $post->dados_pessoais->descendencia,
				'cep' => $post->dados_pessoais->localizacao->cep,
				'endereco' => $post->dados_pessoais->localizacao->endereco,
				'bairro' => $post->dados_pessoais->localizacao->bairro,
				'complemento' => $post->dados_pessoais->localizacao->complemento,
				'estado' => $post->dados_pessoais->localizacao->estado,
				'cidade' => $post->dados_pessoais->localizacao->cidade,
				'numero_endereco' => $post->dados_pessoais->localizacao->numero_endereco,
				'tipo_inscricao_id' => getTipoInscricao(false, 'CAMP')->idtipoinscricao
			);

			$dadosComplementares = array(
				'opcao_oferta' => isset($post->dados_oferta->ofertaSelecionada) && !empty($post->dados_oferta->ofertaSelecionada) ? $post->dados_oferta->ofertaSelecionada : false,
				'data_vencimento' => isset($post->dados_oferta->dataVencimento) && !empty($post->dados_oferta->dataVencimento) ? $post->dados_oferta->dataVencimento : false,
				'tipo_camisa' => isset($post->dados_oferta->tipoCamisa) && !empty($post->dados_oferta->tipoCamisa) ? $post->dados_oferta->tipoCamisa : false,
				'tamanho_camisa' => isset($post->dados_oferta->tamanhoCamisa) && !empty($post->dados_oferta->tamanhoCamisa) ? $post->dados_oferta->tamanhoCamisa : false
			);
			
			try {
				$_save = $this->_actionSaveScheduling($dados, $dadosComplementares);
				if(!$_save) {
					throw new Exception($dados['nome_completo']." lamentamos mas não conseguimos efetivar sua inscrição. Tente novamente mais tarde.",1);
				}
				if($_save) {
					$notificado = null;
					if(intval(getParametroPorDescricao('EnviarConfirmacao','Campanhas')->definicoes)) {
						$notificado = 'Lamentamos mas não conseguimos te enviar o e-mail de confirmação. Favor entre em contato com a '.EMPRESA_UTILIZADORA.'.';
						if($this->sendNotification('email', 'Campanhas', $_save)) {
							$this->inscricoes_m->_updateRegistro(array('notificado' => true), $_save);
							$notificado = 'Por favor aguarde a confirmação em seu e-mail.';
						}
					}
					$inscricao = $this->inscricoes_m->getInscricao($_save);
					print json_encode(
						array('status' => true, 'mensagem' => 'Parabéns '.$dados['nome_completo'].' sua inscrição foi realizada com sucesso.<br> '.$notificado, 
							'dados_inscricao' => array(
								'nomeSolicitante' => $inscricao->nome_completo,
								'dataNascimento' => formataParaData($inscricao->data_nascimento),
								'codigoInscricao' => strtoupper($inscricao->token), 
								'data_inscricao' => formataParaData($inscricao->created) ), 'tipo' => $this->swall_tipo[1]));exit;
				} else {
					print json_encode(array('status' => false, 'tipo' => $this->swall_tipo[0], 'mensagem' => 'Lamentamos, mas não conseguimos efetivar seu agendamento, por favor tente mais tarde.'));exit;
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
			$tipoValidacao = getParametroPorDescricao('validar_autenticidade_por','Campanhas')->definicoes;
			if($tipoValidacao == 'cpf') {
				if(isset($dados->cpf) && (empty($dados->cpf))) {
					return false;
				} else {
					if(strlen($dados->cpf) < 11) {
						return false;
					} else {
						/**
						 * O objetivo da função abaixo baseia-se no parametro 'validar_autenticidade_por', que se definido como cpf, irá verificar se a pessoa já tem um agendamento 
						 * realizado na data e com o cpf informado, se sim. rejeita a nova intenção e retorna uma mensagem p/ solicitar confirmação junto a igreja, 
						 * com isso anula a possibilidade de repetição.

						* 
						* @param 1: cpf
						* @param 2: data_celebracao
						*/
						if($this->verificarSeExisteInscricao(array('cpf' => removePontuacao($dados->cpf, 'cpf')))) {
							return array('mensagem' => $dados->nome_completo.' já consta em nossos registros sua inscrição. Caso ainda não tenha recebido seu e-mail de confirmação, entre em contato com a <b>'.EMPRESA_UTILIZADORA.'</b> através do whatsapp (86) 99438-9003.<br><br>Abraço, Deus abençoe.', 'tipo' => $this->swall_tipo[3]);
						}
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

			return true;
		}
		return false;
	}

	private function _tratarDados($dado) {
		if(isset($dado->data_nascimento) && !empty($dado->data_nascimento)) {
			return date('Y-m-d',strtotime($dado->data_nascimento));
		}
		if(strtotime($dado)) {
			return formataParaData($dado);
		}
		return $dado;
	}

	private function _actionSaveScheduling($dados, $dadosComplementares) {
		if(!$dados) {return false;}
		$celebracao_atual = $this->parametros_m->getParametroPorDescricao('dia_celebracao','Campanhas');
		$dados['created'] = date('Y-m-d H:i:s');
		// print_r($dados);exit;
		$inscricao_id = $this->inscricoes_m->_insertRegistro($dados);
		$this->inscricoes_m->_updateRegistro(array('token'=> geraCodigoTamanhoPersonalizado($dados['data_nascimento'], $inscricao_id, 10)), $inscricao_id);
		if($inscricao_id) {
			$dadosComplementares['inscricao_id'] = $inscricao_id;
			if($this->inscricoes_m->_insertRegistro($dadosComplementares, 'inscricoes_dados_complementares')) {
				return $inscricao_id;
			}
		}
		return false;
	}

	/*
	private function sendNotification($typeNotification, $sectionNotification, $codeAgendamento) {
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
			array_push($MailJetParametros['scheduling'], $this->inscricoes_m->getInscricao($codeAgendamento));
		}
		return $this->_actionSend($MailJetParametros, $sectionNotification);
	}
	
	private function _actionSend($MailJetParametros, $sectionNotification = false) {
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
		$Scheduling_nome_campanha = getParametros(false,$sectionNotification,'Nome_Campanha')->definicoes;
		$Parameters_TemplateID = intval(getParametros(false,$sectionNotification,'IntegracaoEmailTemplateID')->definicoes);
		$Parameters_TemplateLanguage = boolval($MailJetParametros['parameters']['TemplateLanguage']);
		$Parameters_Subject = NOME_CURTO_SISTEMA.' - '.(empty($sectionNotification) ? $MailJetParametros['parameters']['Subject'] : $Scheduling_nome_campanha);
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
						'NOME_CAMPANHA' => $Scheduling_nome_campanha
					)
				]
			]
		];
		if($this->debugEmail) {
			print '<pre>';
			print_r($body);exit;
		}
		$response = $mj->post(Resources::$Email, ['body' => $body]);
		return $response->success();
	}
	*/

	private function verificarSeExisteInscricao($termoValidacao) {
		if($termoValidacao) {
			return $this->inscricoes_m->verificarSeExisteInscricao($termoValidacao);
		}
	}
	
}
