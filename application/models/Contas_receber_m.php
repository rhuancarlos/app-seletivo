<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

class Contas_receber_m extends CI_Model {

  private $tabela = array();

  function __construct(){
    parent::__construct();
    $this->tabela = array('nome' => 'contas_receber', 'alias' => ' cr', 'pk' => 'idcontareceber');
  }

	public function getAll($arrLimite = false, $search = false, $paramPesquisaAvancada) {
		$this->db->select("*");
		$this->db->from($this->tabela['nome'].$this->tabela['alias']);

		if ($search) {
			$this->db->where("(UPPER({$this->tabela['alias']}.descricao) LIKE UPPER('%{$search}%'))", false, false);
		}

		if(!empty($paramPesquisaAvancada['situacao_pagamento'])) {
			$this->db->where("{$this->tabela['alias']}.situacao_pagamento_id", $paramPesquisaAvancada['situacao_pagamento']);
		}

		$this->db->order_by("{$this->tabela['alias']}.descricao, {$this->tabela['alias']}.idcontareceber", "asc");
		if($arrLimite) {
			$this->db->limit($arrLimite['limite'], $arrLimite['index']);
		}

		$query = $this->db->get();
		return $query->num_rows() > 0 ? $query->result() : false;
	}

  public function getById($id_conta) {
		$this->db->select("*");
    $this->db->where("{$this->tabela['alias']}.idcontareceber", $id_conta);
		$query = $this->db->get($this->tabela['nome'].''.$this->tabela['alias']);
    return $query->num_rows() > 0 ? $query->row() : false;
  }

  public function getConta($id_conta = false, $sigla = false) {
		if($id_conta) {
			$this->db->where('cr.idcontareceber', $id_conta);
		}
		if($sigla) {
			$this->db->where('cr.sigla', $sigla);
		}
    $query = $this->db->get($this->table_contasreceber);
    return $query->num_rows() > 0 ? $query->row() : false;
	}
	
	public function _insertRegistro($dadosInsert) {
    if(!$dadosInsert) {
      return false;
      exit;
		}
    $this->db->insert('contas_receber', $dadosInsert);
    return $this->db->insert_id();
  }

  public function _updateRegistro($dadosUpdate, $codigo_conta) {
    if(!$dadosUpdate) {
      return false;
      exit;
		}
		$this->db->where("idcontareceber", $codigo_conta);
		$update = $this->db->update($this->tabela['nome'], $dadosUpdate);
    return $this->db->affected_rows();
	}

  public function getAllCount($search = false) {
		$this->db->select("*");
		$this->db->from($this->tabela['nome'].$this->tabela['alias']);
		if ($search) {
			$this->db->where("
				(
					(UPPER({$this->tabela['alias']}.descricao) LIKE UPPER('%{$search}%'))
				)", false, false);
		}
		$query = $this->db->get();
		return $query->num_rows();
  }

}