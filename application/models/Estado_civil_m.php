<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

class Estado_civil_m extends CI_Model {
  private $table_estado_civil = null;
  function __construct(){
    parent::__construct();
    $this->table_estado_civil = "estado_civil";
  }

  public function getAll() {
    $this->db->order_by("descricao", "ASC");
    $query = $this->db->get($this->table_estado_civil);
    return $query->num_rows() > 0 ? $query->result() : false;
  }

  public function getEstadoCivil($id_estadoCivil = null) {
    $this->db->select("*");
    $this->db->where("idestadocivil", $id_estadoCivil);
    $query = $this->db->get($this->table_estado_civil);
    return $query->num_rows() > 0 ? $query->row() : false;
  }
}