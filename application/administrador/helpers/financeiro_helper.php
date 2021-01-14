<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('formataValorDB')):
  function formataValorDB($valor) {
    return str_replace(',','.', str_replace('.','', $valor));
  }
endif;

if(!function_exists('formataValorExibicao')):
  function formataValorExibicao($valor) {
    return money_format('%n',$valor);
  }
endif;