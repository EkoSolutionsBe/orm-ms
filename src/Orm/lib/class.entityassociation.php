<?php
/**
 * Contient les classe m�res de toutes les entit�s et entit�s associatives
 * @package mmmfs
 **/
 
/**
 * Class abstract d�crivant le comportement et les propri�t�s d'une Entit� Associative
 *    
 *
 * @since 1.0
 * @author Bess
 * @package mmmfs
 **/
abstract class EntityAssociation extends Entity 
{
	private $nbField = 0;

     /**
    * Constructeur semi-priv� pour �viter d'instancer cette classe depuis le code par erreur
    * 
    *   A chaque construction, l'entit� est plac�e dans l'Autoloader
    * 
    * @param string le nom d'un module de type Mmmfs
    * @param string le nom de l'entit�
    * @param string le pr�fixe � utiliser en base de donn�e pour les tables. En g�n�ral le nom de votre module
    * @param string si renseign� sera le nom de la table li�e � cette entit�. Si non renseign�e on prendra le nom de l'entit�
    * @return EntityAssociation l'entite servant de mod�le
    * 
    * @see MyAutoload
    */
	protected function __construct($moduleName, $name,$prefixe = null, $dbName = null)
	{
		parent::__construct($moduleName, $name, $prefixe, $dbName);
	}
	
    /**
    * Ajoute un champs 
    * 
    * Le programme ne g�re que deux champs par EntityAssociation
    * 
    * @param Field le champs � ajouter.
    */
	protected function add(Field $newField)
	{
		$this->nbField ++;
		
		if($this->nbField > 2)
			throw new Exception ("impossible d'utiliser une table d'association avec plus de 2 champs cle. Entite : ". $this->getName());
				
		parent::add($newField);
	}

}