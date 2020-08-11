<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Static_custom {

    /**
     * variavel que armazena a url padrao
     *
     * @var string
     */
    private $base_url = null;

    /**
     * caminho dos arquivos js relativos ao projeto
     *
     * @var string
     */
    private $path_js = 'public/js/';

    /**
     * caminho dos arquivos css relativos ao projeto
     *
     * @var string
     */
    private $path_css = 'public/css/';

    /**
     * caminho dos arquivos css relativos ao projeto
     *
     * @var string
     */
    private $path_libs = 'public/libs/';

    /**
     * saida html do js
     *
     * @var string
     */
    public $output_js = null;

    /**
     * saida html do css
     *
     * @var string
     */
    public $output_css = null;

    /**
    * saida html do css
    *
    * @var string
     */ 
    public $file_css = null;

    /**
    * saida html do css
    *
    * @var string
     */ 
    public $file_js = null;

    /**
    * saida html do css
    *
    * @var string
     */ 
    public $hash_file = null;


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
    public function __construct($params = array()) {
        $this->CI = & get_instance();
        $this->base_url = $this->CI->config->item('base_url');
        $this->hash_file = exec('git rev-parse HEAD');
        $params = $this->setAssetsDefault($params);
        $this->printLibsCss($params["libs_css"]);
        $this->printLibsJs($params["libs_js"]);
        (isset($params["apis_js"])) ? $this->printApisJs($params["apis_js"]) : null;
        $this->printCss($params["css"]);
        $this->printJs($params["js"]);
    }
            

    private function setAssetsDefault($params) {
        
        (!isset($params['css'])) ? $params['css'] = null : false;
        (!isset($params['libs_css'])) ? $params['libs_css'] = null : false;
        (!isset($params['js'])) ? $params['js'] = null : false;
        (!isset($params['libs_js'])) ? $params['libs_js'] = null : false;
        (!isset($params['libs_js'])) ? $params['apis_js'] = null : false;
        
        $paramsDefault['css'] = "zabuto_calendar.min|style-responsive|easyTree|chat|webslidemenu|header|footer|menu|main|{$params['css']}";
        $paramsDefault['libs_css'] = "jquery/css/jquery-ui-1.10.4.custom.min|bootstrap/css/bootstrap.min|font-awesome/css/font-awesome.min|dataTables/css/dataTables.bootstrap.min|{$params['libs_css']}";
        $paramsDefault['js'] = "html5shiv|respond.min|icheck.min|pace.min|holder|responsive-tabs|zabuto_calendar.min|main|chat|webslidemenu|tabelas|filtro_pesquisa|{$params['js']}";
        $paramsDefault['libs_js'] = "jquery/js/jquery-1.10.2|bootstrap/js/bootstrap.min|bootstrap/js/bootstrap-hover-dropdown|jquery/js/jquery.slimscroll|jquery/js/jquery.cookie|jquery/js/jquery.menu|jquery/js/jquery.flot|jquery/js/jquery.flot.spline|jquery/js/jquery.flot.categories|jquery/js/jquery.flot.pie|jquery/js/jquery.flot.tooltip|jquery/js/jquery.flot.resize|jquery/js/jquery.flot.fillbetween|jquery/js/jquery.flot.stack|bootstrap/js/bootstrap-notify|bootstrap/js/bootstrap-treeview|dataTables/js/jquery.dataTables.min|dataTables/js/dataTables.bootstrap.min|{$params['libs_js']}";

        return $paramsDefault;
    }

    /**
     * Função para montar o script de inclusão dos css com os arquivos armazenados na variavel de classe files_css e retorna para o controller
     *
     * 
     *
     *
     * @param   String  Sequencia de strings separadas por |
     * @return  String
     */
    public function printCss($str) {
        $files_css = explode('|', $str);
        foreach ($files_css as $key => $v) {
            if (!empty($v)) {
                $this->output_css .= "<link rel=\"stylesheet\" href=\"{$this->base_url}{$this->path_css}{$v}.css?{$this->hash_file}\" type=\"text/css\">";
            }
        }
        // $this->file_css = $file;
        // return $this->output_css;
    }

    /**
     * Função para montar o script de inclusão dos css com os arquivos armazenados na variavel de classe files_css e retorna para o controller
     *
     * 
     *
     *
     * @param   String  Sequencia de strings separadas por |
     * @return  String
     */
    public function printLibsCss($str) {
      $files_css = explode('|', $str);
      foreach ($files_css as $key => $v) {
        if (!empty($v)) {
          $this->output_css .= "<link rel=\"stylesheet\" href=\"{$this->base_url}{$this->path_libs}{$v}.css?{$this->hash_file}\" type=\"text/css\">";
        }
      }
    }

    /**
     * Função para montar o script de inclusão dos js com os arquivos armazenados na variavel de classe files_js e retorna para o controller
     *
     * 
     *
     *
     * @param   String  Sequencia de strings separadas por |
     * @return  String
     */
    public function printJs($str) {
      $files_js = explode('|', $str);
      foreach ($files_js as $key => $v) {
        if (!empty($v)) {
          $this->output_js .= "<script src=\"{$this->base_url}{$this->path_js}{$v}.js?{$this->hash_file}\"></script>";
        }
      }
    }

    /**
     * Função para montar o script de inclusão dos js com os arquivos armazenados na variavel de classe files_js e retorna para o controller
     *
     * 
     *
     *
     * @param   String  Sequencia de strings separadas por |
     * @return  String
     */
    public function printLibsJs($str) {
        $files_js = explode('|', $str);
        foreach ($files_js as $key => $v) {
          if (!empty($v)) {
            $this->output_js .= "<script src=\"{$this->base_url}{$this->path_libs}{$v}.js?{$this->hash_file}\"></script>";
          }
        }
    }

    /**
     * Função para montar o script de inclusão dos js via requisição http
     *
     * 
     *
     *
     * @param   String  Sequencia de strings separadas por |
     * @return  String
     */
    public function printApisJs($str) {
        $files_js = explode('|', $str);
        foreach ($files_js as $key => $v) {
          if (!empty($v)) {
            $this->output_js .= "<script type=\"text/javascript\" src=\"{$v}\"></script>";
          }
        }
    }
}
