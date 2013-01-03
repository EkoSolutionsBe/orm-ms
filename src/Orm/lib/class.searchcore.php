<?php
/**
 * Contient les principales classes utilis�es pour g�rer les moteurs de recherche dans le front-office
 *
 * @since 1.0
 * @author Bess
 * @package mmmfs
 **/

/**
 *   Repr�sente une entit� d�di�e � la recherche.
 * 
 * Un moteur de recherche se base toujours sur une entit� existante. 
 * Un moteur de recherche contient un ou plusieurs champs (SearchElement) toujours li�s � un champs (FIELD) de l'entit�'
 * Plusieurs Champs (SearchElement) peuvent �tre li� � un m�me champs (FIELD) d'une entit�, l'utilisation par exemple d'une recherche avec un prix mini et un prix maxi
 * 
 * La composition d'un moteur de recherche est assez semblable � celle d'une entit�, par exemple :
 * 
 * <code>
 *  class SearchClient extends SearchCore
 *  {
 *   public function __construct()
 *   {
 *       parent::__construct('search_client','client'); //liaison sur l'entit� Client
 *       
 *        $this->listeElements['codepostal'] =    
 *              new SeachElement('codepostal', 'codepostal', mTypeCritere::$EQ, new SEARCH_FIELD_SELECT());     
 * 
 *        $this->listeElements['agemin'] =         
 *              new SeachElement('agemin',     'age',        mTypeCritere::$GTE, new SEARCH_FIELD_TEXT());
 * 
 *        $this->listeElements['agemax'] =        
 *              new SeachElement('agemax',     'age',        mTypeCritere::$LTE, new SEARCH_FIELD_TEXT());
 *                                                                                                                    
 *   }
 *  }
 * </code>
 * 
 *   Donnera un moteur de recherche de client par leur code postal avec possibilit� de pr�ciser l'age minimum et/ou l'age maximum du client
 * 
 * @since 1.0
 * @author Bess
 * @package mmmfs
 **/  
class SearchCore 
{	
	protected $listeElements;
	protected $entityName;
	protected $name;
	
    /**
    * Constructeur public
    * 
    *  A noter que la classe une fois cr��e se charge automatiquement dans l'Autoloader
    * 
	* @param string le nom d'un module de type Mmmfs
    * @param string le nom du moteur de recherche. Doit �tre unique dans toute l'application
    * @param string $entityName le nom de l'entit� li�e. Doit �tre existante
    * @return SearchCore le moteur de recherche
    */
	public function __construct($modulename, $name, $entityName)
	{
		$this->name = strtolower($name);
		$this->entityName = strtolower($entityName);
		$this->listeElements = array();
		
		//On ajoute une instance de soi dans l'autoload
		myAutoload::addInstance(strtolower($modulename), $this);
	}
   
   /**
    * function getter
    * 
    * @return string le nom du moteur de recherche
    */
	public function getName()
	{return $this->name;}
	   
   /**
    * function getter
    * 
    * @return string le nom de l'entit� li�e
    */
	public function getEntityName()
	{return $this->entityName;}
	
      
   /**
    * function getter
    * 
    * @return array la liste des SearchElement du moteur de recherche
    */
	public function getListeElements()
	{return $this->listeElements;}
	
}

?>