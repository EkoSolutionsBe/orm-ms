<?php
/**
 * Contains the class OrmEntity
 *
 * @since 0.0.1
 * @author Bess
 * @package Orm
 **/
 
/**
 * Abstract Classes describing the frame of an OrmEntity into Orm
 *
 * @since 0.0.1
 * @author Bess
 * @package Orm
 **/
abstract class OrmEntity
{
	/**
	 * String : Name of the module that currently use this entity
	 * */
	private $moduleName;
	
	/**
	 * String : the official name of the entity
	 * */
	protected $name;

	/**
	 * String : the name of the table in database
	 * */
	private $dbname;
	
	/**
	 * String : name of the sequence linked to the table in the database. May be Null
	 * */
	private $seqname;
	
	/**
	 * list : fields making up the entity
	 * */
	private $fields = array();
	
	/**
	 * list : values of each fields
	 * */
	private $values = array();
	
	/**
	 * String : Name of the field wich will be used as a primaryKey
	 * */
	private $pk;
	
	/**
	 * Boolean : if true the framework will try to use the inner autoincrement of Mysql instead generate a new table xxx_seq like usual
	 */
	private $autoincrement = false;
	
	/**
	 * Array, contains all the indexes of the Entity.
	 **/	 
	private $indexes = array();
	
	/**
	 * OrmOrderBy : if true the framework will try to use the inner autoincrement of Mysql instead generate a new table xxx_seq like usual
	 */
	private $defaultOrderBy;
	
	/**
	 * String : constant, suffix for the sequence name into the database
	 * */
	public static $_CONST_SEQ = '_seq';
	/**
	 * String : constant, suffix used to named the table into database for a module
	 * */
	public static $_CONST_MOD = 'module';
	
	
	
    /**
     * constructor protected to avoid a direct instantiation like "new OrmEntity()"
     * Each time a entity is constructed, we place a copy into the autoloader.
     * 
     * @param string The name of the module who calling this method (so not "Orm")
     * @param string The name of the entity
     * @param string [optional] Prefix to use into database for table. If not setted, it will use the name of your module
     * @param string [optional] The name of table for this entity. If not setted, it will use the name of your entity
     *
     * @return OrmEntity the entity as a new instance
     * 
     * @see MyAutoload
     */
	protected function __construct($moduleName, $name, $prefixe = null, $dbName = null) {
		$this->moduleName = strtolower($moduleName);
		$this->name = strtolower($name);
		
		$this->dbname = $this->name;
		if(!empty($dbName)) {
			$this->dbname = strtolower($dbName);
		}
		
		if(empty($prefixe)) {
			$prefixe = $this->moduleName;
		} else {
			$prefixe = strtolower($prefixe);
		}
		
		$this->dbname = cms_db_prefix().OrmEntity::$_CONST_MOD.'_'.$prefixe.'_'.$this->dbname;
		
		// We add an instance of our-serf into the autoload
		MyAutoload::addInstance($this->moduleName,$this);
	}
	
    /**
    *  Can be override. Let you specify how your table must be populated 
    * after you asked to create the table of your Entity
    */
	public function initTable(){}
    	
    /**
    * Add a new Field into the list of Fields
    * 
    * @param OrmField the object Field to add
	* 
	* @exception OrmIllegalConfigurationException if we try to use more than a single PrimaryKey in the entity
    */
	protected function add(OrmField $newField) {
		$this->fields[$newField->getName()] = $newField;

		//Add a sequence on the keys
		if($newField->isPrimaryKEY()) {
			if($this->pk != null)
				throw new OrmIllegalConfigurationException("Orm doesn't support multi-Primary-Key into the Entity ".$this->name);
				
			$this->pk = $newField->getName();
			if(!$this->isAutoincrement()) { // no sequence if autoincrement used
                $this->seqname = $this->dbname.OrmEntity::$_CONST_SEQ;
            }
		}
	}
	
    /**
    * Return the PrimaryKey Field
    * 
    * @return OrmField the PrimaryKey Field
    * @exception OrmIllegalArgumentException if there is no PrimaryKey Field
    */
	public function getPk() {
		if($this->pk == null)
			throw new OrmIllegalArgumentException("the entity {$this->getName()} doesn't have any Primary-Key");
		
		return $this->fields[$this->pk];
	}
	
    /**
    * Return the list of Fields
    * 
    * @return array<Field> an array with all the Fields
    * 
    */
	public function getFields() {
		return $this->fields;
	}
	
    /**
    * return a Field by name
    * 
    * @param string the field name
    * @return OrmField the Field
    * 
    * @exception OrmIllegalArgumentException if no Field exist for the name
    */
	public function getFieldByName($fieldName) {
		
		if(empty($fieldName)){
			throw new OrmIllegalArgumentException("The function getFieldByName(\$fieldName) doesn't accept a null parameter (entity : {$this->getName()})");
		}
	
		if(!array_KEY_exists($fieldName,$this->fields)){
			throw new OrmIllegalArgumentException("Function getFieldByName(\$fieldName) : The field {$fieldName} doesn't exist into the entity {$this->getName()}");
		}
		
		return $this->fields[$fieldName];
		
	}
	
    /**
    * Return true if a Field exists for the name
    * 
    * @param string the name
    * @return Boolean if exists
    */
	public function isFieldByNameExists($name) {
		return isset($this->fields[$name]);
	}
	
    /**
    * Return the name of the table into the database
    * 
    * @return string the name of the table into the database
    * 
    */
	public function getDbname() {
		return $this->dbname;
	}
	
    /**
    * Return the name of the entity
    * 
    * @return string the name of the entity
    * 
    */
	public function getName() {
		return $this->name;
	}
	
	/**
	 *  Return the name of the current module
	 *  
	 *  @return string the name of the current module.
	 **/
	public function getModuleName() {
		return $this->moduleName;
	}
	
    /**
    * Return the name of the sequence (if exists)
    * 
    * @return string the name of the sequence or NULL
    * 
    */
	public function getSeqname() {
		if(empty($this->seqname))
			return null;
		
		return $this->seqname;
	}
	
    /**
    * Return the value for a Field by the name 
    * 	
    * @param string the name of the Field
    * @return mixed the value for the field
    * 
    * @exception OrmIllegalArgumentException if no Field exists for the name
    */
	public function get($fieldName) {
		
		if(empty($fieldName)){
			throw new OrmIllegalArgumentException("The function get(\$fieldName) doesn't accept a null parameter (entity : {$this->getName()})");
		}
	
		if(!array_KEY_exists($fieldName,$this->fields)){
			throw new OrmIllegalArgumentException("Function get(\$fieldName) : The field {$fieldName} doesn't exist into the entity {$this->getName()}");
		}
		
		if(!array_KEY_exists($fieldName,$this->values)){
			return null;
		}
		
		return $this->values[$fieldName];
	}
	
   /**
    * Set a value to a Field
    *     
    * @param string The name of the Field
    * @param mixed the new value of the Field
    * 
    * @exception OrmIllegalArgumentException if no Field exists for the name
    */
	public function set($fieldName,$value) {
		
		if(empty($fieldName)){
			throw new OrmIllegalArgumentException("The function set(\$fieldName) doesn't accept a null parameter (entity : {$this->getName()})");
		}
	
		if(!array_KEY_exists($fieldName,$this->fields)){
			throw new OrmIllegalArgumentException("Function set(\$fieldName) : The field {$fieldName} doesn't exist into the entity {$this->getName()}");
		}
		
		$this->values[$fieldName] = $value;
	}
	
    /**
    * Return the values for all the Fields into an associative array with 
    *  * key = name of the Field, and 
    *  * value = its value
    * 
    * @return array an associative array
    * 
    */
	public function getValues() {
		return $this->values;
	}
		
	/**
	 * Shortcut to save the entity. if the primaryKey is setted, it will be an update operation, else an insert.
	 *
	 * @return the entity saved with its new new Id (customer_id in my example) if it's an insertion
	 **/
	public function save(){
		if($this->pk == null) {
			throw new OrmIllegalArgumentException("you can't save the entity ".$this->getName()." because it doesn't have any Primary-Key");
		}
	
		if($this->get($this->pk) == null) {
			return OrmCore::insertEntity($this);
		} else {
			//Try to find if it's an update or insert with already an Id
			if(OrmCore::findById($this, $this->get($this->pk)) == null) {
				return OrmCore::insertEntity($this);
			}
			
			return OrmCore::updateEntity($this);
		}
	}
	
	/**
	 * Shortcut to delete the entity
	 **/
	public function delete(){
		if($this->pk == null) {
			throw new OrmIllegalArgumentException("you can't delete the entity ".$this->getName()." because it doesn't have any Primary-Key");
		}
		
		if($this->get($this->pk) == null) {
			throw new OrmIllegalArgumentException("you can't delete the entity ".$this->getName()." because its Primary-Key doesn't have any value");
		}
		
		OrmCore::deleteByIds($this, array($this->get($this->pk)));
	}
	
    /**
    * Can be overridden Let you modify some data just before saving the data into the datatable.
    * 
    * @param array all the values to process
    * @param array more parameters if you need, if you want
    * 
    * @return mixed to define
    */
	public function processValueForSave($rows, $args = null){
	
		return $rows;
	}
	
	/**
	 * Call the compareTo function into your Entity to sort the Entities.
	 * To activate this functionality, The Entity must implement ISortable Interface.
	 *
	 * Example of function compareTo() in a Customer Entity
	 *  <code>
	 *       
	 *	public static function compareTo(OrmEntity $entity1, OrmEntity $entity2)
	 *	{
	 *		$compare = strcmp($entity1->get('name'), $entity2->get('name'));
	 *      	return $compare;
	 *	}
	 * 
	 *  </code>
	 *
	 * @param array<OrmEntity> the list of Entity to sort
	 *
	 * @return array<OrmEntity> the list of Entity gracefully sorted
	 */
	public static function sort(array $array) {

		usort($array, array(get_called_class(), "compareTo"));
	
		return $array;
	}
	
	/**
	 * May be override in your Entity's definition to allow Search module indexing your entities's data
	 * 
	 * Example of function isIndexable() in a Customer Entity
	 *  
	 *  <code>
	 *       
	 *	public static function isIndexable()
	 *	{
	 *		return this->get['isActivated'];
	 *	}
	 * 
	 *  </code>
	 **/
	public static function isIndexable(){
		return false;
	}
		
	/**
    * getter for autoincrement
    * 
    * @return true of the Field is autoincrement
    */
	public function IsAutoincrement() {
		return $this->autoincrement;
	}
	
	/**
	 * This function will let you define some optional configuration for your Entity
	 *    => the field must be auto-incremental
	 **/
	public function garnishAutoincrement(){
		
		if($this->getPk() == null || $this->getPk()->getType() != OrmCAST::$INTEGER){
			throw new OrmIllegalArgumentException("entity ".$this->getName()." don't have any INTEGER PK and so can't be defined autoincrement");
		}
		$this->autoincrement = true;
		
		//Remove any seq that could be add before
        $this->seqname = null;
	}
	
	/**
	 * Return 
	 * @return array : the list of couple of unique index
	 **/
	public function getIndexes() {
		return $this->indexes;
	}
	
	/**
	 * This function will let you define some optional configuration for your Entity
	 *    => the field have one or many (Unique?) Indexe on one or many columns.
	 *
	 *  example : 
	 *  <code>
	 *     myEntity->addIndexes('field1',true);
	 *     myEntity->addIndexes(array('field2', 'field3'));
	 *  <code>
	 *  will create 1 unique index on field1 and 1 index on field2,field3
	 *
	 * @param mixed One (string) or many (array) name of field to be indexing
	 * @param boolean if the index must be UNIQUE (default = false) 
	 *
	 **/
	public function addIndexes($fieldNames, $isUnique=false){
		
		if(!is_array($fieldNames)){
			$fieldNames = array($fieldNames);
		}
		
		//Test the existence of each member
		foreach($fieldNames as $fieldName){
			if(!$this->isFieldByNameExists($fieldName)){
				throw new OrmIllegalArgumentException("addIndexes(\$fieldNames, \$isUnique=false) : {$fieldNames} is not a existing Field of the Entity {$this->getName()}");
			}
		}
	
		$this->indexes[] = array('fields' => $fieldNames, 'unique' => $isUnique);
	}
	
	/**
	 * This function will let you define some optional configuration for your Entity
	 *    => the default value of the field is ...
	 *
	 *  ex : myEntity->garnishDefaultValue('field1', 'some text')
	 *
	 * @param String the name of the Field
	 * @param Mixed the default value.
	 *
	 **/
	public function garnishDefaultValue($fieldName,$defaultValue){
		if(!$this->isFieldByNameExists($fieldName)){
			throw new OrmIllegalArgumentException("garnishDefault() only accept valid Field but ".$fieldName." is not a existing Field in the Entity ".$this->getName());
		}
		
		//forbid a default value on a nullable field Because it's make no sense
		if($this->getFieldByName($fieldName)->isNullable()){
			throw new OrmIllegalArgumentException("the Field ".$fieldName." in the Entity ".$this->getName()." can't accept a default value because it's setted Nullable");
		}
		
		$this->getFieldByName($fieldName)->setDefaultValue($defaultValue);
		
	}
	
	/**
	 * This function will let you define some optional configuration for your Entity
	 *    => the default sort order is ...
	 *
	 *  ex : myEntity->garnishDefaultOrderBy(new OrmOrderBy()->addAsc('field1')->addDesc('field2'))
	 *
	 * @param OrmorderBy the default sort order.
	 *
	 **/
	public function garnishDefaultOrderBy(OrmOrderBy $defaultOrderBy){
		foreach($defaultOrderBy as $fieldName => $value) {
			if(!$this->isFieldByNameExists($fieldName)){
				throw new OrmIllegalArgumentException("garnishDefaultOrderBy() only accept valid Field but ".$fieldName." is not a existing Field in the Entity ".$this->getName());
			}
		}
		$this->defaultOrderBy = $defaultOrderBy;
	}
	
	/**
	 * Return 
	 * @return OrmOrderBy : default OrmOrderBy
	 **/
	public function getDefaultOrderBy() {
		return $this->defaultOrderBy;
	}
	
	
}

?>
