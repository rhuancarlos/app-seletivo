<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

class Tipos_inscricao_m extends CI_Model{
	
	function __construct() {
		parent::__construct();
		$this->table_tipos_inscricao = "tipos_inscricoes ti";
	}

	public function getTiposInscricoes() {
		$this->db->select("*");
		$this->db->from($this->table_parametros);
		$this->db->where("i.status", true);
		$query = $this->db->get();
		return $query->num_rows() > 0 ? $query->result() : false;
	}
	
	public function getTipoInscricao($id_tipo_inscricao = false, $sigla = false) {
		$this->db->select("*");
        $this->db->from($this->table_tipos_inscricao);
        if($id_tipo_inscricao) {
            $this->db->where("ti.idtipoinscricao",$id_tipo_inscricao);
        }
        if($sigla) {
            $this->db->where("ti.sigla like '%$sigla%'");
        }
		$this->db->where("ti.status", 1);
		$query = $this->db->get();
		return $query->num_rows() > 0 ? $query->row() : false;
  }

}