<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');
/*-------------------------------------------
|	CONSTANTES DE TITULOS HTML E DE CONTEXTOS
|-------------------------------------------*/

$nome_modulos = array(
  'PARTICIPANTE' => array('singular' => 'Participante', 'plural' => 'Participantes')
  );


//----> CONTROLER = PARTICIPANTES
defined('PARTICIPANTE_CABECALHO_PAGINA')  OR define ('PARTICIPANTE_CABECALHO_PAGINA', $nome_modulos['PARTICIPANTE']['plural'] .' - '. NOME_CURTO_SISTEMA);
defined('PARTICIPANTE_TITULO_REGISTRO')  OR define ('PARTICIPANTE_TITULO_REGISTRO', 'Novo '.$nome_modulos['PARTICIPANTE']['singular']);
defined('PARTICIPANTE_TITULO_EDITANDO')  OR define ('PARTICIPANTE_TITULO_EDITANDO', 'Atualizar '.$nome_modulos['PARTICIPANTE']['singular']);
defined('PARTICIPANTE_TITULO_LISTAGEM')  OR define ('PARTICIPANTE_TITULO_LISTAGEM', $nome_modulos['PARTICIPANTE']['plural'].' Registrados');
defined('PARTICIPANTE_SUBTITULO_LISTAGEM')  OR define ('PARTICIPANTE_SUBTITULO_LISTAGEM', 'Registro de '.$nome_modulos['PARTICIPANTE']['plural']);
defined('PARTICIPANTE_TITULO_DETALHES')  OR define ('PARTICIPANTE_TITULO_DETALHES', 'Detalhes de Participante');
defined('PARTICIPANTE_SUBTITULO_DETALHES')  OR define ('PARTICIPANTE_SUBTITULO_DETALHES', 'Detalhamento de Registro de '.$nome_modulos['PARTICIPANTE']['singular']);