<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	/**
	 * Aramazena os valores para enviar para a view
	 *
	 * @var Array
	 */
	protected $data;

	/**
	 * Armazenas os parametros do construtor na classe
	 *
	 * @var Array
	 */
	private $params;

	/**
	 * Armazenas uma instanciad a classe Static_custom
	 *
	 * @var Array
	 */
	private $v_static_custom;

	/**
	 * Armazenas o tipo do usuário na sessão
	 *
	 * @var Array
	 */
	public $sigla;

	/**
	 * Caso esteja populada irá sobreescrever o valor da url
	 * que atualmente eh baseada no nome_da_classe/nome_do_metodo
	 * Utilizado em casos euq o mesmo methodo possui duas views
	 */
	protected $overwriteUrlView = false;

	/**
	 * Class constructor
	 *
	 * 
	 *
	 * @uses    CI_Lang::$is_loaded
	 *
	 * @param   array   $config Calendar options
	 * @return  void
	 */
	public function __construct() {
		parent::__construct();
	}

	public function loadAssets($params) {
		$this->load->library("static_custom", $params);
		$this->params = $params;
		$this->v_static_custom = $this->static_custom;
	}

	public function loadView($data_view = false, $header = 'layouts/header', $footer = 'layouts/footer') {
		$this->loadAssets($this->data);
		$this->loadData($data_view);
		$this->loadStatics();
		$this->data["session"] = $this->rsession->getAllSession();
		if (isset($this->stringController)) {
			if ($this->stringController != 'login') {
				$this->carregaDadosPadroes();
			}
		}
		
		$this->loadLayouts($this->data, $header, $footer);
	}

	private function loadUrlView() {
		$class = $this->router->class;
		$method = $this->router->method;
		$url = ($this->overwriteUrlView && $this->overwriteUrlView != '') ? $this->overwriteUrlView : "{$class}/{$method}";
		if (isset($this->stringController)) {
			if ($this->stringController != 'login') {
				$aqui = 'aqui232';
			}
		}
		$this->overwriteUrlView = false;
		return $url;
	}

	private function loadLayouts($data, $header, $footer) {
		(isset($header) && $header) ? $this->load->view($header, $this->data) : null;
		$this->load->view($this->loadUrlView(), $this->data);
		(isset($footer) && $footer) ? $this->load->view($footer) : null;
	}

	private function loadData($data = false) {
		if ($data) {
			foreach ($data as $key => $d) {
				$this->data[$key] = $d;
			}
		}
	}

	protected function setData($data) {
		$this->data = $data;
	}

	private function verificaMensagensStatus() {

		if ($this->rsession->is_session("sucesso")) {
			$this->data["sucesso"] = $this->rsession->get("sucesso");
			$this->rsession->delete("sucesso");
		}

		if ($this->rsession->is_session("erro")) {
			$this->data["erro"] = $this->rsession->get("erro");
			$this->rsession->delete("erro");
		}
	}

	private function loadStatics() {
		$this->data["css"] = $this->static_custom->output_css;
		$this->data["js"] = $this->static_custom->output_js;
	}

	public function getMensagemInsert($status) {
		return ($status) ? "Registro inserido com sucesso" : "Houve um problema ao inserir os dados";
	}

	public function getMensagemUpdate($status) {
		return ($status) ? "Registro atualizado com sucesso" : "Houve um problema ao atualizar os dados";
	}

	public function setMensagemStatus($mensagem, $status = true) {

		if ($status) {
			$this->rsession->set("sucesso", $mensagem);
		} else {
			$this->rsession->set("erro", $mensagem);
		}
	}

	protected function setSAsets($css = "", $libs_css = "", $js = "", $libs_js = "", $apis_js = "") {
		$this->data = array('css' => $css, 'libs_css' => $libs_css, 'js' => $js, 'libs_js' => $libs_js, 'apis_js' => $apis_js);
	}

 	public function carregaDadosPadroes() {
		$this->data["favoritos"] = 'PADOS PADRÕES';
    }
}
