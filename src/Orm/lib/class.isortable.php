<?php
/**
 * Contient l'interface de Tri iSortable qui permet de trier les r�sultats d'une entit�
 * @package mmmfs
 **/
 
/**
 * Interface de tri d'une Entit�
 *	
 *
 * @since 1.0
 * @author Bess
 * @package mmmfs
 **/
interface ISortable
{
	
    /**
    * Fonction qui compare deux entit�s pass�es en param�tre 
    * 
    * 
    * @param Entity la premi�re entit� avec ses valeurs renseign�es
    * @param Entity la seconde entit� avec ses valeurs renseign�es
    * @return entier z�ro si �galit�, 1 si la premi�re entit� est sup�rieure, -1 si la seconde entit� pass�e en param�tre est sup�rieure
    * 
    * @see Entity
    */
	public static function compareTo(Entity $entity1, Entity $entity2);
}



?>