<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

class Grupos_usuarios_m extends CI_Model{
	private $table_grupos_usuarios = null;
	private $table_grupos_usuarios_acessos = null;
	function __construct() {
		parent::__construct();
		$this->table_grupos_usuarios = "grupos_usuarios";
		$this->table_grupos_usuarios_acessos = "grupos_usuarios_acessos";
	}

  public function getById($id) {
    if(!$id) { return false; } 

    $this->db->where("id", $id);
    $query = $this->db->get($this->table_grupos_usuarios);
    return $query->num_rows() > 0 ? $query->row() : false;
  }

  public function getAll($arrLimite = false, $search = false, $administrador = false) {
		$this->db->select("*");
		$this->db->from($this->table_grupos_usuarios." gu");
		if ($search) {
			$this->db->where("((UPPER(gu.descricao) LIKE UPPER('%{$search}%')))", false, false);
		}
		
		if(!$administrador) {
			$this->db->where("
				((gu.deletado = 0) || gu.deletado IS NULL || gu.deletado = '')
				AND (gu.deletado_data = '' || gu.deletado_data IS NULL || gu.deletado_data = '') 
				AND (gu.usuario_deletado = '' || gu.usuario_deletado IS NULL)
			");
		}
		
		$this->db->order_by("gu.descricao, gu.status", "asc");
		if($arrLimite) {
			$this->db->limit($arrLimite['limite'], $arrLimite['index']);
		}
		$query = $this->db->get();
		//print $this->db->last_query();
		return $query->num_rows() > 0 ? $query->result() : false;
  }
  
  public function getAllCount($search = false, $administrador = false) {
		$this->db->select("*");
		$this->db->from($this->table_grupos_usuarios." gu");
		if ($search) {
			$this->db->where("((UPPER(gu.descricao) LIKE UPPER('%{$search}%')))", false, false);
		}
		if(!$administrador) {
			$this->db->where("
				(gu.deletado = 0 || gu.deletado IS NULL || gu.deletado = '')
				AND (gu.deletado_data = '' || gu.deletado_data IS NULL || gu.deletado_data = '') 
				AND (gu.usuario_deletado = '' || gu.usuario_deletado IS NULL)
			");
		}
		$query = $this->db->get();
		return $query->num_rows();
	}

  public function _insertRegistro($dados_grupo_usuario) {
    if(!$dados_grupo_usuario) {
      return false;
      exit;
		}
		$this->db->insert('grupos_usuarios', $dados_grupo_usuario);
		return $this->db->insert_id();
	}

	public function _updateRegistro($dados_grupo_usuario, $grupo_codigo) {
    if(!$dados_grupo_usuario && !$grupo_codigo) {
      return false;
      exit;
		}
		$this->db->where("id", $grupo_codigo);
		$update = $this->db->update("grupos_usuarios", $dados_grupo_usuario);
		return $update ? true : false;
	}

	public function _updateStatusGrupoUsuario($grupo_usuario_id, $situacao) {
		if(!$grupo_usuario_id && !$situacao) {
			return false;
		}
		$this->db->where("id", $grupo_usuario_id);
    return $this->db->update($this->table_grupos_usuarios, $situacao);
	}

	public function _deleteGrupoUsuario($grupo_usuario_id) {
		if(!$grupo_usuario_id) {
			return false;
		}
		$delPermissoesGrupo = $this->db->delete($this->table_grupos_usuarios_acessos, array('grupo_usuario_id' => $grupo_usuario_id));
    $delGrupo = $this->db->delete($this->table_grupos_usuarios, array('id' => $grupo_usuario_id));
		if($delGrupo && $delPermissoesGrupo) {
			return true;
		} else {
			return false;
		}
	}

/* 	public function _deleteGrupoUsuario($grupo_usuario_id, $situacao) {
		if(!$grupo_usuario_id && !$situacao) {
			return false;
		}
		$this->db->where("id", $grupo_usuario_id);
		return $this->db->update($this->table_grupos_usuarios, $situacao);
	} */
}