<?php
namespace SBCrud\Model\Page;

/**
 * Specifies the methods that a page accepting CRUD operations must implement.
 */
interface OperationParamPage
{
	/**
	 * Returns the name of the parameter that specifies which CRUD operation to execute.
	 *
	 * @return The operation parameter name
	 */
	public function getOperationParam(): string;
}
?>
