<?php
namespace SBCrud\Model;

/**
 * Provides an interface that can be used to uniformly read or change data
 * entity or data set.
 */
abstract class CRUDModel
{
	/** An associative array of values corresponding to the parameters provided through $GLOBALS["query"] */
	public array $keyValues;

	/**
	 * Constructs a CRUD model from a CRUD page
	 *
	 * @param $crudPage CRUD page that constructs this CRUD model
	 */
	public function __construct(CRUDPage $crudPage)
	{
		$this->keyValues = $crudPage->getKeyValues();
	}

	/**
	 * Executes the desired CRUD operation provided by the $_REQUEST["__operation"] parameter.
	 */
	public abstract function executeOperation(): void;
}
?>
