<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

class Contas_pagar_m extends CI_Model {

  private $tabela = array();

  function __construct(){
    parent::__construct();
    $this->tabela = array('nome' => 'contas_pagar', 'alias' => ' cp', 'pk' => 'idcontapagar');
  }

  public function getAll($arrLimite = false, $search = false, $paramPesquisaAvancada) {
		$this->db->select("*");
		$this->db->from($this->tabela['nome'].$this->tabela['alias']);

		if($search) {
			$this->db->where("
				(
					(
						UPPER({$this->tabela['alias']}.descricao) LIKE UPPER('%{$search}%')
					)
				)
			", false, false);
		}

		if(!empty($paramPesquisaAvancada['situacao_pagamento'])) {
			$this->db->where("{$this->tabela['alias']}.situacao_pagamento_id", $paramPesquisaAvancada['situacao_pagamento']);
		}

		// if(!empty($paramPesquisaAvancada['data'])) {
		// 	$this->db->where("{$this->tabela['alias']}.created", $paramPesquisaAvancada['datas']);
		// }

		$this->db->order_by("{$this->tabela['alias']}.descricao, {$this->tabela['alias']}.idcontapagar", "asc");
		if($arrLimite) {
			$this->db->limit($arrLimite['limite'], $arrLimite['index']);
		}

		$query = $this->db->get();
		return $query->num_rows() > 0 ? $query->result() : false;
	}

  public function getById($id_conta) {
		$this->db->select("*");
    $this->db->where("{$this->tabela['alias']}.idcontapagar", $id_conta);
		$query = $this->db->get($this->tabela['nome'].''.$this->tabela['alias']);
    return $query->num_rows() > 0 ? $query->row() : false;
  }

  public function getConta($id_conta = false, $sigla = false) {
		if($id_conta) {
			$this->db->where("{$this->tabela['alias']}.idcontapagar", $id_conta);
		}
		if($sigla) {
			$this->db->where("{$this->tabela['alias']}.sigla", $sigla);
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

  public function _updateRegistro($dadosUpdate, $codigo_conta) {
    if(!$dadosUpdate) {
      return false;
      exit;
		}
		$this->db->where("idcontapagar", $codigo_conta);
		$update = $this->db->update($this->tabela['nome'], $dadosUpdate);
    return $this->db->affected_rows();
	}

  public function getAllCount($search = false, $paramPesquisaAvancada) {
		$this->db->select("*");
		$this->db->from($this->tabela['nome'].$this->tabela['alias']);
		if ($search) {
			$this->db->where("
				(
					(UPPER({$this->tabela['alias']}.descricao) LIKE UPPER('%{$search}%'))
				)", false, false);
		}
		if(!empty($paramPesquisaAvancada['situacao_pagamento'])) {
			$this->db->where("{$this->tabela['alias']}.situacao_pagamento_id", $paramPesquisaAvancada['situacao_pagamento']);
		}
		$query = $this->db->get();
		return $query->num_rows();
  }

}