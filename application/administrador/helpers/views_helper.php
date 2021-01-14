<?php

function returnInstancia() {
    $CI = & get_instance();
    return $CI;
}

function data_brasileira($str, $hora = false){
	$data = implode("/",array_reverse(explode("-",substr($str,0,10))));

	if($hora){
		$data .= " ".substr($str,11,8);
	}

	return $data;
}

	
function formata_moeda($valor, $sifrao = false) {
    $valor = str_replace(",", "", $valor);
    $valor = number_format((float)$valor, 2, ',', '.');
    return ($sifrao) ? "R$ {$valor}" : $valor;
}

function verifica_selecionado($chave, $opcao){
	return ($chave == $opcao) ? "selected='selected'" : null ;
}


function verifica_situacao_pagametno_view($situacao_id){
	$autorizados = array(3, 4, 8, 14, 18);
	$a_pagar = array(1, 2, 11);
	$guardando = array(2, 9, 10, 12, 13);
	$cancelado = array(5, 6, 7, 15, 16, 17);
	$retorno = null;
	switch ($situacao_id) {
		case in_array($situacao_id, $autorizados):
			$retorno = 'autorizado';
			break;

		case in_array($situacao_id, $a_pagar):
			$retorno = 'a_pagar';
			break;
		
		case in_array($situacao_id, $guardando):
			$retorno = 'aguardando';
			break;

		case in_array($situacao_id, $cancelado):
			$retorno = 'cancelado';
			break;
	}
	return $retorno;
}

function cripto($str, $op){

	$CI =& get_instance();

	if($op == 'enc'){
		
		return $CI->seguranca->enc($str);

	}else if($op == 'dec'){

		return $CI->seguranca->dec($str);

	}else{

		return false;

	}
	
}

function calcula_desconto($v, $d){

	$ret['desconto'] = (($v / 100) * $d);

	$ret['valor_com_desconto'] = ($v - $ret['desconto']);

	return $ret;
}

function data_atual(){

	return date('Y-m-d H:i:s');

}

function dias_diferenca_datas($inicio, $fim = false, $mensagem = false) {

	if(!$fim){
		
		$fim = date("Y-m-d H:i:s");

	}

	$time_inicial = strtotime($inicio);
	
	$time_final = strtotime($fim);

	$diferenca = $time_final - $time_inicial;

	$dias = (int)floor( $diferenca / (60 * 60 * 24));

	return $dias;

}

function converteSegundos($tempo){
    if($tempo != ""){
        $array = explode(":", $tempo); 
        $hor = $array[0]; 
        $min = $array[1]; 
        $seg = $array[2];

        $horas_em_segundos = $hor * 3600; //transforma as horas em segundos 
        $minutos_em_segundos = $min * 60; //transforma os minutos em segundos 

        $tempo_em_segundos = ($horas_em_segundos + $minutos_em_segundos) + $seg; //soma todos os segundos 

        return $tempo_em_segundos;
    }
}


function converteHoras($segundos){
    $horas = 0;
    
    $horas = floor($segundos / 3600); 
    $segundos -= $horas * 3600; 
    $minutos = floor($segundos / 60); 
    $segundos -= $minutos * 60; 

    if ($horas < 10) $horas = "0".$horas; 
    if ($minutos < 10) $minutos = "0".$minutos; 
    if ($segundos < 10) $segundos = "0".$segundos; 


    return $horas.":".$minutos.":".$segundos; 

}

function verificaLogado(){
	$CI =& get_instance();
	$logado = $CI->seguranca->dec($CI->rsession->get('logado'));
	return $logado;
}

function is_data($arr, $str, $dec = false) {
	$CI =& get_instance();
	$str_retorno = false;
	if(isset($arr)){
		$arr = (array) $arr;
		if(isset($arr[$str])){
			if($dec){
				$str_retorno = $CI->seguranca->dec($arr[$str]);
			}else{
				$str_retorno = $arr[$str];
			}
		}
	}
	return $str_retorno;
}

function verifica_checkbox($valor, $id) {
	if ($valor == $id) {
		return "checked='checked'";
	} else {
		return false;
	}

}

/*
 * verifica se o registro informado isset ou não
 */
function isData($arr, $param) {
    if (is_object($arr)) {
        return (isset($arr->$param)) ? $arr->$param : null;
    } else if (is_array($arr)) {
        return (isset($arr[$param])) ? $arr[$param] : null;
    } else if (is_string($arr)) {
        return $arr;
    } else {
        return null;
    }
}

function prepareArraySelect($dados = array()) {

    $array_select[""] = "Selecione uma opção";

    $key = $dados['key'];

    $value = $dados['value'];

    foreach ($dados["array"] as $d) {

        $array_select[$d->$key] = $d->$value;
    }
    return $array_select;
}

function selectStatus($campo, $id = false) {
    $CI = returnInstancia();
    $objTrue = new stdClass();
    $objTrue->key = 1;
    $objTrue->value = 'Ativo';
    $objFalse = new stdClass();
    $objFalse->key = 0;
    $objFalse->value = 'Inativo';
    $id = (!$id && $id != '0') ? 1 : $id;
    $dados_consulta[] = $objTrue;
    $dados_consulta[] = $objFalse;

    $dados = prepareArraySelect(array("array" => $dados_consulta, "key" => "key", "value" => "value"));
    return form_dropdown($campo, $dados, $id, array('id' => "{$campo}", 'class' => "form-control border-input"));
}

function geraChave($id) {
    $CI = returnInstancia();
    $CI->load->model('chaves_m');
    $id = ltrim(rtrim($id));
    $div = str_split($id);//retorna a string em um array
    $cont=0;
    $chave ="";
    foreach($div as $valor) {
        $cont++;
        $rsGeraChave = $CI->chaves_m->getWhere(array('numero' => $valor));
        if (empty($rsGeraChave[0]->chave)){
            $NaoExiste="";
            while (empty($NaoExiste)) {
                $chave1 ="";
                $chave1 = gerarandonstring(20);
                $chave1 = trim(str_replace('i','j',$chave1));
                // $rsGeraChave = $DB->Execute("select ltrim(rtrim(chave)) as chave from chaves where chave='".$chave1."'");
                $rsGeraChave = $CI->chaves_m->getWhere(array('chave' => $chave1));
                if (empty($rsGeraChave[0]->chave)) $NaoExiste = 1;
            }
            $sql= 'select  case when max(id) is null then 1 else  max(id)+1 end as id from chaves';
            $resulta = $CI->chaves_m->pegaMaxIdchave();
            $id = $resulta[0]->id;
            $insert_chave = array('id' => $id, 'numero' => $valor, 'chave' => $chave1, 'qtd' => '20');
            $CI->chaves_m->insert($insert_chave);
            $c = ltrim(rtrim($chave1));
        } else {
            $c = ltrim(rtrim($rsGeraChave[0]->chave));
        }
        if($cont==1)$chave.=$c;
        else $chave.="i".$c;
    }
    return $chave;
}

function gerarandonstring($n){
    $str = "ABCDEFGHIJLMNOPQRSTUVXZYWKabcdefghjlmnopqrstuvxzywk0123456789_-";
    $cod = "";
    for($a = 0;$a < $n;$a++){
        $rand = rand(0,63);
        $cod .= substr($str,$rand,1);}
    return $cod;
}