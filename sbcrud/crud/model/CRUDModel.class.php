<?php
require_once("CRUDPage.interface.php");

/**
 * Provides an interface that can be used to uniformly read or change data
 * entity or data set.
 */
abstract class CRUDModel
{
	/** An associative array of fields used to validate the parameters provided through $GLOBALS["query"] */
	public $keyFields;

	/**
	 * Constructs a CRUD model from a CRUD page
	 *
	 * @param CRUDPage $crudPage CRUD page that constructs this CRUD model
	 */
	public function __construct(CRUDPage $crudPage)
	{
		$this->keyFields = $crudPage->getKeyFields();
	}

	/**
	 * Executes the desired CRUD operation provided by the $_REQUEST["__operation"] parameter.
	 */
	public abstract function executeOperation();
}
?>
