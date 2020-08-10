<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_m extends CI_Model{
	private $table_usuarios = null;
	function __construct() {
		parent::__construct();
		$this->table_usuarios = "usuarios u";
		$this->table_perfil_usuarios = "usuarios_perfil up";
		$this->table_atribuicoes = "atribuicoes a";
		$this->table_participantes = "participantes p";
	}

  public function getAll($arrLimite = false, $search = false) {
		$this->db->select("
		u.idusuario,
		u.id_cadparticipante,
		u.grupo_usuario_id,
		(SELECT descricao FROM grupos_usuarios WHERE id = u.grupo_usuario_id) as grupo_usuario_descricao,
		u.login,
		u.status,
		u.acessos,
		u.administrador,
		u.criacao,
		u.usuario_criacao,
		u.data_modificacao,
		u.usuario_modificacao,
		u.ip_cadastro,
		u.deletado,
		u.data_deletado,
		u.usuario_deletado,
		up.*,
		p.*");
		$this->db->from($this->table_usuarios);
		$this->db->join($this->table_perfil_usuarios, "up.usuario_id = u.idusuario", "LEFT");
		$this->db->join($this->table_participantes, "p.prt_usuario_id = u.idusuario","LEFT");
		$this->db->order_by("up.usuario_nome_display, u.status", "asc");
		if($arrLimite) {
			$this->db->limit($arrLimite['limite'], $arrLimite['index']);
		}
		if ($search) {
			$this->db->where("((UPPER(up.usuario_primeiro_nome) LIKE UPPER('%{$search}%')) OR (UPPER(u.login) LIKE UPPER('%{$search}%')))", false, false);
		}

		$query = $this->db->get();
		//print $this->db->last_query();
		return $query->num_rows() > 0 ? $query->result() : false;
	}

  public function getAllCount($search = false) {
		$this->db->select("*");
		$this->db->from($this->table_usuarios);
		if($search) {
			$this->db->join($this->table_perfil_usuarios, "u.idusuario = up.usuario_id", "LEFT");
			$this->db->where("
			(
				(UPPER(up.usuario_primeiro_nome) LIKE UPPER('%{$search}%')) 
					OR 
				(UPPER(up.usuario_telefone) LIKE UPPER('%{$search}%'))
					OR 
				(UPPER(u.login) LIKE UPPER('%{$search}%'))
			)", false, false);
		}
		$query = $this->db->get();
		return $query->num_rows();
  }

	public function getUsuario($id_usuario, $email = false) {
		$this->db->select("
		u.idusuario,
		u.id_cadparticipante,
		u.login,
		u.senha,
		u.grupo_usuario_id,
		u.status,
		u.acessos,
		u.administrador,
		u.criacao,
		u.usuario_criacao,
		u.data_modificacao,
		u.usuario_modificacao,
		u.ip_cadastro,
		u.deletado,
		u.data_deletado,
		u.usuario_deletado,
		up.idperfilusuario,
		up.usuario_primeiro_nome,
		up.genero,
		up.usuario_nome_display,
		up.ultima_atualizacao,
		up.usuario_foto_nome_original,
		up.usuario_foto_extensao,
		up.usuario_foto_nome,
		up.usuario_foto_caminho_relativo,
		up.usuario_telefone,
		up.atribuicao_id,
		a.descricao as descricao_atribuicao,
		a.descricao_curta as descricao_curta_atribuicao
		");
		$this->db->from($this->table_usuarios);
		$this->db->join($this->table_perfil_usuarios,"up.usuario_id = u.idusuario", "LEFT");
		$this->db->join($this->table_atribuicoes,"a.id = up.atribuicao_id", "LEFT");
		if($id_usuario) {
			$this->db->where("idusuario", $id_usuario);
		}

		if($email) {
			$this->db->like("login", $email);
		}
		$query = $this->db->get();
		return $query->num_rows() > 0 ? $query->row() : false;
	} 

	public function validarUsuario($dadosLogin){
		if(empty($dadosLogin)){
			return false;
		}
		$this->db->select("*");
		$this->db->from($this->table_usuarios);
		$this->db->where("login", $dadosLogin->email);
		$this->db->where("senha", $dadosLogin->senha);
		$query = $this->db->get();
		//print $this->db->last_query();
		//exit;
		return $query->num_rows() > 0 ? $query->row()->idusuario : false;
	}

	public function coutAcessos($coutAcessos, $id_usuario) {
		$this->db->where("idusuario", $id_usuario);
		return $this->db->update($this->table_usuarios, $coutAcessos);
	}

  public function _insertRegistro($dados_tabela_usuario, $dados_tabela_perfil_usuario) {
    if(!$dados_tabela_usuario && !$dados_tabela_perfil_usuario) {
      return false;
      exit;
		}
		$this->db->insert('usuarios', $dados_tabela_usuario);
		$usuario_id = $this->db->insert_id();
		return $this->_insertPerfilUsuario($dados_tabela_perfil_usuario, $usuario_id) ? true : false;
	}
	
	private function _insertPerfilUsuario($dados_tabela_perfil_usuario, $usuario_id) {
    if(!$dados_tabela_perfil_usuario && !$usuario_id) {
      return false;
		}
		$dados_tabela_perfil_usuario['usuario_id'] = $usuario_id;
    return $this->db->insert('usuarios_perfil', $dados_tabela_perfil_usuario) ? true : false;
	}

  public function _updateRegistro($dados_tabela_usuario, $dados_tabela_perfil_usuario, $codigo_usuario) {
    if(!$dados_tabela_usuario && !$dados_tabela_perfil_usuario && !$codigo_usuario) {
      return false;
      exit;
		}
		$this->db->where("idusuario", $codigo_usuario);
		if($this->db->update('usuarios', $dados_tabela_usuario)) {
			$this->db->where('usuario_id', $codigo_usuario);
			$this->db->update('usuarios_perfil', $dados_tabela_perfil_usuario);
			return true;
		} else {
			return false;
		}
	}

	public function _updateStatusUsuario($usuario_id, $situacao) {
		if(!$usuario_id && !$situacao) {
			return false;
		}
		$this->db->where("idusuario", $usuario_id);
    return $this->db->update($this->table_usuarios, $situacao);
	}

	public function countUsuariosNoGrupo($id_grupo) {
		$this->db->where('grupo_usuario_id', $id_grupo);
		$query = $this->db->get($this->table_usuarios);
		return $query->num_rows();
	}
}