<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

class Competicao_periodo_m extends CI_Model {

  private $table_competicao = null;

  function __construct(){
    parent::__construct();
    $this->table_competicao = "competicao_periodo";
  }

  public function getById($id_competicao) {
    $this->db->where($id_competicao);
    $query = $this->db->get($this->table_competicao);
    return $query ? $query->row() : false;
  }
}