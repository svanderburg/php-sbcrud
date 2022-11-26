<?php
namespace SBCrud\Model\Page;
use SBData\Model\ParameterMap;

/**
 * Specifies the methods that a page that facilitates request parameter checking needs to implement.
 */
interface CheckedPage
{
	/**
	 * Creates a request parameter map that specifies how request parameters should be checked.
	 * Request parameters are transitive.
	 *
	 * @return A parameter map in which the keys correspond to parameters in the $_REQUEST array and every value the Value object to check the parameter
	 */
	public function createRequestParameterMap(): ParameterMap;
}
?>
