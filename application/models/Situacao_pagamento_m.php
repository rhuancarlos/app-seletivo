<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

class Situacao_pagamento_m extends CI_Model {

  private $tabela = array();

  function __construct(){
    parent::__construct();
    $this->tabela = array('nome' => 'situacao_pagamento', 'alias' => ' sp', 'pk' => 'idsituacaopagamento');
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

  public function getById($id_situacao) {
		$this->db->select("*");
    $this->db->where($this->tabela['pk'], $id_situacao);
		$query = $this->db->get($this->tabela['nome']);
    return $query->num_rows() > 0 ? $query->row_array() : false;
  }

  public function getSituacaoPagamento($id_situacao = false, $sigla = false) {
		$this->db->select("*");
		$this->db->from($this->tabela['nome'].$this->tabela['alias']);
    if($id_situacao) {
      $this->db->where("{$this->tabela['alias']}.idsituacaopagamento", $id_situacao);
    }
    if($sigla) {
      $this->db->where("{$this->tabela['alias']}.sigla", $sigla);
    }
    $query = $this->db->get();
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

  public function _updateRegistro($dadosUpdate, $codigo_situacao) {
    if(!$dadosUpdate) {
      return false;
      exit;
		}
		$this->db->where($this->tabela['pk'], $codigo_situacao);
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