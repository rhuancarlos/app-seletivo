<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

class Geracoes_m extends CI_Model{

		private $table_geracoes = null;

		function __construct(){
			parent::__construct();
			$this->table_geracoes = "geracoes";
		}

		public function getGeracao($idgeracao = false, $sigla = false) {
			$this->db->select("*");
			$this->db->join($this->table_siglas . ' s', 'g.GERACAO_SIGLA = s.IDSIGLA', "LEFT");
			if($idgeracao) {
					$this->db->where('IDGERACAO', $idgeracao);
			}
			if($sigla) {
					$this->db->where('GERACAO_SIGLA', $sigla);
			}
			$query = $this->db->get($this->table_geracoes.' g');
			//print $this->db->last_query();exit;
			return $query->num_rows() > 0 ? $query->row() : false;
		}

		public function _insertGeracao($dados) {
			if(empty($dados)) {
				return false;
			} else {
				return $this->db->insert($this->table_geracoes, $dados) ? $this->db->insert_id() : false;
			}
		}

		public function getGeracoes($deletado = false) {
			$this->db->select("*,
				concat(GERACAO_LIDER_ID_1, ' - ', (SELECT m1.membr_NOMECOMPLETO FROM {$this->table_membros1} m1 WHERE m1.IDMEMBRO = g.GERACAO_LIDER_ID_1)) LIDER_1,
				concat(GERACAO_LIDER_ID_2, ' - ', (SELECT m1.membr_NOMECOMPLETO FROM {$this->table_membros1} m1 WHERE m1.IDMEMBRO = g.GERACAO_LIDER_ID_2)) LIDER_2
			");
			$this->db->from($this->table_geracoes.' g');
			if($deletado) {
				$this->db->where("DELETADO", true);
			}
			$this->db->or_where("DELETADO", false);
			$this->db->where("USER_DELETED = 0");
			$query = $this->db->get();
			return $query->num_rows() > 0 ? $query->result() : false;
		}

		public function getTotalGeracoes() {
				$query = $this->db->select("COUNT(*) as num")->get($this->table_geracoes);
				$result = $query->row();
				if(isset($result)) return $result->num;
				return 0;
		}

		public function _updateCorGeracao($dados, $id) {
				if(empty($dados)) {
						return false;
				} else {
						$this->db->where("IDGERACAO", $id);
						return $this->db->update($this->table_geracoes, $dados);
				}
		}
		
		public function _updateCorFonteGeracao($dados, $id) {
				if(empty($dados)) {
						return false;
				} else {
						$this->db->where("IDGERACAO", $id);
						return $this->db->update($this->table_geracoes, $dados);
				}
		}

		public function _updateGeracao($dados, $id) {
			if(empty($dados) || empty($id)) {
				return false;
			}
			$this->db->where("IDGERACAO", $id);
			return $this->db->update($this->table_geracoes, $dados);
		}

		public function verificaSeExisteMembroNaGeracao($id_geracao) {
			if(!$id_geracao) {
				return false;
			}
			$this->db->select('COUNT(*) as QTD_MEMBROS_NA_GERACAO');
			$this->db->where("membr_GERACAO", $id_geracao);
			$query = $this->db->get($this->table_membros3);
			//print $this->db->last_query();
			return $query->num_rows() > 0 ? $query->row() : false;
		}

		public function _deleteGeracao($dados, $id) {
			if(empty($dados) || empty($id)) {
				return false;
			}
			$this->db->where("IDGERACAO", $id);
			return $this->db->update($this->table_geracoes, $dados);
		}

		public function verificarSeExiste($dados) {
			if(empty($dados)) {
				return false;
			}else{
				$this->db->where("GERACAO_SIGLA",$dados['geracao_sigla']);
				$query = $this->db->get($this->table_geracoes);
				return $query->num_rows() >= 1 ? true : false;
			}
		}
}