<?php

if ( ! defined('BASEPATH') ) exit( 'No direct script access allowed' );

class Rsession{
    /**
    * Armazena a instancia do codeigniter dentro da classe
    *
    * @var string
    */
    private $CI;
    
    public function __construct(){
        !isset($_SESSION) ? session_start() : false ;
        
        $this->CI =& get_instance();
    }
    
    private function _set($key , $value = false){
        $keySessao = $key.SIGLA_SESSAO_SISTEMA;
        $_SESSION[$keySessao] = $value;
    }
    
    public function get($key){
        $keySessao = $key.SIGLA_SESSAO_SISTEMA;
        $ret = isset( $_SESSION[$keySessao] ) ? $_SESSION[$keySessao] : false;
        
        return $ret;
    }
    
    public function delete( $key ){
        $keySessao = $key.SIGLA_SESSAO_SISTEMA;
        
        unset( $_SESSION[$keySessao] );
    }

    public function getAllSession(){
        return ($_SESSION);
    }

    public function set( $key , $value = false ){
        
        if(is_array($key)){
            
            $this->setArraySession($key);

        }else{

            if(!empty($value)){
                $this->_set($key, $value);
            }

        }

    }

    public function setArraySession($array){
        foreach ($array as $key => $value) {
            $this->_set($key, $value);
            
        }
        
    }

    public function regenerate_id( $delOld = false ){
        session_regenerate_id( $delOld );
    }

    public function destruir_sessoes(){
        session_destroy();
    }

    public function is_session($key){
        return ($this->get($key)) ? true : false;
     }
}