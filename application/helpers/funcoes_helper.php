<?PHP
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('set_msg')):
    //seta uma mensagem via sesson para ser lida posteriormente
    function set_msg($msg=NULL){
        $ci = & get_instance();
        $ci->rsession->set('aviso', $msg);
    }
endif;

if(!function_exists('get_msg')):
    //retorna uma mensagem definida pela função set_msg
    function get_msg($destroy=TRUE){
        $ci = & get_instance();
        $retorno = $ci->rsession->get('aviso');
        if($destroy) $ci->rsession->delete('aviso');
        return $retorno;
    }
endif;

function getRequestProtocol() {
    if(!empty($_SERVER['HTTP_X_FORWARDED_PROTO']))
        return $_SERVER['HTTP_X_FORWARDED_PROTO'];
    else 
        return !empty($_SERVER['HTTPS']) ? "https" : "http";
}

if(!function_exists('verifica_login')):
    //verifica de o usuario está logado 'logged=TRUE', caso negativa redireciona para pagina de login
    function verifica_login($redirect='login'){
        $ci = & get_instance();
        if($ci->rsession->get('logged') != TRUE):
            set_msg('<p>Ops! <b>Acesso restrito</b>. Faça login para continuar.</p>');
            redirect($redirect, 'refresh');
        endif;
    }
endif;

if(!function_exists('selectedSelect')):
    function selectedSelect($valorInput, $valorBanco){
        if(!isset($valorInput) || !isset($valorBanco)){
            return false;
        }
        $selected = "";
        if(is_array($valorBanco)) {
            foreach($valorBanco as $x) {
                if($x == $valorInput ){
                    $selected = " selected"; 
                }
            }
        } else {
            if($valorBanco == $valorInput ){
                $selected = " selected"; 
            }
        }

        return $selected;
    }
endif;

if(!function_exists('ambiente_aplicacao')):
    function ambiente_aplicacao(){
        $stored_host_server = $_SERVER['HTTP_HOST'];
        if ($stored_host_server == 'localhost' || $stored_host_server == '127.0.0.1'){
            $host = 'localhost';
        }else{
            $host = 'remote';
        }
        return $host;
    }
endif;

if(!function_exists('debug_array')):
    function debug_array($a, $detalhe = false, $ct_pos = false) {
        print "<hr style='margin: 0px 0px 10px; padding: 0px;'>Inicio do print_r <hr>";
        $i = 1;
        if(is_array($a) || is_object($a)) {
            foreach ($a as $key => $value) {
                $posicao = $ct_pos ? $i++ ." -" : null;
                if(is_array($value) || is_object($value)) {
                    foreach ($value as $k => $v) {
                        print "<pre style='padding: 0px !important; margin: 0px !important;'>";
                        print_r("<span style='color: red; font-weight: 800;'>".$posicao."[".$k."] = </span>"); //IMPRIMINDO CHAVE
                        print "<span style='color: blue;'>";
                        print_r($v); //IMPRIMINDO VALOR DA RESPECTIVA CHAVE
                        print "</span></pre>";
                    }
                    print "<br>";
                    #exit;
                } else {
                    print "<pre style='padding: 0px !important; margin: 0px !important;'>";
                    print "<span style='color: red; font-weight: 800;'>".$posicao."[".$key."] = </span>"; //IMPRIMINDO CHAVE
                    print "<span style='color: blue;'>";
                    print_r($value); //IMPRIMINDO VALOR DA RESPECTIVA CHAVE
                    print "</span></pre>";
                    #exit;
                }
            }
            if($detalhe) {
                print "<hr>Inicio do var_dump <hr>";
                var_dump($a);
                print "<hr>Fim do var_dump <hr>";
                exit('Fim do array');
            }
        } else {
            print_r($a);
            if($detalhe) {
                print "<pre>";
                print "<hr>Inicio do var_dump <hr>";
                var_dump($a);
                print "<hr>Fim do var_dump <hr>";
                print "</pre>";
                exit('Fim do array');
            }
        }
        print "<hr style='margin: 0px 0px 10px; padding: 0px;'>Fim do print_r <hr>";
    }
endif;

if(!function_exists('verificaUsoDeEquipe')):
function verificaUsoDeEquipe($id_equipe){
    $ci = & get_instance();
    $ci->load->model(array("equipes_m", "competicao_participantes_m"));
    if(!empty($id_equipe)){
        $return = $ci->db->query("SELECT * FROM competicao_participantes WHERE equipe_id = $id_equipe");
        return $return->num_rows() > 0 ? true : false;
    } else {
        return false;
    }
}
endif;

if(!function_exists('verificaUsoDeProva')):
    function verificaUsoDeProva($id_prova){
        $ci = & get_instance();
        $ci->load->model(array("equipes_m", "competicao_participantes_m"));
        if(!empty($id_prova)){
            $return = $ci->db->query("SELECT * FROM competicao_participantes WHERE equipe_id = $id_prova");
            return $return->num_rows() > 0 ? true : false;
        } else {
            return false;
        }
    }
endif;

if(!function_exists('geraCodigo')):
    function geraCodigoTamanhoPersonalizado($dados, $chave = false, $tamanho){
        if(empty($dados)) {
            return false;
        }
        if($chave && ($tamanho)) {
            $retorno = substr(md5($dados.$chave), 0, $tamanho);
        } else {
            $retorno = substr(md5($dados.date('s:u')), 0, 5);
        }
        return $retorno;
    }
endif;

if(!function_exists('getParametroPorDescricao')):
    function getParametroPorDescricao($descricao_parametro){
        $ci = & get_instance();
        $ci->load->model('parametros_m');
        if(empty($descricao_parametro)) {
            return false;
        }
        $parametro = $ci->parametros_m->getParametroPorDescricao($descricao_parametro);
        if($parametro) {
            return $parametro;
        }
        return false;
    }
endif;