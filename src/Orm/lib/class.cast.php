<?php
/**
 * Contient la classe qui g�re les diff�rents type de Typage en base de don�e
 * 
 * @package mmmfs
 **/


/**
 * Classe d�finissant les typage des champs
 * 
 *  CAST::$STRING une chaine de caract�re 
 *  CAST::$INTEGER un entier
 *  CAST::$DATE une date 
 *  CAST::$TIME une zone time
 *  CAST::$TS un timestamp
 *  CAST::$BUFFER une zone de texte non limit� en taille
 *  CAST::$NUMERIC un nombre r��l (virgule)
 *  CAST::$NONE ne pas stocker en base (dans le cas d'une cl�e associative)    
 * 
 * @since 1.0
 * @author Bess
 * @package mmmfs
*/
class CAST
{
	public static $STRING = 0;
	public static $INTEGER = 1;
	public static $DATE = 2;
	public static $BUFFER = 3;
	public static $NUMERIC = 4;
	public static $TIME = 5;
	public static $TS = 6;
	public static $NONE = 9;
}

?>