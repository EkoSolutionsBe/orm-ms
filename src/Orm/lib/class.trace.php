<?php
/**
 * Contient toute la gestion des informations de d�bugage.
 *
 * @since 1.0
 * @author Bess
 * @package mmmfs
 **/

/**
 *   Permet d'afficher des traces proprement selon certains niveaux         
 *                                                                                     
 *  exemple
 *  <code>
 *          Trace::debug('je passe par ici');
 *          Trace::info('traitement termin�');
 *          Trace::warn('trop peu de r�sultats');
 *          Trace::error('erreur de traitement');
 *  </code>
 * 
 * la propri�t� $level de cette classe d�finit le niveau d'alert � partir duquel les messages s'afficheront. 
 *  Ainsi un niveau �gal � 2 (WARN) n'affichera que les messages de WARNING et de type ERROR
 * 
 * @since 1.0
 * @author Bess
 * @package mmmfs
 **/   
 
final class Trace
{
	public static $DEBUG = 0;
	public static $INFO = 1;
	public static $WARN = 2;
	public static $ERROR = 3;
	
	//Changer cette valeur de 0 � 3 pour niveler les logs
	public static $level = 2;
	
	protected function __construct() {
	}

	/**
    * Affiche un message destin� au d�bugage.
    * 
    * @param string le message
    */
	public static final	function debug($msg)
	{	
		if(self::$level > Trace::$DEBUG) {return;}
		echo "<div class='debug' >$msg</div>";
	}

    /**
    * Affiche un message destin� � informer.
    * 
    * @param string le message
    */
	public static final	function info($msg)
	{	
		if(self::$level > Trace::$INFO) {return;}
		echo "<div class='info' >$msg</div>";
	} 

    /**
    * Affiche un message destin� � attirer l'attention sur un �ventuel soucis.
    * 
    * @param string le message
    */
	public static final	function warn($msg)
	{	
		if(self::$level > Trace::$WARN) {return;}
		echo "<div class='warn' >$msg</div>";
	} 

    /**
    * Affiche un message destin� � signaler une erreur non g�rable par le syst�me
    * 
    * @param string le message
    */
	public static final	function error($msg)
	{	
		echo "<div class='error' >$msg</div>";
	}
}

?>