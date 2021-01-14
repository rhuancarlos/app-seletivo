<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('getParametros')):
    function getParametros($id_parametro = false, $secao = false, $descricao_parametro = false){
        $ci = & get_instance();
        $ci->load->model('parametros_m');
        $parametro = $ci->parametros_m->getParametros($id_parametro, $secao, $descricao_parametro);
        if($parametro) {
            return $parametro;
        }
        return false;
    }
endif;

if(!function_exists('getParametroPorDescricao')):
    function getParametroPorDescricao($descricao_parametro, $secao = false){
        $ci = & get_instance();
        $ci->load->model('parametros_m');
        if(empty($descricao_parametro)) {
            return false;
        }
        $parametro = $ci->parametros_m->getParametroPorDescricao($descricao_parametro, $secao);
        if($parametro) {
            return $parametro;
        }
        return false;
    }
endif;


if(!function_exists('getTipoInscricao')):
    function getTipoInscricao($id_tipo_inscricao = false, $sigla = false){
        $ci = & get_instance();
        $ci->load->model('tipos_inscricao_m');
        if(empty($sigla && $sigla)) {
            return false;
        }
        $parametro = $ci->tipos_inscricao_m->getTipoInscricao($id_tipo_inscricao = false, $sigla = false);
        if($parametro) {
            return $parametro;
        }
        return false;
    }
endif;
