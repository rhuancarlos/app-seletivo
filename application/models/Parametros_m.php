<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

class Parametros_m extends CI_Model {

  private $table_parametros = null;

  function __construct(){
    parent::__construct();
    $this->table_parametros = "parametros";
  }

  public function getAll() {
    $this->db->order_by("descricao", "ASC");
    $query = $this->db->get($this->table_parametros);
    return $query->num_rows() > 0 ? $query->result() : false;
  }

  public function getById($id_parametro) {
    $this->db->where('idparametro', $id_parametro);
    $query = $this->db->get($this->table_parametros);
    return $query->num_rows() > 0 ? $query->row() : false;
  }
}