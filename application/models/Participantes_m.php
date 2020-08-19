<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

class Participantes_m extends CI_Model{
	
	function __construct() {
		parent::__construct();
		$this->table_participantes = "participantes p";
		$this->table_competicao_participantes = "competicao_participantes cp";
		$this->table_equipes = "equipes e";
	}

  public function getByName($termo) {
		if(!$termo) {return false;}
		$this->db->select("
			p.idparticipante,
			p.prt_nomecompleto,
			p.prt_sexo,
			p.prt_telefone,
			p.prt_email,
			p.prt_instagram,
			p.lider_equipe,
			e.idequipe,
			e.descricao as equipe_participante
		");
		$this->db->from($this->table_participantes);
		$this->db->join($this->table_competicao_participantes, "p.idparticipante = cp.participante_id", "LEFT");
		$this->db->join($this->table_equipes, "e.idequipe = cp.equipe_id","LEFT");
		$this->db->where("
			(
				(UPPER(p.prt_nomecompleto) LIKE UPPER('%{$termo}%')
			)
			OR 
				(UPPER(p.prt_cpf) LIKE UPPER('%{$termo}%'))
			OR 
				(UPPER(e.descricao) LIKE UPPER('%{$termo}%'))
			)", false, false);
		$this->db->order_by("p.prt_nomecompleto, p.idparticipante", "asc");

		$query = $this->db->get();
		return $query->num_rows() > 0 ? $query->result() : false;
	}

  public function getAll($arrLimite = false, $search = false, $parametrosPesquisa = false) {
		$this->db->select("*");
		$this->db->from($this->table_participantes);
		$this->db->join($this->table_competicao_participantes, "p.idparticipante = cp.participante_id", "LEFT");
		$this->db->join($this->table_equipes, "e.idequipe = cp.equipe_id","LEFT");

		if ($search) {
			$this->db->where("
				(
					(UPPER(p.prt_nomecompleto) LIKE UPPER('%{$search}%')
				)
				OR 
					(UPPER(p.prt_cpf) LIKE UPPER('%{$search}%'))
				OR 
					(UPPER(e.descricao) LIKE UPPER('%{$search}%'))
				)", false, false);
		}
    if(!empty($parametrosPesquisa['filtro_equipe'])) {
      $this->db->where('cp.equipe_id', $parametrosPesquisa['filtro_equipe']);
		}
		if(!empty($parametrosPesquisa['term'])){
			$this->db->where("
			(UPPER(p.prt_nomecompleto) LIKE UPPER('%{$parametrosPesquisa['term']}%'))");
		}

		$this->db->order_by("p.prt_nomecompleto, p.idparticipante", "asc");
		if($arrLimite) {
			$this->db->limit($arrLimite['limite'], $arrLimite['index']);
		}

		$query = $this->db->get();
		return $query->num_rows() > 0 ? $query->result() : false;
	}

  public function getAllCount($search = false, $parametrosPesquisa) {
		$this->db->select("*");
		$this->db->from($this->table_participantes);
		$this->db->join($this->table_competicao_participantes, "p.idparticipante = cp.participante_id", "LEFT");

		if ($search) {
			$this->db->join('equipes e', "e.idequipe = cp.equipe_id", "LEFT");
			$this->db->where("
			(
				(UPPER(p.prt_nomecompleto) LIKE UPPER('%{$search}%')
			)
			OR 
				(UPPER(p.prt_cpf) LIKE UPPER('%{$search}%'))
			OR 
				(UPPER(e.descricao) LIKE UPPER('%{$search}%'))
			)", false, false);
		}
		
    if(!empty($parametrosPesquisa['filtro_equipe'])) {
      $this->db->where('cp.equipe_id', $parametrosPesquisa['filtro_equipe']);
		}
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function getParticipante($id_participante, $cpf = false) {
		$this->db->select("*");
		$this->db->from($this->table_participantes);
		$this->db->join($this->table_competicao_participantes, "cp.participante_id = p.idparticipante","LEFT");
		if($id_participante) {
			$this->db->where("p.idparticipante", $id_participante);
		}
		
		if($cpf){
			$this->db->where("prt_cpf", $cpf);
		}
		$query = $this->db->get();
		return $query->num_rows() > 0 ? $query->row() : false;
	} 

  public function _insertRegistro($dadosInsert) {
    if(!$dadosInsert) {
      return false;
      exit;
		}
    $this->db->insert('participantes', $dadosInsert);
    return $this->db->insert_id();
  }

  public function _updateRegistro($dadosUpdate, $codigo_participante) {
    if(!$dadosUpdate) {
      return false;
      exit;
		}
		#debug_array($dadosUpdate);
		$this->db->where("idparticipante", $codigo_participante);
    $update = $this->db->update($this->table_participantes, $dadosUpdate);
    return $update || false;
	}
	
  public function getTotalParticipantes() {
    $query = $this->db->select("COUNT(*) as num")->get($this->table_participantes);
    $result = $query->row();
    if(isset($result)) return $result->num;
    return 0;
	}

}