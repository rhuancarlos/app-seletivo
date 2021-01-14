<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

class Index_m extends CI_Model {

	private $table_estados = null;
	function __construct(){
		parent::__construct();
		$this->table_estados = "estados";
	}

	public function getAll() {
		$this->db->order_by("ESTADO", "ASC");
		$query = $this->db->get($this->table_estados);
		return $query->num_rows() > 0 ? $query->result() : false;
	}

	public function getEstado($id_estado = null) {
		$this->db->select("*");
		$this->db->where("ESTADO", $id_estado);
		$query = $this->db->get($this->table_estados);
		return $query->num_rows() > 0 ? $query->row() : false;
	}   
}