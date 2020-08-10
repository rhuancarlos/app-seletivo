<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

class Provas_m extends CI_Model {

  private $table_provas = null;

  function __construct(){
    parent::__construct();
    $this->table_provas = "provas pr";
  }

  public function getAll($arrLimite = false, $search = false, $parametros = false, $status = false) {
		$this->db->select("*");
		$this->db->from($this->table_provas);

		if ($search) {
			$this->db->where("((UPPER(pr.descricao) LIKE UPPER('%{$search}%'))OR (UPPER(pr.codigo) LIKE UPPER('%{$search}%')))", false, false);
		}
		if(isset($parametros['widget_tela_inicial'])) {
			$this->db->where("mostrar_widget_tela_inicial", $parametros['widget_tela_inicial']);
		}
		
		if($status) {
			$this->db->where("pr.status", $status);
		}

		$this->db->order_by("pr.descricao, pr.idprova", "asc");
		if($arrLimite) {
			$this->db->limit($arrLimite['limite'], $arrLimite['index']);
		}

		$query = $this->db->get();
		//print $this->db->last_query();
		return $query->num_rows() > 0 ? $query->result() : false;
	}

  public function getById($id_prova) {
		$this->db->select("*");
    $this->db->where('idprova', $id_prova);
		$query = $this->db->get($this->table_provas);
    return $query->num_rows() > 0 ? $query->row_array() : false;
  }

  public function getProva($id_prova = false, $codigo = false) {
		if($id_prova) {
			$this->db->where('pr.idprova', $id_prova);
		}
		if($codigo) {
			$this->db->where('pr.codigo', $codigo);
		}
    $query = $this->db->get($this->table_provas);
    return $query->num_rows() > 0 ? $query->row() : false;
	}
	
	public function _insertRegistro($dadosInsert) {
    if(!$dadosInsert) {
      return false;
      exit;
		}
		$this->db->insert('provas', $dadosInsert);
    $idprova = $this->db->insert_id();
		$this->_updateRegistro(array('codigo' => geraCodigoTamanhoPersonalizado($idprova, false, 5)), $idprova);
		return $idprova;
  }

  public function _updateRegistro($dadosUpdate, $codigo_prova) {
    if(!$dadosUpdate) {
      return false;
      exit;
		}
		$this->db->where("idprova", $codigo_prova);
		$update = $this->db->update($this->table_provas, $dadosUpdate);
    return $this->db->affected_rows();
	}

  public function getAllCount($search = false) {
		$this->db->select("*");
		$this->db->from($this->table_provas);
		if ($search) {
			$this->db->where("
				(
					(UPPER(pr.descricao) LIKE UPPER('%{$search}%')
				)
				OR 
					(UPPER(pr.codigo) LIKE UPPER('%{$search}%'))
				)", false, false);
		}
		$query = $this->db->get();
		return $query->num_rows();
  }
	
	public function _updateStatusProva($prova_id, $situacao) {
		if(!$prova_id && !$situacao) {
			return false;
		}
		$this->db->where("idprova", $prova_id);
    return $this->db->update($this->table_provas, $situacao);
	}

}