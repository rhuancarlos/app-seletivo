<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_perfil_m extends CI_Model{
	private $table_usuarios = null;
	function __construct() {
		parent::__construct();
		$this->table_usuarios = "usuarios u";
		$this->table_perfil_usuarios = "usuarios_perfil up";
		$this->table_atribuicoes = "atribuicoes a";
		$this->table_participantes = "participantes p";
	}

  public function getAll($arrLimite = false, $search = false, $parametrosPesquisa = false) {
		$this->db->select("*");
		$this->db->from($this->table_usuarios);
		$this->db->join($this->table_perfil_usuarios, "up.usuario_id = u.idusuario", "LEFT");
		$this->db->join($this->table_participantes, "p.prt_usuario_id = u.idusuario","LEFT");
		if ($search) {
			$this->db->where("
				(
					(UPPER(p.prt_nomecompleto) LIKE UPPER('%{$search}%')
				)
				OR 
					(UPPER(u.login) LIKE UPPER('%{$search}%'))
				OR 
					(UPPER(u.email) LIKE UPPER('%{$search}%'))
				OR 
					(UPPER(up.usuario_nome_display) LIKE UPPER('%{$search}%'))
				)", false, false);
		}
    #if(!empty($parametrosPesquisa['filtro_equipe'])) {
    #  $this->db->where('cp.equipe_id', $parametrosPesquisa['filtro_equipe']);
		#}

		$this->db->order_by("up.usuario_nome_display, u.status", "asc");
		if($arrLimite) {
			$this->db->limit($arrLimite['limite'], $arrLimite['index']);
		}

		$query = $this->db->get();
		//print $this->db->last_query();
		return $query->num_rows() > 0 ? $query->result() : false;
	}	
}