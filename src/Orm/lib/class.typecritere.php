<?php
/**
 * Contient toutes les fonctionnalit�s relatives aux recherches par Crit�res
 * 
 * @since 1.0
 * @author Bess
 * @package mmmfs
 **/
 

/**
* Enum des diff�rents TypeCritere envisageable
* 
* utiliser ainsi :
* 
* <code>
* TypeCritere::$EQ
* </code>
* 
 * @since 1.0
 * @author Bess
 * @package mmmfs
 **/
class TypeCritere
{
    /**
    * Est �gal �
    * 
    * @var string
    */
	public static $EQ = ' = ';
    
    /**
    * Est diff�rent de 
    * 
    * @var string
    */
	public static $NEQ = ' != ';
    
    /**
    * est strictement sup�rieur �
    * 
    * @var string
    */
	public static $GT = ' > ';
    
    /**
    * est superieur ou �gal �
    * 
    * @var string
    */
	public static $GTE = ' >= ';
    
    /**
    * est strictement inferieur �
    * 
    * @var string
    */
	public static $LT = ' < ';
    
    /**
    * est inferieur ou �gal � 
    * 
    * @var string
    */
	public static $LTE = ' <= ';
	
	/**
    * est null ou vide
    * 
    * @var string
    */
	public static $EMPTY = 'is empty()';
	
    /**
    * est non null et non vide
    * 
    * @var string
    */
	public static $NEMPTY = 'is not empty()';
    
    /**
    * est null
    * 
    * @var string
    */
	public static $NULL = ' is null ';
    
    /**
    * n'est pas null
    * 
    * @var string
    */
	public static $NNULL = ' is not null';
    
    /**
    * est avant (Date)
    * 
    * @var string
    */
	public static $BEFORE = ' before ';
    
    /**
    * est apr�s (Date)
    * 
    * @var string
    */
	public static $AFTER = ' after ';
    
    /**
    * est entre (Date)
    * 
    * @var string
    */
	public static $BETWEEN = ' after ';
     
    /**
    * est contenu dans la liste suivante
    * 
    * /!\ n�cessite au minimum deux valeurs dans le tableau de param�tre
    * 
    * @var string
    */
	public static $IN = 'in (%a)';
    
    /**
    * n'est pas contenu dans la liste suivante
    *                                                                   
    * /!\ n�cessite au minimum deux valeurs dans le tableau de param�tre
    * 
    * @var string
    */
	public static $NIN = 'not in (%a)';
    
    /**
    * contient la chaine suivante
    * 
    * /!\ vous devez ajouter vous m�me les caract�res g�n�riques '%'
    * 
    * @var string
    */
	public static $LIKE = ' like ';
    
    /**
    * contient la chaine suivante
    * 
    * /!\ vous devez ajouter vous m�me les caract�res g�n�riques '%'
    * 
    * @var string
    */
	public static $NLIKE = ' not like ';
}
?>