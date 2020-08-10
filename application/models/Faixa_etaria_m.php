<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

class Faixa_etaria_m extends CI_Model {

  private $table_faixaetaria = null;

  function __construct(){
    parent::__construct();
    $this->table_faixaetaria = "faixa_etaria fxt";
  }

  public function getAll() {
    $this->db->order_by("fxt.id", "ASC");
    $query = $this->db->get($this->table_faixaetaria);
    return $query->num_rows() > 0 ? $query->result() : false;
  }
}