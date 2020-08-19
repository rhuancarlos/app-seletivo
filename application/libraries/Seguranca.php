<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seguranca {


	/**
	 * Valor padrão para ser concatenado com a senha e gerar a criptografia
	 *
	 * @var string
	 */
	private $salt_senha = "102d10d54sdsdhf4f5f54f50f5s4f4505f";

    /**
     * Cadeia de caracteres que será usada pra gerar uma senha aleatoria
     *
     * @var string
     */
    private $caracteres_senha_aleatoria = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';

	/**
	 * Chave padrão para criptografia reversa
	 *
	 * @var string
	 */
	private $chave_cr = 97;

	/**
	 * Chave padrão para ser concatenada na criptografia reversa
	 *
	 * @var string
	 */
	private $caracteres_cript_reversa = null;

	/**
	 * Class constructor
	 *
	 * 
	 *
	 * @uses	CI_Lang::$is_loaded
	 *
	 * @param	array	$config	Calendar options
	 * @return	void
	 */
	public function __construct($params = array()){
        
        $this->CI =& get_instance();

        $this->caracteres_cript_reversa = md5(sha1("GrcZlOUnd0Y6tKOAlc8I69IFX6k_p1S3PAqoJCom3AKnThz_t3r0Cc5VxxjcXc-s9kB9JfCyCw3EPZ0XkcylXwCL9jfJOfeQ1"));
        
    }	

    public function geraSenha($senha, $login=NULL){
	    
        //$gera_pass = md5(sha1($this->salt_senha.$senha.$login));
        if(empty($login)) {
            $salt = '102d10d54sdsdhf4f5f54f50f5s4f4505f';
<<<<<<< HEAD
            $gera_pass = sha1($this->salt_senha.$senha.'AcreditoConfieLuteNãoDesista.ETudoDaráCerto');
=======
            $gera_pass = sha1($this->salt_senha.$senha.'Gênesis');
>>>>>>> 90030ae7fcd79c7ab3402bf2b139b2a2614b36b3
        } else {
            $salt = "0c8a1ca3e1316de28f8af408a684284c";
            $gera_pass = md5($login.$salt.$senha);
        }
        return $gera_pass;
	}

	public function geraSenhaAleatoria($tamanho = 8){

	    $retorno = '';
	    
	    $len = strlen($this->caracteres_senha_aleatoria);
	    
	    for ($n = 1; $n <= $tamanho; $n++) {
	     
	        $rand = mt_rand(1, $len);
	     
	        $retorno .= $this->caracteres_senha_aleatoria[$rand-1];
	    }

	    return $retorno;
	} 

    public function enc($word){

        $word .= $this->caracteres_cript_reversa;
        $s = strlen($word)+1;
        $nw = "";
        $n = $this->chave_cr;
        for ($x = 1; $x < $s; $x++){
            $m = $x*$n;
            if ($m > $s){
                $nindex = $m % $s;
            }
            else if ($m < $s){
                $nindex = $m;
            }
            if ($m % $s == 0){
                $nindex = $x;
            }
            $nw = $nw.$word[$nindex-1];
        }
        return $nw;
    }

    /**
     * @param string Palavra
     * @return string
     */
    public function dec($word){

        $s = strlen($word)+1;
        $nw = "";
        $n = $this->chave_cr;
        for ($y = 1; $y < $s; $y++){
            $m = $y*$n;
            if ($m % $s == 1){
                $n = $y;
                break;
            }
        }
        for ($x = 1; $x < $s; $x++){
            $m = $x*$n;
            if ($m > $s){
                $nindex = $m % $s;
            }
            else if ($m < $s){
                $nindex = $m;
            }
            if ($m % $s == 0){
                $nindex = $x;
            }
            $nw = $nw.$word[$nindex-1];
        }
        $t = strlen($nw) - strlen($this->caracteres_cript_reversa);
        return substr($nw, 0, $t);
    }

    public function get_senha_smad(){

        $dia = date('d');
        
        $mes = date('m');

        $ano = date('y');

        $soma_dia = substr($dia, 0,1) + substr($dia, 1,1);

        $soma_mes = substr($mes, 0,1) + substr($mes, 1,1);

        $soma_ano = substr($ano, 0,1) + substr($ano, 1,1);

        return $dia.$mes.$ano.($soma_dia+$soma_mes+$soma_ano);


    }

}