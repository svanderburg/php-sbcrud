<?php
namespace SBCrud\Model;

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
	 * Returns the key fields that are used for validation of the URL
	 * parameters.
	 *
	 * @return An associative array mapping keys to fields
	 */
	public function getKeyFields(): array;
}
?>
