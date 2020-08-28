<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

class Agendamentos_m extends CI_Model{
	
	function __construct() {
		parent::__construct();
		$this->table_agendamentos = "agendamentos a";
	}

	public function getAgendamento($id_agendamento, $cpf = false, $data = false, $termoValidacao = false) {
		$this->db->select("*");
		$this->db->from($this->table_agendamentos);
		if($id_agendamento) {
			$this->db->where("a.idagendamento", $id_agendamento);
		}
		
		if($cpf){
			$this->db->where("a.cpf like '%$cpf%'");
		}
		
		if($data){
			$this->db->where("a.dia_celebracao like '%$data%'");
		}
		$query = $this->db->get();
		return $query->num_rows() > 0 ? $query->row() : false;
	} 

	public function verificarSeExisteAgendamentoNaData($termoValidacao = false, $data) {
		$this->db->select("*");
		$this->db->from($this->table_agendamentos);		
		if(!empty($termoValidacao)){
			if(isset($termoValidacao['cpf'])) {
				$this->db->where("a.cpf like '%".$termoValidacao['cpf']."%'");
			}
			if(isset($termoValidacao['nome_completo'])) {
				$this->db->where("a.nome_completo like '%".$termoValidacao['nome_completo']."%'");
			}
			if(isset($termoValidacao['email'])) {
				$this->db->where("a.email like '%".$termoValidacao['email']."%'");
			}
		}
		
		if($data){
			$this->db->where("a.dia_celebracao like '%$data%'");
		}
		$query = $this->db->get();
		// print $this->db->last_query();exit;
		return $query->num_rows() > 0 ? $query->row() : false;
	} 	
	
  public function _insertRegistro($dadosInsert) {
    if(!$dadosInsert) {
      return false;
      exit;
		}
    $this->db->insert('agendamentos', $dadosInsert);
    return $this->db->insert_id();
  }

  public function _updateRegistro($dadosUpdate, $codigo_agendamento) {
    if(!$dadosUpdate) {
      return false;
      exit;
		}
		$this->db->where("idagendamento", $codigo_agendamento);
    $update = $this->db->update($this->table_agendamentos, $dadosUpdate);
    return $update || false;
	}
	
  public function getTotalAgendamentos() {
    $query = $this->db->select("COUNT(*) as num")->get($this->table_agendamentos);
    $result = $query->row();
    if(isset($result)) return $result->num;
    return 0;
	}

}