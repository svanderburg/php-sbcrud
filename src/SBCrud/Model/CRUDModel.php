<?php
namespace SBCrud\Model;
use SBData\Model\ParameterMap;

/**
 * Provides an interface that can be used to uniformly read or change data
 * entity or data set.
 */
abstract class CRUDModel
{
	/** An object mapping the keys of a URL to values corresponding to the parameters provided through $GLOBALS["query"] */
	public ParameterMap $keyParameterMap;

	/**
	 * Constructs a CRUD model from a CRUD page
	 *
	 * @param $crudPage CRUD page that constructs this CRUD model
	 */
	public function __construct(CRUDPage $crudPage)
	{
		$this->keyParameterMap = $crudPage->getKeyParameterMap();
	}

	/**
	 * Executes the desired CRUD operation provided by the $_REQUEST["__operation"] parameter.
	 */
	public abstract function executeOperation(): void;
}
?>
