<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');
/*-------------------------------------------
|	CONSTANTES DE TITULOS HTML E DE CONTEXTOS
|-------------------------------------------*/

$nome_modulos = array(
  'PARTICIPANTE' => array('singular' => 'Participante', 'plural' => 'Participantes'),
  'PROVA' => array('singular' => 'Prova', 'plural' => 'Provas'),
  'MANUTENCAOMENU' => array('singular' => 'Manutenção de Menu', 'plural' => 'Manutenção de Menus'),
  'EQUIPE' => array('singular' => 'Equipe', 'plural' => 'Equipes'),
  'USUARIO' => array('singular' => 'Usuário', 'plural' => 'Usuários'),
  'GRUPO_USUARIO' => array('singular' => 'Grupo de Usuário', 'plural' => 'Grupos de Usuários'),
  );


//----> CONTROLER = PARTICIPANTES
defined('PARTICIPANTE_CABECALHO_PAGINA')  OR define ('PARTICIPANTE_CABECALHO_PAGINA', $nome_modulos['PARTICIPANTE']['plural'] .' - '. NOME_CURTO_SISTEMA);
defined('PARTICIPANTE_TITULO_REGISTRO')  OR define ('PARTICIPANTE_TITULO_REGISTRO', 'Novo '.$nome_modulos['PARTICIPANTE']['singular']);
defined('PARTICIPANTE_TITULO_EDITANDO')  OR define ('PARTICIPANTE_TITULO_EDITANDO', 'Atualizar '.$nome_modulos['PARTICIPANTE']['singular']);
defined('PARTICIPANTE_TITULO_LISTAGEM')  OR define ('PARTICIPANTE_TITULO_LISTAGEM', $nome_modulos['PARTICIPANTE']['plural'].' Registrados');
defined('PARTICIPANTE_SUBTITULO_LISTAGEM')  OR define ('PARTICIPANTE_SUBTITULO_LISTAGEM', 'Registro de '.$nome_modulos['PARTICIPANTE']['plural']);
defined('PARTICIPANTE_TITULO_DETALHES')  OR define ('PARTICIPANTE_TITULO_DETALHES', 'Detalhes de Participante');
defined('PARTICIPANTE_SUBTITULO_DETALHES')  OR define ('PARTICIPANTE_SUBTITULO_DETALHES', 'Detalhamento de Registro de '.$nome_modulos['PARTICIPANTE']['singular']);

//----> CONTROLER = MANUTENCAO MENU
defined('MANUTENCAOMENU_CABECALHO_PAGINA')  OR define ('MANUTENCAOMENU_CABECALHO_PAGINA', $nome_modulos['MANUTENCAOMENU']['plural'] .' - '.NOME_CURTO_SISTEMA);
defined('MANUTENCAOMENU_TITULO_REGISTRO')  OR define ('MANUTENCAOMENU_TITULO_REGISTRO', 'Novo '.$nome_modulos['MANUTENCAOMENU']['singular']);
defined('MANUTENCAOMENU_TITULO_EDITANDO')  OR define ('MANUTENCAOMENU_TITULO_EDITANDO', 'Atualizar '.$nome_modulos['MANUTENCAOMENU']['plural']);
defined('MANUTENCAOMENU_TITULO_LISTAGEM')  OR define ('MANUTENCAOMENU_TITULO_LISTAGEM', $nome_modulos['MANUTENCAOMENU']['plural'].' Registrados');
defined('MANUTENCAOMENU_SUBTITULO_LISTAGEM')  OR define ('MANUTENCAOMENU_SUBTITULO_LISTAGEM', 'Relação de '.$nome_modulos['MANUTENCAOMENU']['plural'].' que compõe a competição');
defined('MANUTENCAOMENU_TITULO_DETALHES')  OR define ('MANUTENCAOMENU_TITULO_DETALHES', 'Registro Detalhado');
defined('MANUTENCAOMENU_SUBTITULO_DETALHES')  OR define ('MANUTENCAOMENU_SUBTITULO_DETALHES', 'Detalhamento de Registro de '.$nome_modulos['MANUTENCAOMENU']['plural']);

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