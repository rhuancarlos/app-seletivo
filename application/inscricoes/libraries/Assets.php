<?php
class Assets {
	public $css;
	public $js;
	private $config;
	
	public function __construct($config){
		$this->CI =& get_instance();
		$this->config = $config;
		$this->loadAssets();
	}
	
	public function loadAssets(){
		$this->CI->load->library("static_custom", $this->config);  
		$this->header = $this->config['header'];
		$this->css = $this->CI->static_custom->output_css;
		$this->js = $this->CI->static_custom->output_js;   
	}
}
