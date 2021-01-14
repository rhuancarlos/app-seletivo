<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_m extends CI_Model{
	private $table_usuarios = null;
	function __construct() {
		parent::__construct();
		$this->table_usuarios = "usuarios u";
	}

	public function validarUsuario($dadosLogin){
		if(empty($dadosLogin)){
			return false;
		}
		$this->db->select("*");
		$this->db->from($this->table_usuarios);
		$this->db->where("login", $dadosLogin->email);
		$this->db->where("senha", $dadosLogin->senha);
		$query = $this->db->get();
		return $query->num_rows() > 0 ? $query->row() : false;
	}

}