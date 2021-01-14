<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('getInfoServerAmbience')):
    function getInfoServerAmbience($type_info_server_ambience = false) {
      if(!$type_info_server_ambience){
        return 'Time Execution Script: '.$_SERVER['REQUEST_TIME'];
      }
      return $_SERVER[$type_info_server_ambience];
      exit;
    }
endif;

if(!function_exists('getNomeMethod')):
  function getNome_Method(){
    $ci =& get_instance();
    return $ci->router->fetch_method();
  }
endif;

if(!function_exists('getNome_Controller')):
  function getNome_Controller(){
    $ci =& get_instance();
    echo $ci->router->fetch_class();
  }
endif;