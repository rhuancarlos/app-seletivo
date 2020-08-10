<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

class Materiais_m extends CI_Model {

  private $table_materiais = null;

  function __construct(){
    parent::__construct();
    $this->table_materiais = "materiais m";
    $this->table_materiaisEstoque = "materiais_estoque me";
  }

  public function getAll($arrLimite = false, $search = false) {
		$this->db->select("
			m.idmaterial,
			m.descricao,
			m.status,
			m.created,
			m.user_created,
			m.updated,
			m.user_updated,
			m.detalhamento,
			m.tipo_medida,
			me.idestoquemateriais,
			me.qtd_estoque
		");
		$this->db->from($this->table_materiais);
		$this->db->join($this->table_materiaisEstoque, "me.material_id = m.idmaterial", "LEFT");

		if ($search) {
			$this->db->where("UPPER(m.descricao) LIKE UPPER('%{$search}%')", false, false);
		}

		$this->db->order_by("m.descricao, m.status", "asc");
		if($arrLimite) {
			$this->db->limit($arrLimite['limite'], $arrLimite['index']);
		}

		$query = $this->db->get();
		//print $this->db->last_query();
		return $query->num_rows() > 0 ? $query->result() : false;
	}

  public function getById($id_material) {
		$this->db->select("*");
    $this->db->where('idmaterial', $id_material);
		$query = $this->db->get($this->table_materiais);
    return $query->num_rows() > 0 ? $query->row_array() : false;
  }

  public function getMaterial($id_material) {
		//return $this->db->get_where($this->table_materiais, array('m.idmaterial' => $id_material))->row();
		$this->db->select("
			m.idmaterial,
			m.descricao,
			m.status,
			m.created,
			m.user_created,
			m.updated,
			m.user_updated,
			m.detalhamento,
			m.tipo_medida,
			me.idestoquemateriais,
			me.qtd_estoque
		");
		$this->db->join($this->table_materiaisEstoque, "me.material_id = m.idmaterial", "LEFT");
		$this->db->where('m.idmaterial', $id_material);
    $query = $this->db->get($this->table_materiais);
		return $query->num_rows() > 0 ? $query->row() : false;
	}
	
	public function _insertRegistro($dadosInsert) {
    if(!$dadosInsert) {
      return false;
      exit;
		}
		$this->db->insert('materiais', $dadosInsert);
		$idmaterial = $this->db->insert_id();
		
		if($idmaterial) {
			//INSERT MATERIAL ESTOQUE
			$Cad_ProdutoEstoque['created'] = date('Y-m-d H:i:s');
			$this->_insertRegistroEstoque($Cad_ProdutoEstoque, $idmaterial);
			return $idmaterial;
		} else {
			$this->materiais_m->delete('materiais', array('idmaterial' => $idmaterial));
			return false;
		}
		return false;
  }
	
	private function _insertRegistroEstoque($Cad_ProdutoEstoque, $material_id) {
    if(!$Cad_ProdutoEstoque && (!$material_id)) {
      return false;
      exit;
		}
		
		$Cad_ProdutoEstoque['material_id'] = $material_id;
		$this->db->insert('materiais_estoque', $Cad_ProdutoEstoque);
    $idmaterialControle = $this->db->insert_id();
		return !$idmaterialControle ? false : $idmaterialControle;
  }

  public function _updateRegistro($Cad_ProdutoDados, $Cad_ProdutoEstoque, $material_id) {
		if(!$material_id && (!$Cad_ProdutoDados || !$Cad_ProdutoEstoque)) {
      return false;
      exit;
		}
		$this->db->where("idmaterial", $material_id);
		$this->db->update($this->table_materiais, $Cad_ProdutoDados);
		$updateCadastro = $this->db->affected_rows() > 0 ? true : false;
		
		$updateEstoque = $this->_updateRegistroEstoque($Cad_ProdutoEstoque, $material_id);
    return ($updateCadastro || ($updateEstoque)) ? true : false;
	}

	private function _updateRegistroEstoque($Cad_ProdutoEstoque, $material_id) {
		if(!$material_id && (!$Cad_ProdutoEstoque)) {
      return false;
      exit;
		}
		$this->db->where("material_id", $material_id);
		$this->db->update($this->table_materiaisEstoque, $Cad_ProdutoEstoque);
    return $this->db->affected_rows() > 0 ? true : false;
	}

  public function getAllCount($search = false) {
		$this->db->select("*");
		$this->db->from($this->table_materiais);
		if ($search) {
			$this->db->where("UPPER(m.descricao) LIKE UPPER('%{$search}%')", false, false);
		}
		$query = $this->db->get();
		return $query->num_rows();
  }
	
	public function _updateStatusProva($material_id, $situacao) {
		if(!$material_id && !$situacao) {
			return false;
		}
		$this->db->where("idmaterial", $material_id);
    return $this->db->update($this->table_materiais, $situacao);
	}

}