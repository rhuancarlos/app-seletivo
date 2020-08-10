<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Participante extends MY_Controller {

	public $data_view;
	private $tabela_id = 1419;
	private $tabela_id_c = 1429;
	private $tabela_id_r = 1431;
	private $tabela_id_u = 1429;
	private $tabela_id_d = 1429;


	public function __construct() {
		parent::__construct();
		$this->permissoes->verificaLogado();
		$this->stringController = "participante";
		$this->load->library("assets", array(
			'header' => array( 
				'titulo_home' => "Participantes", 
				'titulo_pagina_cadastro' => "Cadastro de Participantes", 'subtitulo' => null,
				'titulo_pagina_editar' => "Atualização de Participantes", 'subtitulo' => null
			),
			'js' => 'modulos/participante/participantes'
		));
		$this->load->model(array('estados_m','cidades_m', 'estado_civil_m', 'equipes_m', 'faixa_etaria_m', 'participantes_m', 'competicao_participantes_m'));
		$this->usuarioAdministrador = $this->rsession->get('usuario_logado')['usuario_administrador'];
		$this->layout_coluna_id     = $this->layout_listagem_id = 1;
		$this->title_page = PARTICIPANTE_CABECALHO_PAGINA;
	}

	public function index() {
		$this->permissoes->verificaAcesso($this->tabela_id_r, $this->seguranca->dec($this->rsession->get('usuario_logado')['grupo_usuario_id']));
		$this->data_view['title_page'] = $this->title_page;
		$this->data_view['titulo_home'] = $this->assets->header['titulo_home'];
		$this->data_view['titulo_home2'] = '';
		$this->data_view['controller'] = $this->stringController = "participante";
		$this->data_view['equipes'] = $this->equipes_m->getAll();
		$this->data_view['list_table_th'] = $this->cabecalhoListagemTabelas($this->layout_coluna_id);
		$this->loadView($this->data_view);
	}
	
	public function cadastrar() {
		$this->permissoes->verificaAcesso($this->tabela_id_c, $this->seguranca->dec($this->rsession->get('usuario_logado')['grupo_usuario_id']));
		$this->data_view['title_page'] = $this->title_page;
		$this->data_view['titulo_home'] = $this->assets->header['titulo_home'];
		$this->data_view['titulo_home2'] = PARTICIPANTE_TITULO_REGISTRO;
		$this->data_view['titulo_pagina'] = $this->assets->header['titulo_pagina_cadastro'];
		$this->data_view['estados'] = $this->estados_m->getAll();
		$this->data_view['estado_civil'] = $this->estado_civil_m->getAll();
		$this->data_view['equipes'] = $this->equipes_m->getAll();
		$this->data_view['faixa_etaria'] = $this->faixa_etaria_m->getAll();
		$this->loadView($this->data_view);
	}
	
	public function editar($id = false) {
		$this->permissoes->verificaAcesso($this->tabela_id_u, $this->seguranca->dec($this->rsession->get('usuario_logado')['grupo_usuario_id']));
		if($id) {
			try{
				$dadosParticipante = $this->participantes_m->getParticipante($this->seguranca->dec($id));
				if(!$dadosParticipante) {
					redirect('/participante');
				} else {
					$dadosParticipante->idparticipante = $this->seguranca->enc($dadosParticipante->idparticipante);
					$dadosParticipante->prt_usuario_id = $this->seguranca->enc($dadosParticipante->prt_usuario_id);
					$dadosParticipante->equipe_id = $this->seguranca->enc($dadosParticipante->equipe_id);
					$dadosParticipante->prt_criacao_usuario_id = $this->seguranca->enc($dadosParticipante->prt_criacao_usuario_id);

					$this->data_view['title_page'] = $this->title_page;
					$this->data_view['titulo_home'] = $this->assets->header['titulo_home'];
					$this->data_view['titulo_home2'] = PARTICIPANTE_TITULO_EDITANDO;
					$this->data_view['titulo_pagina'] = $this->assets->header['titulo_pagina_editar'];
					$this->data_view['dadosParticipante'] = $dadosParticipante;
					$this->data_view['estados'] = $this->estados_m->getAll();
					$this->data_view['estado_civil'] = $this->estado_civil_m->getAll();
					$this->data_view['equipes'] = $this->equipes_m->getAll();
					$this->data_view['faixa_etaria'] = $this->faixa_etaria_m->getAll();
					$this->loadView($this->data_view);
				}
			} catch (Exception $e) {
				return false;
			}
		} else {
			print json_encode(array('status' => 'falha', 'mensagem' => 'Falha ao atualizar registro'));
		}
	}

	private function cabecalhoListagemTabelas($layout_id) {
		if(empty($layout_id)) return false;

		$table_header = null;
		switch ($layout_id) {
			case '1':
				$table_header.= '<th style="width: 82px;">CÓDIGO</th>';
				$table_header.= '<th style="width: auto;">NOME COMPLETO</th>';
				$table_header.= '<th style="width: auto;">CPF</th>';
				$table_header.= '<th style="width: auto;">EQUIPE</th>';
				$table_header.= '<th style="width: auto;">TELEFONE WHATS</th>';
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
	public function salvarParticipante() {
		header('Content-type application/json');
		$post = array($this->input->post());
		$dados_DataBase = array();
		
		//debug_array($post[0]);
		foreach ($post as $propriedade) {
			if(strlen($propriedade['participante_nomecompleto']) < 10) {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Nome inválido ou incompleto.', 'input' => 'participante_nomecompleto'));
				exit;
			}

			if(empty($propriedade['participante_cidade'])) {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Falta informar o Cidade', 'input' => 'participante_cidade'));
				exit;
			}

			if(empty($propriedade['participante_uf'])) {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Falta informar o Estado/Uf', 'input' => 'participante_uf'));
				exit;
			}

			if(empty($propriedade['participante_endereco'])) {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Falta informar o Endereço', 'input' => 'participante_endereco'));
				exit;
			}

			if(empty($propriedade['participante_telefone'])) { 
				if(strlen($propriedade['participante_telefone']) != 11) {
					print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Telefone inválido. Verifique a informação fornecida e tente novamente.', 'input' => 'participante_telefone'));
					exit;					
				}
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Falta informar o Telefone Whatsapp', 'input' => 'participante_telefone'));
				exit;
			}

			if(empty($propriedade['participante_sexo'])) {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Falta informar o Gênero', 'input' => 'participante_sexo'));
				exit;
			}

			if(empty($propriedade['participante_cpf'])) {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Falta informar o Cpf', 'input' => 'participante_cpf'));
				exit;
			}

			if(strlen($propriedade['participante_cpf']) < 14) {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Cpf inválido, verifique e tente novamente', 'input' => 'participante_cpf'));
				exit;
			}

			/*if(!filter_var($propriedade['participante_email'], FILTER_VALIDATE_EMAIL)){
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'E-mail inválido. Verifique a informação fornecida e tente novamente.', 'input' => 'participante_email'));
				exit;
			}*/

			if(empty($propriedade['participante_estado_civil'])){
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Falta informar o Estado Cvicil. Verifique a informação fornecida e tente novamente.', 'input' => 'participante_estado_civil'));
				exit;
			}

			if(empty($propriedade['participante_datanascimento'])){
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Falta informar a Data de Nascimento. Verifique a informação fornecida e tente novamente.', 'input' => 'participante_datanascimento'));
				exit;
			}

			if(empty($propriedade['participante_faixa_etaria'])){
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Falta informar a Faixa Etária. Verifique a informação fornecida e tente novamente.', 'input' => 'participante_faixa_etaria'));
				exit;
			}
		}

		$dados_DataBase = array (
			'prt_nomecompleto' => $post[0]['participante_nomecompleto'],
			'prt_endereco' => $post[0]['participante_endereco'],
			'prt_uf' => $post[0]['participante_uf'],
			'prt_cidade' => $post[0]['participante_cidade'],
			'prt_cep' => $post[0]['participante_cep'],
			'prt_numero' => $post[0]['participante_numero'],
			'prt_bairro' => $post[0]['participante_bairro'],
			'prt_estado_civil' => $post[0]['participante_estado_civil'],
			'prt_sexo' => $post[0]['participante_sexo'],
			'prt_telefone' => removePontuacao($post[0]['participante_telefone'], 'telefone'),
			'prt_telefone_fixo' => removePontuacao($post[0]['participante_telefone_fixo'], 'telefone'),
			'prt_cpf' => removePontuacao($post[0]['participante_cpf'], 'cpf'),
			'prt_rg' => $post[0]['participante_rg'],
			'prt_datanascimento' => formate_date($post[0]['participante_datanascimento']),
			'prt_email' => $post[0]['participante_email'],
			'prt_instagram' => $post[0]['participante_instagram'],
			'prt_faixa_etaria_id' => $post[0]['participante_faixa_etaria'],
			//'prt_equipe_id' => $post[0]['participante_equipe'],
			'prt_criacao_ip' => getInfoServerAmbience('REMOTE_ADDR'),
			'lider_equipe' => isset($post[0]['participante_lider_equipe']) ? ( ($post[0]['participante_lider_equipe'] == 'on') ? true : false) : false
		);

		//debug_array($dados_DataBase);
		$codigo_participante = isset($post[0]['participante_codigo']) ? $this->seguranca->dec($post[0]['participante_codigo']) : false;
		if(!$codigo_participante) {
			// Verifica se registro já existe, caso contrário continua o processo.
			if($this->participantes_m->getParticipante(false, $dados_DataBase['prt_cpf'])) {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => ' Participante já registrado, verifique a listagem geral.'));
				exit;
				return;				
			}
			
			// Faz insert e seta na variavel o 'id' do participante.
			$idparticipante = $this->_insertRegistro($dados_DataBase);
			if($idparticipante) {
				/*
					FAZER UMA FUNÇÃO QUE VERIFICA SE O PARTICIPANTE JÁ ESTÁ DENTRO DE ALGUMA EQUIPE. SE TIVER, NÃO REALIZAR UM NOVO INSERT NO BANCO MAS SIM ATUALIZAR O EQUIPE_ID DELE NA TABELA DE COMPETIÇÃO PARTICIPANTES PARA O ID DA NOVA EQUIPE.
				*/
				if(isset($post[0]['participante_equipe']) && !empty($post[0]['participante_equipe'])) {
					$this->_registraEquipeParticipante(array('participante_id' => $idparticipante, 'equipe_id' => $post[0]['participante_equipe'], 'criacao' => date('Y-m-d H:i:s')), false);
				}
				print json_encode(array('status' => 'sucesso', 'title' => $this->swall_titulo_sucesso, 'tipo' => $this->swall_tipo[1], 'message' => 'Participante registrado com sucesso!<br><b>Matricula:</b> '.$idparticipante));
				exit;
			} else {
				print json_encode(array('status' => 'falha', 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[0], 'message' => 'Falha crítica ao salvar registro no banco de dados. Por favor contate a '.DESENVOLVEDOR_SISTEMA_NOME.'!!'));
				exit;
			}		
		} else {
			if($this->_updateRegistro($dados_DataBase, $codigo_participante)) {
				if(isset($post[0]['participante_equipe']) && !empty($post[0]['participante_equipe'])) {
					$this->_registraEquipeParticipante(array('participante_id' => $codigo_participante, 'equipe_id' => $post[0]['participante_equipe'], 'modificacao' => date('Y-m-d H:i:s')),$codigo_participante);
				}
				print json_encode(array('status' => 'sucesso', 'title' => $this->swall_titulo_sucesso, 'tipo' => $this->swall_tipo[1], 'message' => 'Participante atualizado com sucesso!', 'close' => $this->swall_timeout['nivel3']));
				exit;
			}
		}
		exit;
	}

	public function getListParticipant() {
		$post = $this->input->post();
		//$tipoDados  = array('ativo', 'inativo', 'removido');
		$search = isset($post['search']) ? $post['search']['value'] : false;
		$length = isset($post['length']) ? $post['length'] : 25;
		$start = isset($post['start']) ? $post['start'] : 0;
		$filtro_equipe = isset($post['filtro_equipe']) ? $post['filtro_equipe'] : false;

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
		$paramPesquisaAvancada = array("filtro_equipe" => $filtro_equipe);
		$participantes = $this->participantes_m->getAll($paramLimites, $search, $paramPesquisaAvancada);
		$listagem = $this->layoutListagemGeralParticipantes($participantes, $this->layout_coluna_id, $search, $paramPesquisaAvancada);
		if(!$listagem) {
			print json_encode(array('status' => false, 'title' => $this->swall_titulo_falha, 'tipo' => $this->swall_tipo[2], 'message' => 'Nenhum dado encontrado'));
			exit;
		} else {
			$listagem['status'] = 'sucesso';
			print json_encode($listagem);
		}
	}

	private function layoutListagemGeralParticipantes($dados, $layout_id, $search, $paramPesquisaAvancada) {
		$ci	=& get_instance();
		if(empty($layout_id) || (!$dados)) {
			return false;
		}
		foreach($dados as $r) {
			$data[] = $this->montaDadosLayout($layout_id, $r);
		}
		$t = $ci->participantes_m->getAllCount($search, $paramPesquisaAvancada);
		return array("recordsTotal" => $t, "recordsFiltered" => $t, "data" => $data, "layout_list" => $layout_id);
	}

	public function detalhe_registro($id_participante) {
		if($id_participante) {
			try{
				$dadosParticipante = $this->participantes_m->getParticipante($this->seguranca->dec($id_participante));
				if($dadosParticipante) {
					$dadosParticipante->idparticipante = $this->seguranca->enc($dadosParticipante->idparticipante);
					$this->data_view['title_page'] = $this->title_page;
					$this->data_view['titulo_home'] = $this->assets->header['titulo_home'];
					$this->data_view['titulo_home2'] = PARTICIPANTE_TITULO_DETALHES;
					$this->data_view['dadosParticipante'] = $dadosParticipante;
					$this->data_view['estados'] = $this->estados_m->getAll();
					$this->data_view['estado_civil'] = $this->estado_civil_m->getAll();
					$this->data_view['equipes'] = $this->equipes_m->getAll();
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

	private function montaDadosLayout($layout_id, $dados) {
		if(!isset($dados)) {
			return false;
		}
		$dadosEquipe = getDadosEquipe($this->seguranca->enc($dados->equipe_id));

		$linha = $opcoes_botao = array();
		
		$botao_alterar_dados_membro = '<a href="'. base_url('participante/editar/' . $this->seguranca->enc($dados->idparticipante)) . '" title="Editar registro: '.$dados->idparticipante.'" class="icons-size-2"> <i class="icon-feather-edit"></i></a>';

		$botao_ver_ficha_detalha = '<a href="'. base_url('participante/detalhe_registro/' . $this->seguranca->enc($dados->idparticipante)) . '" id="view" title="Abrir registro: '.$dados->idparticipante.'" class="icons-size-2"> <i class="fa fa-eye data-table-body"></i></a>';

		$botao_foto_perfil  = ' <a href="#" id="'.$this->seguranca->enc($dados->idparticipante).'" onclick="carregaModalTrocarFotoMembro(this)" title="Trocar foto de participante: '.$dados->idparticipante.'" class="icons-size-2"> <i class="icon-feather-image"></i></a>';

		if($this->usuarioAdministrador) {
				$opcoes_botao[] = /*$botao_imprimir_ficha_membro . */'<div style="margin:5px; text-align: left !important;">'.$botao_ver_ficha_detalha . $botao_alterar_dados_membro . $botao_foto_perfil.'</div>';
			} else {
				$opcoes_botao[] = /*$botao_imprimir_ficha_membro . */'<div style="margin:5px; text-align: left !important;">'.$botao_ver_ficha_detalha . $botao_alterar_dados_membro . $botao_foto_perfil.'</div>';
		}

		if($layout_id == 1) {
			$linha[$this->stringController.'_codigo']        = $dados->idparticipante;
			$linha[$this->stringController.'_nome']          = $dados->prt_nomecompleto;
			$linha[$this->stringController.'_dados_pessoais']= $dados->prt_cpf;
			$linha[$this->stringController.'_dados_competicao'] = $dadosEquipe['descricao'];
			$linha[$this->stringController.'_telefone1']     = $dados->prt_telefone;
			$linha[$this->stringController.'_botoes']        = is_array($opcoes_botao) ? implode($opcoes_botao) : $opcoes_botao;
		}
		return $linha;
	}

	private function _insertRegistro($dados_DataBase){
		if(!$dados_DataBase) {
			return false;
			exit;
		}
		$dados_DataBase['prt_criacao'] = date('Y-m-d H:i:s');
		$dados_DataBase['prt_criacao_usuario_id'] = $this->seguranca->dec($this->rsession->get('usuario_logado')['id_usuario']);
		$IDPARTICIPANTE = $this->participantes_m->_insertRegistro($dados_DataBase);
		return (!$IDPARTICIPANTE) ? false : $IDPARTICIPANTE;
	}

	private function _registraEquipeParticipante($dadosEquipe, $id_participante) {
		if(!$dadosEquipe) {
			return false;
		}
		return ($this->competicao_participantes_m->_registraEquipeParticipante($dadosEquipe, $id_participante));
	}

	private function _updateRegistro($dados_DataBase, $codigo_participante){
		if(!$dados_DataBase) {
			return false;
			exit;
		}
		$dados_DataBase['prt_modificacao'] = date('Y-m-d H:i:s');
		$dados_DataBase['prt_modificacao_usuario_id'] = $this->seguranca->dec($this->rsession->get('usuario_logado')['id_usuario']);
		return $this->participantes_m->_updateRegistro($dados_DataBase, $codigo_participante) || false;
	}
	
	// public function getAll(){
	// 	header('Content-type application/json');
	// 	$get = $this->input->get();
	// 	// if($get['_type'] != 'query') {
	// 	// 	print json_encode('Error type data invalid');
	// 	// 	exit;
	// 	// }
	// 	// debug_array($get);exit;
	// 	$return = $this->participantes_m->getAll(false, false, $get);
	// 	print json_encode($return);
	// }
}
