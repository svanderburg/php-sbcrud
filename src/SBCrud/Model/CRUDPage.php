<?php
namespace SBCrud\Model;
use SBData\Model\ParameterMap;

/**
 * Mandates the functions any page providing CRUD operation must implement.
 */
interface CRUDPage
{
	/**
	 * Constructs a crud model from the CRUD page that can be used to read
	 * or modify the desired data entity.
	 *
	 * @return A CRUD model for a data entity or set
	 */
	public function constructCRUDModel(): CRUDModel;

	/**
	 * Returns the parameter map that are used for validation of the keys in a URL.
	 *
	 * @return A parameter map mapping key to values
	 */
	public function getKeyParameterMap(): ParameterMap;
}
?>
