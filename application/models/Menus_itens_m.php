<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

class Menus_itens_m extends CI_Model{
	private $table_menus = null;
	function __construct() {
		parent::__construct();
		$this->table_menu_itens = "menus_itens";
	}

	public function getById($id_menu_filho = false, $id_menu_pai = false) {
    if($id_menu_filho) {
      $this->db->select("mi.*");
      $this->db->from($this->table_menu_itens." mi");
      $this->db->where("mi.id", $id_menu_filho);
      $query = $this->db->get();
      return $query->num_rows() > 0 ? $query->row() : false;
    }
    if($id_menu_pai) {
      $this->db->select("mi.*, gua.permissao_tipo");
      $this->db->from($this->table_menu_itens." mi");
      $this->db->join('grupos_usuarios_acessos gua', 'gua.menu_item_id = mi.id');
      $this->db->where("mi.status", 1);
      $this->db->where("mi.iditem_sub_menu", $id_menu_pai);
      $this->db->group_by("mi.id");
      $query = $this->db->get();
      //print $this->db->last_query();exit;
      return $query->num_rows() > 0 ? $query->result() : false;
    }
    return false;
  }

	public function _saveMenu($dados, $id = false) {
		if($id) {
			$this->db->where('id', $id);
			return $this->db->update($this->table_menu_itens, $dados);
		} else {
			return $this->db->insert($this->table_menu_itens, $dados);
		}
	}
  
}