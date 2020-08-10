<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipo_documento_m extends CI_Model {

  private $tabela = array();

  function __construct(){
    parent::__construct();
    $this->tabela = array('nome' => 'tipo_documento', 'alias' => ' td');
  }

  public function getAll($arrLimite = false, $search = false, $parametros = false, $status = false) {
		$this->db->select("*");
		$this->db->from($this->tabela['nome'].$this->tabela['alias']);

		if ($search) {
			$this->db->where("((UPPER({$this->tabela['alias']}.descricao) LIKE UPPER('%{$search}%')))", false, false);
		}
		
		if($status) {
			$this->db->where("{$this->tabela['alias']}.status", $status);
		}

		$this->db->order_by("{$this->tabela['alias']}.descricao, {$this->tabela['alias']}.status", "asc");
		if($arrLimite) {
			$this->db->limit($arrLimite['limite'], $arrLimite['index']);
		}

		$query = $this->db->get();
		return $query->num_rows() > 0 ? $query->result() : false;
	}

  public function getById($id_documento) {
    $this->db->select("*");
    $this->db->from($this->tabela['nome']);
    $this->db->where('idtipodocumento', $id_documento);
    $query = $this->db->get();
    return $query->num_rows() > 0 ? $query->row() : false;
  }

  public function getTipoDocumento($id_tipodoc = false, $sigla = false) {
    $this->db->select("*");
    if($id_tipodoc) {
      $this->db->where('idtipodocumento', $id_tipodoc);
    }
    if($sigla) {
      $this->db->where('sigla', $sigla);
    }
    $query = $this->db->get($this->tabela['nome']);
    return $query->num_rows() > 0 ? $query->row() : false;
  }

	public function _insertRegistro($dadosInsert) {
    if(!$dadosInsert) {
      return false;
      exit;
		}
    $this->db->insert($this->tabela['nome'], $dadosInsert);
    return $this->db->insert_id();
  }

  public function _updateRegistro($dadosUpdate, $codigo_tipodoc) {
    if(!$dadosUpdate) {
      return false;
      exit;
		}
		$this->db->where("idtipodocumento", $codigo_tipodoc);
		$update = $this->db->update($this->tabela['nome'], $dadosUpdate);
    return $this->db->affected_rows();
	}

  public function getAllCount($search = false) {
		$this->db->select("*");
		$this->db->from($this->tabela['nome']);
		if ($search) {
			$this->db->where("
				(
					(UPPER({$this->tabela['alias']}.descricao) LIKE UPPER('%{$search}%')
				)
				OR 
					(UPPER({$this->tabela['alias']}.sigla) LIKE UPPER('%{$search}%'))
				)", false, false);
		}
		$query = $this->db->get();
		return $query->num_rows();
  }

}