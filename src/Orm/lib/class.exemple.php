<?php
/**
 * Contient toutes les fonctionnalit�s relatives aux recherches par Crit�res
 * 
 * @since 1.0
 * @author Bess
 * @package mmmfs
 **/
 
 
/**
 * Class repr�sentant le cumul de X Crit�re en vu de faire une recherche par Exemple
 *    
 *
 * @since 1.0
 * @author Bess
 * @package mmmfs
 **/
final class Exemple 
{
	private $Criteres = array();
	
    /**
    * Constructeur public.
    * 
    */
	public function __construct()
	{
	}
	
    
    /**
    * Ajoute un Critere � la liste existante
    * 
    * @param string le nom du champs Field
    * @param string une valeur de la class TypeCritere 
    * @param array un tableau de param�tres utilis�s en association avec le param�tre $typeCritere
    * @param boolean $ignoreCase faux par d�faut, sp�cifie si l'on souhaite utiliser le TypeCritere avec ou sans casse (aze != AZE)
    * 
    * @see TypeCritere
    */
	public function addCritere($fieldname, $typeCritere, $paramsCritere, $ignoreCase = false)
	{
		if(!is_array($paramsCritere))
		{
			throw new Exception("le parametre Critere [".$fieldname."] de l'Exemple doit etre une liste");
		}
		
		$this->Criteres[] = new Critere($fieldname, $typeCritere, $paramsCritere, $ignoreCase);
	}

    /**
    * Retourne tous les Crit�res contenu dans l'objet Exemple.
    * 
    * @return array<Critere> la liste des objets Critere
    */
	public function getCriteres(){
		return $this->Criteres;
	}
}

?>