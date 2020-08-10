<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');
/*-------------------------------------------
|	CONSTANTES DE TITULOS HTML E DE CONTEXTOS
|-------------------------------------------*/

$nome_modulos = array(
  'PARTICIPANTE' => array('singular' => 'Participante', 'plural' => 'Participantes'),
  'PROVA' => array('singular' => 'Prova', 'plural' => 'Provas'),
  'MATERIAIS' => array('singular' => 'Material', 'plural' => 'Materiais'),
  'EQUIPE' => array('singular' => 'Equipe', 'plural' => 'Equipes'),
  'USUARIO' => array('singular' => 'Usuário', 'plural' => 'Usuários'),
  'GRUPO_USUARIO' => array('singular' => 'Grupo de Usuário', 'plural' => 'Grupos de Usuários'),
  'TRF_PROCESSOS' => array('singular' => 'Tarefa e Processo', 'plural' => 'Tarefas e Processos'),
  'TRF_PROCESSOS_COMPETICAO' => array('singular' => 'Competição', 'plural' => 'Competições'),
  'TRF_PROCESSOS_FINANCEIRO' => array('singular' => 'Financeiro', 'plural' => 'Financeiros'),
  );


//----> CONTROLER = PARTICIPANTES
defined('PARTICIPANTE_CABECALHO_PAGINA')  OR define ('PARTICIPANTE_CABECALHO_PAGINA', $nome_modulos['PARTICIPANTE']['plural'] .' - '. NOME_CURTO_SISTEMA);
defined('PARTICIPANTE_TITULO_REGISTRO')  OR define ('PARTICIPANTE_TITULO_REGISTRO', 'Novo '.$nome_modulos['PARTICIPANTE']['singular']);
defined('PARTICIPANTE_TITULO_EDITANDO')  OR define ('PARTICIPANTE_TITULO_EDITANDO', 'Atualizar '.$nome_modulos['PARTICIPANTE']['singular']);
defined('PARTICIPANTE_TITULO_LISTAGEM')  OR define ('PARTICIPANTE_TITULO_LISTAGEM', $nome_modulos['PARTICIPANTE']['plural'].' Registrados');
defined('PARTICIPANTE_SUBTITULO_LISTAGEM')  OR define ('PARTICIPANTE_SUBTITULO_LISTAGEM', 'Registro de '.$nome_modulos['PARTICIPANTE']['plural']);
defined('PARTICIPANTE_TITULO_DETALHES')  OR define ('PARTICIPANTE_TITULO_DETALHES', 'Detalhes de Participante');
defined('PARTICIPANTE_SUBTITULO_DETALHES')  OR define ('PARTICIPANTE_SUBTITULO_DETALHES', 'Detalhamento de Registro de '.$nome_modulos['PARTICIPANTE']['singular']);

//----> CONTROLER = PROVA
defined('PROVA_CABECALHO_PAGINA')  OR define ('PROVA_CABECALHO_PAGINA', 'Provas - '.NOME_CURTO_SISTEMA);
defined('PROVA_TITULO_REGISTRO')  OR define ('PROVA_TITULO_REGISTRO', 'Nova Prova');
defined('PROVA_TITULO_EDITANDO')  OR define ('PROVA_TITULO_EDITANDO', 'Atualizar Prova');
defined('PROVA_TITULO_LISTAGEM')  OR define ('PROVA_TITULO_LISTAGEM', 'Provas Registradas');
defined('PROVA_SUBTITULO_LISTAGEM')  OR define ('PROVA_SUBTITULO_LISTAGEM', 'Relação de provas que compõe a competição');
defined('PROVA_TITULO_DETALHES')  OR define ('PROVA_TITULO_DETALHES', 'Registro Detalhado');
defined('PROVA_SUBTITULO_DETALHES')  OR define ('PROVA_SUBTITULO_DETALHES', 'Detalhamento de Registro de Prova');

//----> CONTROLER = MATERIAIS
defined('MATERIAIS_CABECALHO_PAGINA')  OR define ('MATERIAIS_CABECALHO_PAGINA', $nome_modulos['MATERIAIS']['plural'] .' - '.NOME_CURTO_SISTEMA);
defined('MATERIAIS_TITULO_REGISTRO')  OR define ('MATERIAIS_TITULO_REGISTRO', 'Novo '.$nome_modulos['MATERIAIS']['singular']);
defined('MATERIAIS_TITULO_EDITANDO')  OR define ('MATERIAIS_TITULO_EDITANDO', 'Atualizar '.$nome_modulos['MATERIAIS']['plural']);
defined('MATERIAIS_TITULO_LISTAGEM')  OR define ('MATERIAIS_TITULO_LISTAGEM', $nome_modulos['MATERIAIS']['plural'].' Registrados');
defined('MATERIAIS_SUBTITULO_LISTAGEM')  OR define ('MATERIAIS_SUBTITULO_LISTAGEM', 'Relação de '.$nome_modulos['MATERIAIS']['plural'].' que compõe a competição');
defined('MATERIAIS_TITULO_DETALHES')  OR define ('MATERIAIS_TITULO_DETALHES', 'Registro Detalhado');
defined('MATERIAIS_SUBTITULO_DETALHES')  OR define ('MATERIAIS_SUBTITULO_DETALHES', 'Detalhamento de Registro de '.$nome_modulos['MATERIAIS']['plural']);

//----> CONTROLER = EQUIPES
defined('EQUIPE_CABECALHO_PAGINA')  OR define ('EQUIPE_CABECALHO_PAGINA', $nome_modulos['EQUIPE']['plural'] .' - '. NOME_CURTO_SISTEMA);
defined('EQUIPE_TITULO_REGISTRO')  OR define ('EQUIPE_TITULO_REGISTRO', 'Novo '.$nome_modulos['EQUIPE']['singular']);
defined('EQUIPE_TITULO_EDITANDO')  OR define ('EQUIPE_TITULO_EDITANDO', 'Atualizar '.$nome_modulos['EQUIPE']['singular']);
defined('EQUIPE_TITULO_LISTAGEM')  OR define ('EQUIPE_TITULO_LISTAGEM', $nome_modulos['EQUIPE']['plural'].' Registrados');
defined('EQUIPE_SUBTITULO_LISTAGEM')  OR define ('EQUIPE_SUBTITULO_LISTAGEM', 'Registro de '.$nome_modulos['EQUIPE']['plural']);
defined('EQUIPE_TITULO_DETALHES')  OR define ('EQUIPE_TITULO_DETALHES', 'Registro Detalhado');
defined('EQUIPE_SUBTITULO_DETALHES')  OR define ('EQUIPE_SUBTITULO_DETALHES', 'Detalhamento de Registro de '.$nome_modulos['EQUIPE']['singular']);

//----> CONTROLER = USUARIOS
defined('USUARIO_CABECALHO_PAGINA')  OR define ('USUARIO_CABECALHO_PAGINA', $nome_modulos['USUARIO']['plural'] .' - '. NOME_CURTO_SISTEMA);
defined('USUARIO_TITULO_REGISTRO')  OR define ('USUARIO_TITULO_REGISTRO', 'Novo '.$nome_modulos['USUARIO']['singular']);
defined('USUARIO_TITULO_EDITANDO')  OR define ('USUARIO_TITULO_EDITANDO', 'Atualizar '.$nome_modulos['USUARIO']['singular']);
defined('USUARIO_TITULO_LISTAGEM')  OR define ('USUARIO_TITULO_LISTAGEM', $nome_modulos['USUARIO']['plural'].' Registrados');
defined('USUARIO_SUBTITULO_LISTAGEM')  OR define ('USUARIO_SUBTITULO_LISTAGEM', 'Registro de '.$nome_modulos['USUARIO']['plural']);
defined('USUARIO_TITULO_DETALHES')  OR define ('USUARIO_TITULO_DETALHES', 'Registro Detalhado');
defined('USUARIO_SUBTITULO_DETALHES')  OR define ('USUARIO_SUBTITULO_DETALHES', 'Detalhamento de Registro de '.$nome_modulos['USUARIO']['singular']);

//----> CONTROLER = GRUPOS USUARIOS
defined('GRP_USUARIO_NOME_MODULO') OR define ('GRP_USUARIO_NOME_MODULO', $nome_modulos['GRUPO_USUARIO']['plural']);
defined('GRP_USUARIO_CABECALHO_PAGINA')  OR define ('GRP_USUARIO_CABECALHO_PAGINA', $nome_modulos['GRUPO_USUARIO']['plural'] .' - '. NOME_CURTO_SISTEMA);
defined('GRP_USUARIO_TITULO_REGISTRO')  OR define ('GRP_USUARIO_TITULO_REGISTRO', 'Novo '.$nome_modulos['GRUPO_USUARIO']['singular']);
defined('GRP_USUARIO_TITULO_EDITANDO')  OR define ('GRP_USUARIO_TITULO_EDITANDO', 'Atualizar '.$nome_modulos['GRUPO_USUARIO']['singular']);
defined('GRP_USUARIO_TITULO_LISTAGEM')  OR define ('GRP_USUARIO_TITULO_LISTAGEM', $nome_modulos['GRUPO_USUARIO']['plural'].' Registrados');
defined('GRP_USUARIO_SUBTITULO_LISTAGEM')  OR define ('GRP_USUARIO_SUBTITULO_LISTAGEM', 'Registro de '.$nome_modulos['GRUPO_USUARIO']['plural']);
defined('GRP_USUARIO_TITULO_DETALHES')  OR define ('GRP_USUARIO_TITULO_DETALHES', 'Registro Detalhado');
defined('GRP_USUARIO_SUBTITULO_DETALHES')  OR define ('GRP_USUARIO_SUBTITULO_DETALHES', 'Detalhamento de Registro de '.$nome_modulos['GRUPO_USUARIO']['singular']);
defined('GRP_USUARIO_PERMISSOES')  OR define ('GRP_USUARIO_PERMISSOES', 'Permissões de Grupo');

//----> CONTROLER = TAREFAS E PROCESSOS
defined('TRF_PROCESSOS_CABECALHO_PAGINA')  OR define ('TRF_PROCESSOS_CABECALHO_PAGINA', $nome_modulos['TRF_PROCESSOS']['plural'] .' - '.NOME_CURTO_SISTEMA);
// defined('TRF_PROCESSOS_TITULO_REGISTRO')  OR define ('TRF_PROCESSOS_TITULO_REGISTRO', 'Novo '.$nome_modulos['TRF_PROCESSOS']['singular']);
// defined('TRF_PROCESSOS_TITULO_EDITANDO')  OR define ('TRF_PROCESSOS_TITULO_EDITANDO', 'Atualizar '.$nome_modulos['TRF_PROCESSOS']['plural']);
// defined('TRF_PROCESSOS_TITULO_LISTAGEM')  OR define ('TRF_PROCESSOS_TITULO_LISTAGEM', $nome_modulos['TRF_PROCESSOS']['plural'].' Registrados');
// defined('TRF_PROCESSOS_SUBTITULO_LISTAGEM')  OR define ('TRF_PROCESSOS_SUBTITULO_LISTAGEM', 'Relação de '.$nome_modulos['TRF_PROCESSOS']['plural'].' que compõe a competição');
// defined('TRF_PROCESSOS_TITULO_DETALHES')  OR define ('TRF_PROCESSOS_TITULO_DETALHES', 'Registro Detalhado');
// defined('TRF_PROCESSOS_SUBTITULO_DETALHES')  OR define ('TRF_PROCESSOS_SUBTITULO_DETALHES', 'Detalhamento de Registro de '.$nome_modulos['TRF_PROCESSOS']['plural']);


//----> SUB MODULOS | TAREFAS E PROCESSOS > COMPETIÇÃO
defined('TRF_PROCESSOS_COMPETICAO_CABECALHO_PAGINA')  OR define ('TRF_PROCESSOS_COMPETICAO_CABECALHO_PAGINA', $nome_modulos['TRF_PROCESSOS']['plural'].' '.$nome_modulos['TRF_PROCESSOS_COMPETICAO']['plural'] .' - '.NOME_CURTO_SISTEMA);
defined('TRF_PROCESSOS_COMPETICAO_TITULO_HOME')  OR define ('TRF_PROCESSOS_COMPETICAO_TITULO_HOME', array($nome_modulos['TRF_PROCESSOS']['plural'], $nome_modulos['TRF_PROCESSOS_COMPETICAO']['singular']));

//----> SUB MODULOS | TAREFAS E PROCESSOS > FINANCEIRO
defined('TRF_PROCESSOS_FINANCEIRO_CABECALHO_PAGINA')  OR define ('TRF_PROCESSOS_FINANCEIRO_CABECALHO_PAGINA', $nome_modulos['TRF_PROCESSOS']['plural'].' '.$nome_modulos['TRF_PROCESSOS_FINANCEIRO']['plural'] .' - '.NOME_CURTO_SISTEMA);
defined('TRF_PROCESSOS_FINANCEIRO_TITULO_HOME')  OR define ('TRF_PROCESSOS_FINANCEIRO_TITULO_HOME', array($nome_modulos['TRF_PROCESSOS']['plural'], $nome_modulos['TRF_PROCESSOS_FINANCEIRO']['singular']));
defined('TRF_PROCESSOS_FINANCEIRO_TITULO_REGISTRO')  OR define ('TRF_PROCESSOS_FINANCEIRO_TITULO_REGISTRO', 'Lançamentos / Recebimentos / Baixas');
defined('TRF_PROCESSOS_FINANCEIRO_TITULO_EDITANDO')  OR define ('TRF_PROCESSOS_FINANCEIRO_TITULO_EDITANDO', 'Atualizar '.$nome_modulos['TRF_PROCESSOS']['plural']);
defined('TRF_PROCESSOS_FINANCEIRO_TITULO_LISTAGEM')  OR define ('TRF_PROCESSOS_FINANCEIRO_TITULO_LISTAGEM', $nome_modulos['TRF_PROCESSOS']['plural'].' Registrados');