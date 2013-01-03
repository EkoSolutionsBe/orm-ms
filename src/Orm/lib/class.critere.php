<?php
/**
 * Contient toutes les fonctionnalit�s relatives aux recherches par Crit�res
 * 
 * @since 1.0
 * @author Bess
 * @package mmmfs
 **/
 
 

/**
* Classe structurant un crit�re 
* 
* Contient un nom de champs, un TypeCritere, un tableau de param�tre et un boolean pour la casse
*
 * @since 1.0
 * @author Bess
 * @package mmmfs
 **/
final class Critere
{
	public $fieldname;
	public $typeCritere;
	public $paramsCritere;
	public $ignoreCase;
	
    /**
    * Constructeur public
    * 
    * @param string le nom du champs Field
    * @param TypeCritere une valeur de la class TypeCritere 
    * @param array un tableau de param�tres utilis�s en association avec le param�tre $typeCritere
    * @param boolean $ignoreCase faux par d�faut, sp�cifie si l'on souhaite utiliser le TypeCritere avec ou sans casse (aze != AZE)
    * @return Critere
    */
	public function __construct($fieldname, $typeCritere, $paramsCritere, $ignoreCase = false)
	{
		$this->fieldname = $fieldname;
		$this->typeCritere = $typeCritere;
		$this->paramsCritere = $paramsCritere;
		$this->ignoreCase = $ignoreCase;
	}
	
}

?>