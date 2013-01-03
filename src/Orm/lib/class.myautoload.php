<?php
/**
 * Contient la classe qui g�re le chargement automatique des classes en m�moire
 * 
 * @package mmmfs
 **/
 
 /**
 * Class static g�rant les entit�s utilis�es dans l'application
 *	L'int�r�t �tant de ne pas red�clarer X instances de class identiques inutilement.
 *
 * @since 1.0
 * @author Bess
 * @package mmmfs
 **/
final class MyAutoload
{
	private static $instances;
	
	/**
	 * Constructeur priv�
	 */
	protected function __construct()
	{
	}	
	
	/**
	 * Fonction appel�e par le noyau des entit�es et des entit�es de recherche, 
	 * il va instancier l' entit� si elle est inexistante et la stocker en m�moire
     * 
	 * @param namespace le namespace de l'application
	 * @param string l'instance : "new maClass()". L'instance doit h�riter de Entity / EntityAssociation ou SearchCore
	 */
	public final static function addInstance($namespace, $newinstance)
	{	
		$namespace = strtolower($namespace);
		
		$name = $newinstance->getName();
		$name = strtolower($name);
				
		if(isset(self::$instances[$namespace][$name]))
		{
			Trace::debug("Instance ".$name." deja presente.");
			return;
		}
		Trace::debug("Ajout de l'instance ".$name);
		self::$instances[$namespace][$name] = $newinstance;
	}
	
	/**
	 * Renvoi une instance d'entit� pr�c�dement instanci�e. Chaque instance retourn�e est un clone ce qui �vite d'utiliser 
	 * le m�me pointeur m�moire et d'�craser ses propres donn�es
     * 
	 * @param namespace le namespace de l'application
	 * @param string le nom de l'instance � retourner. L'instance doit h�riter de Entity / EntityAssociation ou SearchCore
	 * @return Object instance une instance
	 */
	public final static function getInstance($namespace, $instanceName)
	{
		$namespace = strtolower($namespace);
		$instanceName = strtolower($instanceName);
		myAutoload::isValideNamespace($namespace);
		
		Trace::debug("Demande de l'instance ".$instanceName);
		if(myAutoload::hasInstance($namespace, $instanceName))
		{
			Trace::debug("Instance ".$instanceName." retournee.");
			return clone self::$instances[$namespace][$instanceName];
		}
		
		Trace::error("Aucune instance $instanceName n'est stockee dans l'autoload");
		throw new Exception("Aucune instance $instanceName n'est stockee dans l'autoload");
	}
	
	/**
	 * Retourne vrai si une instance d'entit� existe pour le m�me namespace
     * 
	 * @param namespace le namespace de l'application
	 * @param string le nom de l'instance � retourner. L'instance doit h�riter de Entity / EntityAssociation ou SearchCore
	 * @return Boolean si l'instance existe
	 */
	public final static function hasInstance($namespace, $instanceName){
		$namespace = strtolower($namespace);
		$instanceName = strtolower($instanceName);
		
		myAutoload::isValideNamespace($namespace);
		
		return isset(self::$instances[$namespace][$instanceName]);
	}
	
	/**
	 * Renvoi toutes les instances d'entit�s pr�c�dement instanci�es. Par d�faut ne renvoi pas les instances d'entit�s h�ritants de SearchCore (les moteurs de recherche)
     * 
	 * @param namespace le namespace de l'application
	 * @param boolean si d�finit � vrai, incluera la liste des d'entit�s h�ritants de SearchCore
	 * @return array une liste d'instances
	 */
	public final static function getAllInstances($namespace, $include_search = false)
	{
		$namespace = strtolower($namespace);
		myAutoload::isValideNamespace($namespace);
	
		if($include_search) {
			return self::$instances[$namespace];
		}
		
		$listeRetour = array();
		$insts = self::$instances[$namespace];
		foreach($insts as $inst)
		{
			if($inst instanceof SearchCore)
				continue;
			
			$listeRetour[] = $inst;
		}
		return $listeRetour;
	}
	
	/**
	 * Retourne vrai si le namespace est valide
     * 
	 * @param namespace le namespace de l'application
	 * @return Boolean si le namespace existe
	 */
	private static function isValideNamespace($namespace)
	{
		if(!isset(self::$instances[$namespace]))
		{
			Trace::error("Le namespace '$namespace' n'existe pas dans le module Mmmfs.");
			throw new IllegalArgumentException("Le namespace $namespace n'existe pas dans le module Mmmfs.");
		}
	}
}
?>