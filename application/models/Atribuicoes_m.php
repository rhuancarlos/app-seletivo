<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

class Atribuicoes_m extends CI_Model {
  private $table_atribuicoes = null;
  function __construct(){
    parent::__construct();
    $this->table_atribuicoes = "atribuicoes";
  }

  public function getAll() {
    $this->db->order_by("descricao", "ASC");
    $query = $this->db->get($this->table_atribuicoes);
    return $query->num_rows() > 0 ? $query->result() : false;
  }

  public function getAtribuicao($id_atribuicao = null) {
    $this->db->select("*");
    $this->db->where("id", $id_atribuicao);
    $query = $this->db->get($this->table_atribuicoes);
    return $query->num_rows() > 0 ? $query->row() : false;
  }
}