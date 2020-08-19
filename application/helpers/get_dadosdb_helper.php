<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('getTotalUsuariosPorGrupo')):
  function getTotalUsuariosPorGrupo($id_grupo) {
    $ci =& get_instance();
    $ci->load->model('usuarios_m');
    $getdados = $ci->usuarios_m->countUsuariosNoGrupo($id_grupo);
    return $getdados ? $getdados : false;
  }
endif;

if(!function_exists('getDadosUsuario')):
  function getDadosUsuario($id_usuario, $email_usuario = false, $mostrar_senha = false) {
    if(!$id_usuario && (!$email_usuario)) {
      return false;
    }
    $ci = & get_instance();
    $ci->load->model(array('usuarios_m'));
    $dados = $ci->usuarios_m->getUsuario($id_usuario, $email_usuario);
    if(!$mostrar_senha) {
      unset($dados->senha);
    }
    return $dados;
  }
endif;

if(!function_exists('getDadosParticipante')):
  function getDadosParticipante($id_participante) {
      if(!$id_participante) {
          return false;
      }
      $ci = & get_instance();
      $ci->load->model(array('participantes_m'));
      return $ci->participantes_m->getParticipante($id_participante);        
  }
endif;

if(!function_exists('getTabelasComPermissaoDeAcesso_ByGrupoAcessoId')):
  function getTabelasComPermissaoDeAcesso_ByGrupoAcessoId($grupo_usuario_id) {
    $ci = & get_instance();
    $ci->load->model('permissoes_m');
    $tabelas_acessos = null;
    $tabelas = $ci->permissoes_m->getAllByGrupoAcesso_id($grupo_usuario_id);
    if($tabelas) {
      foreach($tabelas as $t) {
        $tabelas_acessos[] = array('tab' => (int)$t->menu_item_id, 'nivel_c' => (int)$t->permissao_tipo);
      }
      return $tabelas_acessos;
    }
    return false;
  }
endif;

if(!function_exists('verificaUsoGrupoUsuario')):
  function verificaUsoGrupoUsuario($grupo_usuario_id){
    $ci = & get_instance();
    $emUso = 0;
    $qUsuario = $ci->db->query("SELECT * FROM usuarios WHERE grupo_usuario_id = $grupo_usuario_id");
    $retornoU = $qUsuario->num_rows() > 0 ? true : false;
    if($retornoU) {
      $emUso += 1;
    }
    return $emUso > 0 ? true:false;
  }
endif;

if(!function_exists('getMenuPai')):
  function getMenuPai($id_menu_filho, $id_menu_pai) {
    $ci =& get_instance();
    $ci->load->model('menus_itens_m');

    $getregistro = $ci->menus_itens_m->getById($id_menu_filho, $id_menu_pai);
    if(!$getregistro) {
      return false;
    }else{
      return $getregistro;
    }
  }
endif;

if(!function_exists('getSecoesMenus')):
  function getSecoesMenus() {
    $ci =& get_instance();
    $ci->load->model('menus_m');
    $getdados = $ci->menus_m->getAll();
    return $getdados ? $getdados : false;
  }
endif;

if(!function_exists('getMenusPai')):
  function getMenusPai($sub_menu) {
    $ci =& get_instance();
    $ci->load->model('menus_m');
    $getdados = $ci->menus_m->getTabelasMenus($sub_menu);
    return $getdados ? $getdados : false;
  }
endif;