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
<<<<<<< HEAD
        $this->hash_file = HASH_ASSETS;
=======
        $this->hash_file = exec('git rev-parse HEAD');
>>>>>>> 90030ae7fcd79c7ab3402bf2b139b2a2614b36b3
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
        
<<<<<<< HEAD
        $paramsDefault['css'] = "{$params['css']}";
        $paramsDefault['libs_css'] = "bootstrap/css/bootstrap.min|bootstrap-daterangepicker/daterangepicker|select2/css/select2|auto-complete/css/autocomplete|perfect-scrollbar/css/perfect-scrollbar.min|dropzone/css/dropzone|bootstrap-datepicker/css/bootstrap-datepicker.min|datatables.net-bs/css/dataTables.bootstrap.min|slick-carousel/css/slick|fonts/icon_fonts_assets/font-awesome/css/font-awesome.min|fonts/icon_fonts_assets/feather/style|sweetalert/css/sweetalert2|hover_effects/hover|{$params['libs_css']}";
        $paramsDefault['js'] = "funcoes_gerais|mascaras|dataTables.bootstrap4.min|{$params['js']}";
        $paramsDefault['libs_js'] = "jquery/js/jquery.min|jquery.mask/jquery.mask|popper.js/umd/popper.min|bootstrap/js/bootstrap.min|bootstrap/js/util|auto-complete/js/autocomplete|bootstrap/js/alert|bootstrap-auto-dismiss-alert/bootstrap-auto-dismiss-alert|select2/js/select2.full|select2/js/i18n/pt-BR|ckeditor/ckeditor|datatables.net/js/jquery.dataTables|datatables.net-buttons/js/dataTables.buttons.min|bootstrap-validator/js/validator.min|bootstrap-datepicker/js/bootstrap-datepicker.min|bootstrap-datepicker/locales/bootstrap-datepicker.pt-BR.min|dropzone/js/dropzone|slick-carousel/js/slick.min|perfect-scrollbar/js/perfect-scrollbar.jquery.min|bootstrap/js/util|bootstrap/js/alert|bootstrap/js/button|bootstrap/js/carousel|bootstrap/js/collapse|bootstrap/js/dropdown|bootstrap/js/modal|bootstrap/js/tab|bootstrap/js/tooltip|moment/moment|bootstrap-daterangepicker/daterangepicker|fullcalendar/js/fullcalendar|fullcalendar/js/locale-all|sweetalert/js/sweetalert2.min|angularjs/angular.min|{$params['libs_js']}";

        #return str_replace(' ','',$paramsDefault);
=======
        $paramsDefault['css'] = "bootstrap.min|fonts/line-icons|slicknav|nivo-lightbox|animate|main|responsive|{$params['css']}";
        $paramsDefault['libs_css'] = "{$params['libs_css']}";
        $paramsDefault['js'] = "jquery-min|popper.min|bootstrap.min|jquery.countdown.min|jquery.nav|jquery.easing.min|wow|jquery.slicknav|nivo-lightbox|main|form-validator.min|contact-form-script.min|map|{$params['js']}";
        $paramsDefault['libs_js'] = "{$params['libs_js']}";

>>>>>>> 90030ae7fcd79c7ab3402bf2b139b2a2614b36b3
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
<<<<<<< HEAD
              $this->output_css .= "  <link rel=\"stylesheet\" href=\"{$this->base_url}{$this->path_css}{$v}.css?{$this->hash_file}\" type=\"text/css\">\n";
=======
                $this->output_css .= "<link rel=\"stylesheet\" href=\"{$this->base_url}{$this->path_css}{$v}.css?{$this->hash_file}\" type=\"text/css\">";
>>>>>>> 90030ae7fcd79c7ab3402bf2b139b2a2614b36b3
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
<<<<<<< HEAD
          $this->output_css .= "  <link rel=\"stylesheet\" href=\"{$this->base_url}{$this->path_libs}{$v}.css?{$this->hash_file}\" type=\"text/css\">\n";
=======
          $this->output_css .= "<link rel=\"stylesheet\" href=\"{$this->base_url}{$this->path_libs}{$v}.css?{$this->hash_file}\" type=\"text/css\">";
>>>>>>> 90030ae7fcd79c7ab3402bf2b139b2a2614b36b3
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
<<<<<<< HEAD
          $this->output_js .= "  <script src=\"{$this->base_url}{$this->path_js}{$v}.js?{$this->hash_file}\"></script>\n";
=======
          $this->output_js .= "<script src=\"{$this->base_url}{$this->path_js}{$v}.js?{$this->hash_file}\"></script>";
>>>>>>> 90030ae7fcd79c7ab3402bf2b139b2a2614b36b3
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
<<<<<<< HEAD
            $this->output_js .= "  <script src=\"{$this->base_url}{$this->path_libs}{$v}.js?{$this->hash_file}\"></script>\n";
=======
            $this->output_js .= "<script src=\"{$this->base_url}{$this->path_libs}{$v}.js?{$this->hash_file}\"></script>";
>>>>>>> 90030ae7fcd79c7ab3402bf2b139b2a2614b36b3
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
<<<<<<< HEAD
            $this->output_js .= "  <script type=\"text/javascript\" src=\"{$v}\"></script>\n";
=======
            $this->output_js .= "<script type=\"text/javascript\" src=\"{$v}\"></script>";
>>>>>>> 90030ae7fcd79c7ab3402bf2b139b2a2614b36b3
          }
        }
    }
}
