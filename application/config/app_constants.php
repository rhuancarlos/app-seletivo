<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Declarações de constantes para o desenvolvimento
|--------------------------------------------------------------------------
|
| Todas as constantes declaradas no docorrer do desenvolvimetno devem
| ser declaradas nesse bloco de código
|
*/
$sub_dominio = explode('.', $_SERVER["HTTP_HOST"]);
defined('PATH_SUBLEVEL') OR define('PATH_SUBLEVEL', 'publico/');
defined('DOMAIN_PATH')  OR define('DOMAIN_PATH', $_SERVER["DOCUMENT_ROOT"].'/'.PATH_SUBLEVEL);
defined('NOME_COMPLETO_SISTEMA')  OR define('NOME_COMPLETO_SISTEMA', 'Agendamento Filadélfia | Agendamento de participação de cultos presenciais');
defined('SIGLA_SISTEMA') OR define('SIGLA_SISTEMA', 'IBN Filadélfia');
defined('NOME_CURTO_SISTEMA') OR define('NOME_CURTO_SISTEMA', 'IBN Filadélfia');
defined('NOME_DOMINIO_SISTEMA') OR define('NOME_DOMINIO_SISTEMA', $sub_dominio[0]);
defined('SIGLA_SESSAO_SISTEMA') OR define('SIGLA_SESSAO_SISTEMA', "_IBN_Filadelfia");
defined('URL') OR define('URL',  (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ) ? 'https://'.$_SERVER["HTTP_HOST"].'/'.PATH_SUBLEVEL : 'http://'.$_SERVER["HTTP_HOST"].'/'.PATH_SUBLEVEL);

defined('ANO_START_PROJETO') OR define('ANO_START_PROJETO', '2020');
Defined('SISTEMA_TAG_LINGUAGENS') OR define('SISTEMA_TAG_LINGUAGENS', array('pt-br', 'en-US', 'fr'));
Defined('SISTEMA_TAG_CODIFICACAO_PAGINA') OR define('SISTEMA_TAG_CODIFICACAO_PAGINA', 'utf-8');

defined('EMPRESA_UTILIZADORA') OR define('EMPRESA_UTILIZADORA', 'IBN Filadélfia');
defined('DESENVOLVEDOR_SISTEMA_NOME') OR define('DESENVOLVEDOR_SISTEMA_NOME', 'CriativeTecnologia');
defined('DESENVOLVEDOR_SISTEMA_SITE') OR define('DESENVOLVEDOR_SISTEMA_SITE', 'https://www.instagram.com/rhuanoliver/');
defined('DESENVOLVEDOR_SISTEMA_EMAIL') OR define('DESENVOLVEDOR_SISTEMA_EMAIL', 'rhuancarlosg12@gmail.com');
defined('URL_API') OR define("URL_API", 'link_for_api_here');

defined('HASH_ASSETS') OR define("HASH_ASSETS", md5(microtime()));

/*
|-------------------------------------------------------
|				CONFIGURAÇÕES	 	 									   
|---------------------------------------------------------
|
|
*/

//-->BANCO DE DADOS REMOTE
define('HOSTNAME_REMOTE', 'localhost');
define('HOSTNAME_REMOTE_USER_DB', 'ibnfilad_sistema');
define('HOSTNAME_REMOTE_PASS_DB', 'F~&Cqgtue^@1m#c2r*');
define('HOSTNAME_REMOTE_NAME_DB', 'ibnfilad_sistema');
define('HOSTNAME_REMOTE_PORT_DB', '3306');

//-->BANCO DE DADOS LOCALHOST
define('HOSTNAME_LOCALHOST', '');
define('HOSTNAME_LOCALHOST_USER_DB', '');
define('HOSTNAME_LOCALHOST_PASS_DB', '');
define('HOSTNAME_LOCALHOST_NAME_DB', '');
define('HOSTNAME_LOCALHOST_PORT_DB', '');

//-->VALORES DEFAULTS
defined('DEFAULT_SITUACAO_NOVA_PERMISSAO') OR define ('DEFAULT_SITUACAO_NOVA_PERMISSAO', 0);
defined('DEFAULT_ATIVAR_NIVEL') OR define('DEFAULT_ATIVAR_NIVEL', 1);
defined('DEFAULT_DISATIVAR_NIVEL') OR define('DEFAULT_DISATIVAR_NIVEL', 0);

defined('DEFAULT_ATIVAR_USUARIO') OR define('DEFAULT_ATIVAR_USUARIO', 1);
defined('DEFAULT_DISATIVAR_USUARIO') OR define('DEFAULT_DISATIVAR_USUARIO', 0);

/*
|-------------------------------------------------------
|				DIRETORIOS E REPOSITORIOS 
|---------------------------------------------------------
|
| Variaveisd de repositorios de assets, libs, e arquivos de views
*/
defined('URL_IMAGES_ICONS') OR define("URL_IMAGES_ICONS", URL . 'public/images/statics/icons/');
defined('URL_IMAGES_LOGOS') OR define("URL_IMAGES_LOGOS", URL . 'public/images/statics/logos/');
defined('URL_IMAGES_ESTATICAS') OR define("URL_IMAGES_ESTATICAS", URL . 'public/images/statics/');
defined('URL_IMAGE_FAVICON') OR define("URL_IMAGE_FAVICON", URL_IMAGES_ESTATICAS . 'favicon/favicon-ibnf-32x32.png');
defined('URL_IMAGES_PERFIL') OR define("URL_IMAGES_PERFIL", URL . 'public/images/usuarios/perfil/');
defined('URL_IMAGES_TEMA') OR define("URL_IMAGES_TEMA", URL . 'public/img/');
defined('PATH_PUBLIC_LIBS') OR define('PATH_PUBLIC_LIBS', URL . 'public/libs/');
defined('PATH_PUBLIC_JS') OR define('PATH_PUBLIC_JS', URL . 'public/js/');
defined('PATH_PUBLIC_CSS') OR define('PATH_PUBLIC_CSS', URL . 'public/css/');

defined('VIEW_MODULO_EQUIPES') OR define('VIEW_MODULO_EQUIPES', VIEWPATH . 'equipe/');
defined('VIEW_MODULO_USUARIOS') OR define('VIEW_MODULO_USUARIOS', VIEWPATH . 'usuarios/');
defined('VIEW_MODULO_MANUTENCAO_MENUS') OR define('VIEW_MODULO_MANUTENCAO_MENUS', VIEWPATH . 'manutencao_menu/');
defined('VIEW_MODULO_GRUPOS_USUARIOS') OR define('VIEW_MODULO_GRUPOS_USUARIOS', VIEWPATH . 'grupos_usuarios/');
defined('VIEW_MODULO_PARTICIPANTES') OR define('VIEW_MODULO_PARTICIPANTES', VIEWPATH . 'participante/');
defined('VIEW_MODULO_PROVAS') OR define('VIEW_MODULO_PROVAS', VIEWPATH . 'provas/');
defined('VIEW_MODULO_MATERIAIS') OR define('VIEW_MODULO_MATERIAIS', VIEWPATH . 'materiais/');
defined('VIEW_MODULO_TAREFAS_PROCESSOS') OR define('VIEW_MODULO_TAREFAS_PROCESSOS', 'tarefas_processos/');
defined('VIEW_MODULO_TAREFAS_PROCESSOS_COMPETICAO') OR define('VIEW_MODULO_TAREFAS_PROCESSOS_COMPETICAO', VIEW_MODULO_TAREFAS_PROCESSOS.'competicao/');
defined('VIEW_MODULO_TAREFAS_PROCESSOS_FINANCEIRO') OR define('VIEW_MODULO_TAREFAS_PROCESSOS_FINANCEIRO', VIEW_MODULO_TAREFAS_PROCESSOS.'financeiro/');
