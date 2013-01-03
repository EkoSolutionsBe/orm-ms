<?php
/**
 * Contient les principales classes utilis�es pour g�rer les moteurs de recherche dans le front-office
 *
 * @since 1.0
 * @author Bess
 * @package mmmfs
 **/

/**
 *   Repr�sente un champs du moteur de recherche
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
class SeachElement
{
	private $name;
	private $fieldname;
	private $typeCritere;
	private $searchField;
	
    /**
    * constructeur public
    * 
    * @param string le nom du champs de recherche. Doit �tre unique dans le moteur de recherche
    * @param string le nom du champs de l'entit� li�e.
    * @param TypeCritere le Type de Crit�re associ� (�galit� absolue, sup�rieur �...)
    * @param SEARCH_FIELD le champs HTML auto-g�n�r� d�di� aux moteurs de recherche
    * 
    * @return SeachElement un champs de moteur de recherche.
    */
	public function __construct($name,$fieldname,$typeCritere, $searchField)
	{	
		$this->name = $name;
		$this->fieldname = $fieldname;
		$this->typeCritere = $typeCritere;
		$this->searchField = $searchField;
	}
       
   /**
    * function getter
    * 
    * @return string le nom du champs
    */
	public function getName()
	{return $this->name;} 
       
   /**
    * function getter
    * 
    * @return string le nom du champs de l'entit� li�e
    */
	public function getFieldname()
	{return $this->fieldname;} 
       
   /**
    * function getter
    * 
    * @return TypeCritere le Type de Crit�re associ� (�galit� absolue, sup�rieur �...)   
    */
	public function getTypeCritere()
	{return $this->typeCritere;} 
       
   /**
    * function getter
    * 
    * @return SEARCH_FIELD le champs HTML auto-g�n�r� d�di� aux moteurs de recherche
    */
	public function getSearchField()
	{return $this->searchField;}
}


?>