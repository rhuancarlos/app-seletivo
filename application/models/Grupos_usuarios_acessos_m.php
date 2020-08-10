<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

class Grupos_usuarios_acessos_m extends CI_Model{
	private $table_grupos_usuarios_acessos = null;
	function __construct() {
		parent::__construct();
		$this->table_grupos_usuarios_acessos = "grupos_usuarios_acessos";
	}

  public function getById($id) {
    if(!$id) { return false; } 

    $this->db->where("id", $id);
    $query = $this->db->get($this->table_grupos_usuarios_acessos);
    return $query->num_rows() > 0 ? $query->row() : false;
  }

  public function getAcessosGrupoUsuarioById($id, $sub = false) {
    if(!$id) { return false; } 

    //$query = $this->db->get($this->table_grupos_usuarios_acessos);
    #$this->db->select("gua.id as id_tab_grupo_usuarios_acessos,	gua.grupo_usuario_id, gua.permissao_tipo, gua.menu_item_id");
    $this->db->select("gua.*, mi.sub_menu");
    $this->db->from("grupos_usuarios_acessos gua");
    $this->db->join("menus_itens mi", "mi.id = gua.menu_item_id");
    $this->db->where("gua.grupo_usuario_id", $id);
/*     if($sub) {
      $this->db->where("mi.sub_menu", 1);
    } else {
    } */
    //$this->db->where("mi.sub_menu", 0);
    $query = $this->db->get();
    //print $this->db->last_query();exit;
    return $query->num_rows() > 0 ? $query->result() : false;
  }

  public function _insertRegistro($dados_grupo_usuario) {
    if(!$dados_grupo_usuario) {
      return false;
      exit;
		}
		$this->db->insert($this->table_grupos_usuarios_acessos, $dados_grupo_usuario);
		return $this->db->insert_id();
	}

	public function _updateRegistro($dados_grupo_usuario, $grupo_codigo = false, $menu_item_id = false, $id = false) {
    // if(!$dados_grupo_usuario && !$grupo_codigo) {
    //   return false;
    //   exit;
    // }
    if($id) {
      $this->db->where("id", $id);
    }
    if($grupo_codigo) {
      $this->db->where("grupo_usuario_id", $grupo_codigo);
    }
    if($menu_item_id) {
      $this->db->where("menu_item_id", $menu_item_id);
    }
    $update = $this->db->update($this->table_grupos_usuarios_acessos, $dados_grupo_usuario);
    //print $this->db->last_query();exit;
		return $update ? true : false;
  }
  
	public function verificaSePermissaoExiste($id_grupo = false, $menu_item_id = false) {
		if(!$id_grupo && (!$menu_item_id)) {
			return false;
		}
		$this->db->where('grupo_usuario_id', $id_grupo);
		$this->db->where('menu_item_id', $menu_item_id);
		$query = $this->db->get($this->table_grupos_usuarios_acessos);
		return $query->num_rows() > 0 ? true : false;
	}

  public function _deleteOpcaoAcesso($post, $id = false) {
    if(!$post) {
      return false;
    }
    if($id) {
      return $this->db->delete($this->table_grupos_usuarios_acessos, array('id' => $id));
    }
    if($post) {
      return $this->db->delete($this->table_grupos_usuarios_acessos, $post);
    }
  }
}