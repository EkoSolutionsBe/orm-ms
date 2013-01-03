<?php
/**
 * Contient la classe qui d�finit les diff�rentes cl� g�r�e
 * 
 * @package mmmfs
 **/

/**
 * Classe d�finissant les cl�s utilisable dans le framework
 * 
 *  KEY::$PK d�finit une cl� primaire (identifiant technique) 
 *  KEY::$FK d�finit une cl� �trang�re (sert de liaison entre deux entit�s)
 *  KEY::$AK d�finit une cl� associative (sert de liaison entre deux entit�s n�cessitant une table d'association interm�diaire') 
 * 
 * @since 1.0
 * @author Bess
 * @package mmmfs
*/
class KEY
{
	public static $PK = 0x9901; // Primary KEY
	public static $FK = 0x9902; // Foreign KEY
	public static $AK = 0x9903; // Associate KEY (necessite une table intermediaire)
}

?>