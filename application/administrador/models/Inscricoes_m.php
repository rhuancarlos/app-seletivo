<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

class Inscricoes_m extends CI_Model{
	
	function __construct() {
		parent::__construct();
		$this->table_inscricoes = "inscricoes i";
	}

	public function getInscricao($id_inscricao = false, $cpf = false, $data_nascimento = false) {
		$this->db->select("*");
		$this->db->from($this->table_inscricoes);
		if($id_inscricao) {
			$this->db->where("i.idinscricao", $id_inscricao);
		}
		
		if($cpf){
			$this->db->where("i.cpf like '%$cpf%'");
		}
		
		if($data_nascimento){
			$this->db->where("i.data_nascimento like '%$data_nascimento%'");
		}
		$query = $this->db->get();
		return $query->num_rows() > 0 ? $query->row() : false;
	}	
	
	public function _insertRegistro($dadosInsert, $tabela = 'inscricoes') {
		if(!$dadosInsert) {
			return false;
			exit;
		}
		$this->db->insert($tabela, $dadosInsert);
		return $this->db->insert_id();
	}

  	public function _updateRegistro($dadosUpdate, $id_inscricao) {
    	if(!$dadosUpdate) {
      		return false;
      		exit;
		}
		$this->db->where("idinscricao", $id_inscricao);
		$update = $this->db->update($this->table_inscricoes, $dadosUpdate);
		return $update;
	}

	public function verificarSeExisteInscricao($termoValidacao = false) {	
		if(!empty($termoValidacao)){
			if(isset($termoValidacao['email'])) {
				$this->db->where("i.email like '%".$termoValidacao['email']."%'");
			}
		}
		$query = $this->db->get($this->table_inscricoes);
		return $query->num_rows() > 0 ? true : false;
	}

	public function getInscricoes($status = 1) {
		$this->db->select("*");
		$this->db->from($this->table_inscricoes);
		$this->db->where("status", $status);
		// $this->db->order_by("nome_completo", "ASC");
		$this->db->order_by("created", "DESC");
		$query = $this->db->get();
		// print $this->db->last_query();exit;
    return $query->num_rows() > 0 ? $query->result() : false;
        
	}
	

}