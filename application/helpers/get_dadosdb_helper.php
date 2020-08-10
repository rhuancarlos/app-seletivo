<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('getTotalParticipantesEquipes')):
  function getTotalParticipantesEquipes($id_equipe){
      $ci = & get_instance();
      $ci->load->model("competicao_participantes_m");
    if(!empty($id_equipe)){
      $return = $ci->competicao_participantes_m->getTotalParticipantesEquipes($id_equipe);
      return $return ? $return : false;
    } else {
      return false;
    }
  }
endif;

if(!function_exists('getDadosEquipe')):
  function getDadosEquipe($id_equipe){
      $ci = & get_instance();
      $ci->load->model("equipes_m");
    if(!empty($id_equipe)){
      $return = $ci->equipes_m->getById($ci->seguranca->dec($id_equipe));
      return $return ? $return : false;
    } else {
      return false;
    }
  }
endif;

if(!function_exists('getDadosTipoDocumento')):
  function getDadosTipoDocumento($id_tipodocumento){
    if(empty($id_tipodocumento)){ 
      return false;
    }
    $ci = & get_instance();
    $ci->load->model("tipo_documento_m");
    $return = $ci->tipo_documento_m->getById($id_tipodocumento);
    return $return ? $return : false;
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

if(!function_exists('verificaEquipeParticipante')):
  function verificaEquipeParticipante($id_participante) {
      if(!$id_participante) {
          return false;
      }
      $ci = & get_instance();
      $ci->load->model(array('competicao_participantes_m'));
      return $ci->competicao_participantes_m->participante_id($id_participante);
  }
endif;

if(!function_exists('getSituacaoPagamento')):
  function getSituacaoPagamento($id_situacao, $sigla) {
      if(!$id_situacao && (!$sigla)) {
        return false;
      }
      $ci = & get_instance();
      $ci->load->model(array('situacao_pagamento_m'));
      return $ci->situacao_pagamento_m->getSituacaoPagamento($id_situacao, $sigla);
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

    #$qPermissao = $ci->db->query("SELECT * FROM grupos_usuarios_acessos WHERE grupo_usuario_id = $grupo_usuario_id");
    #$retornoP = $qPermissao->num_rows() > 0 ? true : false;
    if($retornoU) {
      $emUso += 1;
    }
    #if($retornoP) {
    #  $emUso += 1;
    #}
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

if(!function_exists('getTotalUsuariosPorGrupo')):
  function getTotalUsuariosPorGrupo($id_grupo) {
    $ci =& get_instance();
    $ci->load->model('usuarios_m');
    $getdados = $ci->usuarios_m->countUsuariosNoGrupo($id_grupo);
    return $getdados ? $getdados : false;
  }
endif;

if(!function_exists('getContaAPagar')):
  function getContaAPagar($id_conta){
    $ci =& get_instance();
    $ci->load->model('contas_pagar_m');
    if(!empty($id_conta)) {
      $conta = $ci->contas_pagar_m->getById($id_conta);
      if(!$conta) {
        return false;
      }
      $conta->idcontapagar = $ci->seguranca->enc($conta->idcontapagar);
      $conta->situacao_pagamento_id = $ci->seguranca->enc($conta->situacao_pagamento_id);
      $conta->tipo_documento_id = $ci->seguranca->enc($conta->tipo_documento_id);
      return $conta;
    }
    return false;
  }
endif;

if(!function_exists('getContaAReceber')):
  function getContaAReceber($id_conta){
    $ci =& get_instance();
    $ci->load->model('contas_receber_m');
    if(!empty($id_conta)) {
      $conta = $ci->contas_receber_m->getById($id_conta);
      if(!$conta) {
        return false;
      }
      $conta->idcontareceber = $ci->seguranca->enc($conta->idcontareceber);
      $conta->situacao_pagamento_id = $ci->seguranca->enc($conta->situacao_pagamento_id);
      $conta->tipo_documento_id = $ci->seguranca->enc($conta->tipo_documento_id);
      return $conta;
    }
    return false;
  }
endif;