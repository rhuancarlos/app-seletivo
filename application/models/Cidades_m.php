<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

class Cidades_m extends CI_Model {

    private $table_cidades = null;

    function __construct(){
        parent::__construct();
        $this->table_cidades = "cidades";
        $this->table_estados = "estados";
    }

    public function getAll() {
        $this->db->order_by("municipio", "ASC");
        $query = $this->db->get($this->table_cidades);
        return $query->num_rows() > 0 ? $query->result() : false;
    }

    public function getCidadesByEstado($id_estado = false, $sigla = false) {
        $this->db->select("*");
        $this->db->from($this->table_cidades . ' c');
        $this->db->join($this->table_estados . ' e ', "e.idestado = c.idestado");
        if($id_estado) {
            $this->db->where('c.idestado', $id_estado);
        }
        if($sigla) {
            $this->db->where("e.uf", $sigla);
        }
        $query = $this->db->get();
        #print $this->db->last_query();
        return $query->num_rows() > 0 ? $query->result() : false;
    }

    public function getCidadeComEstado($id_cidade) {
        $this->db->select("idcidade, municipio, estado");
        $this->db->from('`'.$this->table_cidades.'` c');
        $this->db->join($this->table_estados."` e`", "c.idestado = e.idestado", "left");
        $this->db->where("c.idcidade", $id_cidade);
        $query = $this->db->get()->row();
        return !empty($query) ? $query : false;
    }
    
}