<?php
/**
 * Contient la classe qui g�re le cache de mmmfs
 * 
 * @package mmmfs
 **/


/**
 * Gestion d'un mini cache interne
 *
 *  Class static g�rant toute la partie cache des acc�s � la base de donn�e. 
 *	Utilis�e pour �viter de trop nombreux appels en base sur les listing d'entit� charg�es
 *  Exemple : 
 *  <code>
 *  	//Appel � cmsms pour r�cup�rer le connecteur de bdd
 *  	$gCms = cmsms();
 *  	$db = $gCms->GetDb();
 *  	
 *  	//D�finition d'une entit� client
 *  	$entity = new Client();
 *  	
 *  	//Selection de tous les clients
 *  	$querySelect = 'Select * FROM '.$entity->getDbname();
 *  	
 *  	//Si requ�te pr�c�dement execut�e : on retourne directement du cache le r�sultat
 *  	if(Cache::isCache($querySelect))
 *  	{
 *  		return Cache::getCache($querySelect);
 *  	}
 *  	
 *  	//On execute la requ�te
 *  	$result = $db->Execute($querySelect);
 *  	if ($result === false){die("Database error!");}
 *  	
 *  	$entitys = array();
 *  	while ($row = $result->FetchRow())
 *  	{
 *  		$entitys[] = Core::rowToEntity($entity, $row);
 *  	}
 *  	
 *  	//On repousse dans le cache le r�sultat pour un prochain passage
 *  	Cache::setCache($querySelect, null, $entitys);
 *  	return $entitys;
 *	</code>
 *
 * @since 1.0
 * @author Bess
 * @package mmmfs
 **/
final class Cache 
{	
	/**
	 * Variable contenant l'ensemble des r�sultats des requ�tes pass�es
	 **/
	private static $cache;
		
	/**
	 * Constructeur priv�
	 */
	protected function __construct() {}
			
	/**
	 *	D�finit le cache pour une requ�te donn�e, une liste de param�tre et �videment le r�sultat obtenu
     * 
	 * @param string la requ�te sql
	 * @param array la liste des param�tres dans un tableau ou null
	 * @param object la valeur � m�moriser (array ou string ou integer ou ...)
	 */
	public static final function setCache($sql, $params = null, $value)
	{		
		if(!isset(self::$cache))
		{
			self::$cache = array();
		}
		
		self::$cache[Cache::hash($sql,$params)] = $value;
		
	}
	
	/**
	 * Demande le cache pour une requete donn�e et une liste de param�tre
     * 
	 * @param string la requ�te sql
	 * @param array la liste des param�tres dans un tableau ou null
	 * @return object la valeur contenu dans le cache (array ou string ou integer ou ...)
	 */
	public static final function getCache($sql, $params = null)
	{
		if(Cache::isCache($sql, $params))
		{
			return self::$cache[Cache::hash($sql,$params)];
		}
		
		return null;
	}

	/**
	 * Renvoi vrai si un cache existe pour une requ�te et une liste de param�tre
     * 
	 * @param string la requ�te sql
	 * @param array la liste des param�tres dans un tableau ou null
	 * @return boolean vrai si un cache existe
	 */	
	public static final function isCache($sql, $params = null)
	{
		return isset(self::$cache) && array_KEY_exists(Cache::hash($sql,$params),self::$cache);
	}

	/**
	 * Vide le cache. Indispensable si entre des lectures de donn�e une mise � jour est faite par le traitement.
	 *  Par s�curit� le processus vide int�gralement le cache
	 */	
	public static final function clearCache()
	{
		unset(self::$cache);
	}

	/**
	 * Retourne une signature unique de la combinaison de la requ�te SQL et de la liste des param�tres.
	 *  le Hash g�n�r� est utilis� dans la class pour r�cup�rer ou pour d�finir le cache.
     * 
	 * @param string la requ�te sql
	 * @param array la liste des param�tres dans un tableau ou null
	 * @return string le hashage
	 */	
	public static final function hash($sql, $params = null)
	{
		if($params == null)
		{return md5($sql);}
		
		$p = print_r($params, true);

		return md5($sql.$p);
	}

		
}

?>