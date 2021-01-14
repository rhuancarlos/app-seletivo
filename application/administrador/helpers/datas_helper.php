<?php

if (!function_exists('formataParaData')) {
    function formataParaData($dataParam, $divisorEntrada = "-", $divisorSaida = "/", $retornarHora = true, $dataAbreviada = false) {

        $data = substr($dataParam, 0, 10);        
        $hora = ($retornarHora) ? substr($dataParam, 10) : "";        
        
        if($dataAbreviada) {
            $ano = substr("$data", 0, 4);
            $mes = substr("$data", 5, -3);
            $dia = substr("$data", 8, 9);
            $meses_abreviacao = array(01 => "Jan", 02 => "Fev", 03 => "Mar", 04 => "Abr", 05 => "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez");
            foreach($meses_abreviacao as $key => $m){
                if($key == $mes) {
                    if($retornarHora) {
                        $data = $dia.$divisorSaida.$m.$divisorSaida.$ano.' '.$hora;
                    } else {
                        $data = $dia.$divisorSaida.$m.$divisorSaida.$ano;
                    }
                }
            }
            return $data;
        }
        $itensData = array_reverse(explode($divisorEntrada, $data));
        
        return implode($divisorSaida, $itensData) . $hora;
    }
}

function dataBrasileiraCompleta() {
    // Gerando o array com nome dos dias da semana
    $diaSemana = array("Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado");
    // Gerando array com o nome dos meses
    $mes = array(1 => "janeiro", "fevereiro", "março", "abril", "maio", "junho", "julho", "agosto", "setembro", "outubro", "novembro", "dezembro");
    // Retorno da funão
    return $diaSemana[gmdate("w")] . ", " . gmdate("d") . " de " . $mes[gmdate("n")] . " de " . gmdate("Y");
}

function dataBanco(){
    return date('Y-m-d');
}

function dataBrasileira() {
    // Gerando array com o nome dos meses
    $mes = array(1 => "janeiro", "fevereiro", "março", "abril", "maio", "junho", "julho", "agosto", "setembro", "outubro", "novembro", "dezembro");
    // Retorno da funão
    return gmdate("d") . " de " . $mes[gmdate("n")] . " de " . gmdate("Y");
}

function formataParaDataBrasileira($data) {
    $dataA = explode("/", $data);
    $dia = $dataA[0];
    $mes = (int) $dataA[1];
    $ano = $dataA[2];

    // Gerando array com o nome dos meses
    $meses = array(1 => "janeiro", "fevereiro", "março", "abril", "maio", "junho", "julho", "agosto", "setembro", "outubro", "novembro", "dezembro");
    // Retorno da funão
    return $dia . " de " . $meses[$mes] . " de " . $ano;
}

function dataAtual() {
    return date("d/m/y - H:i:s");
}

function retornaDiaSemana($data) {
    $ano = substr("$data", 0, 4);
    $mes = substr("$data", 5, -3);
    $dia = substr("$data", 8, 9);

    $diasemana = date("w", mktime(0, 0, 0, $mes, $dia, $ano));

    switch ($diasemana) {
        case"0": $diasemana = "Domingo";
            break;
        case"1": $diasemana = "Segunda-Feira";
            break;
        case"2": $diasemana = "Terça-Feira";
            break;
        case"3": $diasemana = "Quarta-Feira";
            break;
        case"4": $diasemana = "Quinta-Feira";
            break;
        case"5": $diasemana = "Sexta-Feira";
            break;
        case"6": $diasemana = "Sábado";
            break;
    }

    return "$diasemana";
    //Exemplo de uso
    //diasemana("2007-07-13");
}

function retornaMes($data) {
    $ano = substr("$data", 0, 4);
    $mes = substr("$data", 5, -3);
    $dia = substr("$data", 8, 9);

    $diasemana = date("w", mktime(0, 0, 0, $mes, $dia, $ano));

    $meses = array(
        '01' => "Janeiro", 
        '02' => "Fevereiro", 
        '03' => "Março", 
        '04' => "Abril", 
        '05' => "Maio", 
        '06' => "Junho", 
        '07' => "Julho", 
        '08' => "Agosto", 
        '09' => "Setembro", 
        '10' => "Outubro", 
        '11' => "Novembro", 
        '12' => "Dezembro");

    return $meses[$mes];
    //Exemplo de uso
    //retornaMes("2007-07-13");
}

function retornaAno($data) {
    $ano = substr("$data", 0, 4);
    return $ano;
}

function diasDiferencaDatas($inicio, $fim = false, $mensagem = false) {

    if (!$fim) {

        $fim = date("Y-m-d H:i:s");
    }

    $time_inicial = strtotime($inicio);

    $time_final = strtotime($fim);

    $diferenca = $time_final - $time_inicial;

    $dias = (int) floor($diferenca / (60 * 60 * 24));

    switch ($dias) {

        case 0:
            $dias = "Hoje";
            break;

        case 1:
            $dias = "Ontem";
            break;
    }

    if ($dias > 1) {

        if ($mensagem) {

            $dias .= " dias atrás";
        }
    }

    if ($dias > 30) {

        if ($mensagem) {

            $dias = (int) ($dias / 30) . " semana(s) atrás";
        }
    }

    return $dias;
}

function diasDiferencaDatas2($inicio, $fim = false, $mensagem = false) {

    if (!$fim) {

        $fim = date("Y-m-d H:i:s");
    }

    $time_inicial = strtotime($inicio);

    $time_final = strtotime($fim);

    $diferenca = $time_final - $time_inicial;

    $dias = (int) floor($diferenca / (60 * 60 * 24));

    return $dias;
}

function CalcularIdade($data){
   
    // Separa em dia, mês e ano
    list($ano, $mes, $dia) = explode('-', $data);
   
    // Descobre que dia é hoje e retorna a unix timestamp
    $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
    // Descobre a unix timestamp da data de nascimento do fulano
    $nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);
   
    // Depois apenas fazemos o cálculo já citado :)
    $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
    return $idade;
}

function incrementa_dia($data, $qtd = 1){
    return date('Y-m-d H:i:s', strtotime("+$qtd days",strtotime($data)));
}

function decrementa_dia($data, $qtd = 1){
    return date('Y-m-d H:i:s', strtotime("-$qtd days",strtotime($data)));
}

function dataHoraDefault() {
	return date("d/m/y - H:i:s");
}

function formate_date($date) {
    /**
     * @return : aaaa-mm-dd
     */
	return $date[6] . $date[7] . $date[8] . $date[9] . "-" . $date[3] . $date[4] . "-" . $date[0] . $date[1];
}

function formate_date2($date) {
	return $date[6] . $date[7] . $date[8] . $date[9] . $date[3] . $date[4] . $date[0] . $date[1];
}