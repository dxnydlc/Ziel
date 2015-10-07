<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of newPHPClass
 *
 * @author programador
 */
class newPHPClass {
    //put your code here
    /*public function __construct() {
	parent::__construct();
        ;
    }*/
	
	function set_Valor( $valor , $campo ){
        $this->campos[$campo] = MySQL::SQLValue( $valor , MySQL::SQLVALUE_TEXT);
    }

    function set_Union( $valor , $campo ){
        $this->union[$campo] = MySQL::SQLValue( $valor , MySQL::SQLVALUE_NUMBER );
    }
}

?>