<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

class Parametros_m extends CI_Model{
	
	function __construct() {
		parent::__construct();
		$this->table_parametros = "parametros p";
	}

	public function getParametros($id_parametro, $secao = false, $descricao_parametro = false) {
		$this->db->select("*");
		$this->db->from($this->table_parametros);
		if($id_parametro) {
			$this->db->where("p.idparametro", $id_parametro);
		}
		
		if($secao){
			$this->db->where("p.secao like '%$secao%'");
		}
		
		if($descricao_parametro) {
			$this->db->where("p.descricao_parametro like '%$descricao_parametro%'");
		}
		$this->db->where("p.status", true);
		$query = $this->db->get();
		return $query->num_rows() > 0 ? $query->result() : false;
	}
	
	public function getParametroPorDescricao($descricao_parametro) {
		$this->db->select("*");
		$this->db->from($this->table_parametros);
		$this->db->where("p.descricao_parametro like '%$descricao_parametro%'");
		$this->db->where("p.status", 1);
		$query = $this->db->get();
		return $query->num_rows() > 0 ? $query->row() : false;
  }
  

  // public function _insertRegistro($dadosInsert) {
  //   if(!$dadosInsert) {
  //     return false;
  //     exit;
	// 	}
  //   $this->db->insert('agendamentos', $dadosInsert);
  //   return $this->db->insert_id();
  // }

  // public function _updateRegistro($dadosUpdate, $codigo_agendamento) {
  //   if(!$dadosUpdate) {
  //     return false;
  //     exit;
	// 	}
	// 	$this->db->where("idagendamento", $codigo_agendamento);
  //   $update = $this->db->update($this->table_parametros, $dadosUpdate);
  //   return $update || false;
	// }
	
  // public function getTotalAgendamentos() {
  //   $query = $this->db->select("COUNT(*) as num")->get($this->table_parametros);
  //   $result = $query->row();
  //   if(isset($result)) return $result->num;
  //   return 0;
	// }

}