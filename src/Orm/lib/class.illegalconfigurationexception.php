<?php
 /**
 * Contient les diff�rentes classes d'exception
 * @since 1.0
 * @author Bess
 * @package mmmfs
 **/
 
/**
* Classe utilis�e dans le cas ou la configuration des entit�s &co n'est pas correcte
 * @since 1.0
 * @author Bess
 * @package mmmfs
*/
class IllegalConfigurationException extends Exception  {
    
    public function __construct($msg=NULL, $code=0)
    {parent::__construct($msg, $code);}
}

?>