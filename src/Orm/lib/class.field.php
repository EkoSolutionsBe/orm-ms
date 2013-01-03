<?php
/**
 * Contient les principales classes utilis�es pour g�rer les Fields
 *
 * @since 1.0
 * @author Bess
 * @package mmmfs
 **/
 
/**
 *   Repr�sente un champs d'une entit� dans son ensemble, depuis la base de donn�e � l'affichage 
 *    en passant par les liaisons inter-entit�
 * 
 * @since 1.0
 * @author Bess
 * @package mmmfs
 **/
class Field 
{
	private $name;
	private $type;
	private $size;
	
	private $KEY;
	private $KEYName;
	
	private $HTML;
	private $nullable;
	
	public static $ISNULLABLE = true;
	
    /**
    * constrcteur public 
    * 	
    * @param string le nom du champs (doit �tre unique pour toute l'entit�)
    * @param CAST une propri�t� de la classe CAST. repr�sente le typage du champs, exemple CAST::$INTEGER
    * @param int la taille max du champs en base et dans l'application. N'est pas n�cessaire si le typage du champs est un CAST::$BUFFER, CAST::NONE, ...
    * @param nullable d�finit si le champs est facultatif en base, exemple Field::$ISNULLABLE pour un champs facultatif, laisser � vide pour un champs obligatoire
    * @param KEY une propri�t� de la classe KEY ou null, repr�sente les cl�s primaires, �trang�res ou associative, exemple KEY::$PK pour une cl� primaire
    * @param string uniquement utilisable avec KEY::$FK et KEY::$AK. Chaine de liaison de l'�ventuelle cl� �trang�re ou associative. Mettre � null si inutilis�. exemple : "Client.client_id" dans le Field "client" servant de cl� �trang�re pour l'entit� "Commande" 
   
    * 
    * @return Field le champs d�finit pr�t � �tre stock� dans une entit�.
    * 
    * 
    * @see CAST
    * @see KEY
    * @see NULLABLE
    * 
    */
	public function __construct($fieldname, $cast, $size = null, $nullable = null, $KEY = null, $KEYName=null)
	{
		if(empty($KEY) && !empty($KEYName))
		{
			throw new IllegalConfigurationException('Impossible de specifier le nom d\'une cle etrangere si le type de cle n\'est pas definie a $PK ou a $AK');
		}
		if($KEY == KEY::$PK && !empty($KEYName))
		{
			throw new IllegalConfigurationException('la cle $PK n\'accepte aucun nom de cle etrangere');
		}
		if(($KEY == KEY::$FK || $KEY == KEY::$AK) && empty($KEYName))
		{
			throw new IllegalConfigurationException('les cles $FK et $AK imposent un nom de cle etrangere');
		}
		
		if(($cast == CAST::$DATE || $cast == CAST::$BUFFER) && !empty($size))
		{
			throw new IllegalConfigurationException('Le typage DATE ou BUFFER du champs '.$fieldname.' ne peut posseder une taille');
		}
		

		if($nullable == null)
			$nullable = false;
			
		$this->name 	= $fieldname;
		$this->type 	= $cast;
		$this->size 	= $size;
		$this->nullable = $nullable;
		$this->KEY 		= $KEY;
		$this->KEYName 	= $KEYName;
	}
	

    /**
    * function getter
    * 
    * @return string le nom du Field
    */
	public function getName()
	{return $this->name;}

    /**
    * function getter
    * 
    * @return string le cast du Field
    * 
    * @see CAST
    * 
    */	
	public function getType()
	{return $this->type;}
	
   /**
    * function getter
    * 
    * @return int la taille max du champs
    */
	public function getSize()
	{return $this->size;}

   /**
    * function getter
    * 
    * @return boolean vrai si le champs est une cl� primaire
    */	
	public function isPrimaryKEY()
	{return $this->KEY == KEY::$PK;}

   /**
    * function getter
    * 
    * @return boolean vrai si le champs est une cl� �trang�re
    */    	
	public function isForeignKEY()
	{return $this->KEY == KEY::$FK;}

   /**
    * function getter
    * 
    * @return boolean vrai si le champs est une cl� d'association
    */    	
	public function isAssociateKEY()
	{return $this->KEY == KEY::$AK;}
	
    /**
    * function getter  
    * 
    * @return string la chaine de liaison de l'�ventuelle cl� �trang�re ou associative
    * 
    */
	public function getKEYName()
	{return $this->KEYName;}
	
    /**
    * function getter  
    * 
    * @return true si le champs Field est facultatif. renvoit faux si champs Field obligatoire
    */
	public function isNullable()
	{return $this->nullable;}
	
}

?>