<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

class Equipes_m extends CI_Model {

  private $table_equipes = null;

  function __construct(){
    parent::__construct();
    $this->table_equipes = "equipes eq";
  }

  public function getAll($arrLimite = false, $search = false, $parametros = false, $status = false) {
		$this->db->select("*");
		$this->db->from($this->table_equipes);

		if ($search) {
			$this->db->where("((UPPER(eq.nome) LIKE UPPER('%{$search}%'))OR (UPPER(eq.sigla) LIKE UPPER('%{$search}%')))", false, false);
		}
		if(isset($parametros['widget_tela_inicial'])) {
			$this->db->where("mostrar_widget_tela_inicial", $parametros['widget_tela_inicial']);
		}
		
		if($status) {
			$this->db->where("eq.status", $status);
		}

		$this->db->order_by("eq.descricao, eq.idequipe", "asc");
		if($arrLimite) {
			$this->db->limit($arrLimite['limite'], $arrLimite['index']);
		}

		$query = $this->db->get();
		//print $this->db->last_query();
		return $query->num_rows() > 0 ? $query->result() : false;
	}

  public function getById($id_equipe) {
		$this->db->select("*");
    $this->db->where('idequipe', $id_equipe);
		$query = $this->db->get($this->table_equipes);
		#print $this->db->last_query();exit;
    return $query->num_rows() > 0 ? $query->row_array() : false;
  }

  public function getEquipe($id_equipe = false, $sigla = false) {
		if($id_equipe) {
			$this->db->where('eq.idequipe', $id_equipe);
		}
		if($sigla) {
			$this->db->where('eq.sigla', $sigla);
		}
    $query = $this->db->get($this->table_equipes);
    return $query->num_rows() > 0 ? $query->row() : false;
	}
	
	public function _insertRegistro($dadosInsert) {
    if(!$dadosInsert) {
      return false;
      exit;
		}
    $this->db->insert('equipes', $dadosInsert);
    return $this->db->insert_id();
  }

  public function _updateRegistro($dadosUpdate, $codigo_equipe) {
    if(!$dadosUpdate) {
      return false;
      exit;
		}
		$this->db->where("idequipe", $codigo_equipe);
		$update = $this->db->update($this->table_equipes, $dadosUpdate);
    return $this->db->affected_rows();
	}

  public function getAllCount($search = false) {
		$this->db->select("*");
		$this->db->from($this->table_equipes);
		if ($search) {
			$this->db->where("
				(
					(UPPER(eq.nome) LIKE UPPER('%{$search}%')
				)
				OR 
					(UPPER(eq.sigla) LIKE UPPER('%{$search}%'))
				)", false, false);
		}
		$query = $this->db->get();
		return $query->num_rows();
  }
  
  public function getTotalParticipantesEquipes($id_equipe) {
    if(!$id_equipe) {
      return false;
    }
    $this->db->select("count(*) as total_participantes");
    $this->db->where("ed.idequipe", $id_equipe);
    $query = $this->db->get($this->table_equipes);
    return $query->num_rows() > 0 ? $query->row() : false;
	}
	
	public function _updateStatusEquipe($equipe_id, $situacao) {
		if(!$equipe_id && !$situacao) {
			return false;
		}
		$this->db->where("idequipe", $equipe_id);
    return $this->db->update($this->table_equipes, $situacao);
	}

}