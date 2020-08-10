<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

class Competicao_participantes_m extends CI_Model {

  private $table_competicao_participantes = null;

  function __construct(){
    parent::__construct();
    $this->table_competicao_participantes = "competicao_participantes";
  }

  public function getById($id_participante, $id_equipe) {
    return false;
  }

  public function getTotalParticipantesEquipes($id_equipe) {
    if(!$id_equipe) {
      return false;
    }
    $this->db->select("count(*) as total_participantes");
    $this->db->from($this->table_competicao_participantes."` cp`");
    $this->db->where("cp.equipe_id", $id_equipe);
    $query = $this->db->get();
    return $query->num_rows() > 0 ? $query->row() : false;
  }

  public function _insertRegistro($dadosInsert) {
    if(!$dadosInsert) {
      return false;
      exit;
    }
    $sql = $this->db->query("SELECT * FROM participantes WHERE idparticipante = {$dadosInsert['participante_id']}");
    if($sql->num_rows() == 0 ){
      return false;
    } else {
      $this->db->insert($this->table_competicao_participantes, $dadosInsert);
      return true;
    }
  }

  public function _updateRegistro($dadosUpdate, $codigo_participante) {
    if(!$dadosUpdate) {
      return false;
      exit;
		}
		$this->db->where("participante_id", $codigo_participante);
    $update = $this->db->update($this->table_competicao_participantes, $dadosUpdate);
    return $update || false;
	}

  public function _registraEquipeParticipante ($dadosEquipe, $id_participante) {
    if(!$dadosEquipe || !$id_participante){
      return false;
    }

    $sql = $this->db->query("SELECT * FROM competicao_participantes WHERE participante_id= {$id_participante}");
    /**
     * Abaixo será verificado se o participante está em alguma equipe. Se estiver, faz apenas o update deste na equipe que está sendo passada na requisição, caso contrário será feito apenas um insert dele na tabela
    */
    if($sql->num_rows() > 0) {
      $this->db->where("participante_id", $id_participante);
      $this->db->update($this->table_competicao_participantes, $dadosEquipe);
      return true;
    } else {
      $this->db->insert($this->table_competicao_participantes, $dadosEquipe);
      return true;
    }
  }
}