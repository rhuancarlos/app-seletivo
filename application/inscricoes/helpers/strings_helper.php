<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('removePontuacao')):
    function removePontuacao($string, $type){
      if(!$string && $type) {
        return false;
      }
      switch ($type) {
        case 'cpf':
          return str_replace(".", "", str_replace("-", "",$string));
        break;
        
        case 'telefone':
        return str_replace("(", "", str_replace(")", "", str_replace(" ", "", str_replace("-", "",$string))));
        break;

        default:
        return false;
        break;
      }
    }
endif;