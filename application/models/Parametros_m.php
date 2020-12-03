<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

class Parametros_m extends CI_Model{
	
	function __construct() {
		parent::__construct();
		$this->table_parametros = "parametros p";
	}

	public function getParametros($id_parametro = false, $secao = false, $descricao_parametro = false) {
		$this->db->select("*");
		$this->db->from($this->table_parametros);
		if($id_parametro) {
			$this->db->where("p.idparametro", $id_parametro);
		}
		
		if($secao){
			$this->db->where("p.secao like '%$secao%'");
		}
		
		$this->db->where("p.status", true);
		if($descricao_parametro) {
			$this->db->where("p.descricao_parametro like '%$descricao_parametro%'");
			$query = $this->db->get();
			return $query->num_rows() > 0 ? $query->row() : false;
		} else {
			$query = $this->db->get();
			return $query->num_rows() > 0 ? $query->result() : false;
		}
	}
	
	public function getParametroPorDescricao($descricao_parametro, $secao = false) {
		$this->db->select("*");
		$this->db->from($this->table_parametros);
		$this->db->where("p.descricao_parametro like '%$descricao_parametro%'");
		$this->db->where("p.secao like '%$secao%'");
		$this->db->where("p.status", 1);
		$query = $this->db->get();
		return $query->num_rows() > 0 ? $query->row() : false;
  }

}