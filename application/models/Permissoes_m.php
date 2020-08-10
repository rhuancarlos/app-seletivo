<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

class Permissoes_m extends CI_Model{
	private $table_grupos_usuarios_acessos = null;
	function __construct() {
		parent::__construct();
		$this->table_grupos_usuarios_acessos = "grupos_usuarios_acessos";
	}

  public function verificaAcesso($id_tabela, $id_grupo_acesso) {
    if(!$id_grupo_acesso) { return false; } 

    $this->db->select('*');
    $this->db->from($this->table_grupos_usuarios_acessos);
    $this->db->where('grupo_usuario_id', $id_grupo_acesso);
    $this->db->where('menu_item_id', $id_tabela);
    $query = $this->db->get();
    return $query->num_rows() > 0 ? $query->row() : false;
  }

  public function getAllByGrupoAcesso_id($id_grupo_acesso) {
    if(!$id_grupo_acesso) { return false; } 
    $this->db->select('*');
    $this->db->from($this->table_grupos_usuarios_acessos);
    $this->db->where('grupo_usuario_id', $id_grupo_acesso);
    $query = $this->db->get();
    return $query->num_rows() > 0 ? $query->result() : false;
  }

  public function getAll(){
    return $this->db->get($this->table_grupos_usuarios)->result();
  }

}