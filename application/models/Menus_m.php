<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

class Menus_m extends CI_Model{
	private $table_menus = null;
	function __construct() {
		parent::__construct();
		$this->table_menus = "menus";
		$this->table_menu_itens = "menus_itens";
		$this->table_grupos_usuarios_acessos = "grupos_usuarios_acessos";
	}

	public function getAll() {
		$this->db->where('status', true);
		$query = $this->db->get($this->table_menus);
		return $query ? $query->result() : false;
	}

	public function getSecao($secao_id) {
		$this->db->where('id', $secao_id);
		$query = $this->db->get($this->table_menus);
		return $query ? $query->row() : false;
	}

	public function getMenu($menu_id) {
		$this->db->where('id', $menu_id);
		$query = $this->db->get($this->table_menu_itens);
		return $query ? $query->row() : false;
	}

	public function getMenuAncora() {
		$this->db->select("*");
		$this->db->from($this->table_menus." m");
		$this->db->where("m.status", 1);
		$this->db->order_by("m.ordem","asc");
		$query = $this->db->get();
		return $query->num_rows() > 0 ? $query->result() : false;
	}
	
	public function getSubMenusGrupoUsuario($id_grupo) { 
		if(!$id_grupo) {
			return false;
		}
		$this->db->select("mi.*");
		$this->db->from($this->table_grupos_usuarios_acessos." gua");
		$this->db->join($this->table_menu_itens." mi", "gua.menu_item_id = mi.id");
		$this->db->where("grupo_usuario_id", $id_grupo);
		$query = $this->db->get();
		return $query->num_rows() > 0 ? $query->result() : array();
	}

	public function getItensSubMenus($id_sub_menu_pai, $grupousuario = true, $submenus = false) {
		$this->db->select("mi.*");
		$this->db->from($this->table_menu_itens." mi");
		if($grupousuario) {
			$this->db->join($this->table_grupos_usuarios_acessos." gua", "mi.id = gua.menu_item_id");
			$this->db->where("gua.grupo_usuario_id", $grupousuario);
		}
		if(!$submenus) {
			$this->db->where("mi.iditem_sub_menu", $id_sub_menu_pai);
		} else {
			$this->db->where("mi.menu_id", $submenus);
			$this->db->where("mi.sub_menu", true); //adicionei durante a tecla de listagem
		}
		$this->db->order_by("mi.ordem","asc");
		$query = $this->db->get();
		// print $this->db->last_query();exit;
		return $query->num_rows() > 0 ? $query->result() : array();
	}

	public function getTabelasMenus($submenus = false) {
		$this->db->select("*");
		$this->db->from("menus_itens");
		if($submenus) {
			$this->db->where('sub_menu', 1);
		}
		$retorno = $this->db->get();
		return $retorno->num_rows() > 0 ? $retorno->result() : false;
	}

	public function _saveMenu($dados, $id = false) {
		if($id) {
			// debug_array($i);
			$this->db->where('id', $id);
			return $this->db->update($this->table_menus, $dados);
		} else {
			return $this->db->insert($this->table_menus, $dados);
		}
	}
}