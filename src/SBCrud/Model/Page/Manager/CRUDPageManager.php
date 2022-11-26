<?php
namespace SBCrud\Model\Page\Manager;
use SBLayout\Model\Application;
use SBLayout\Model\Route;
use SBLayout\Model\BadRequestException;

/**
 * Manages pages the expose CRUD operations
 */
class CRUDPageManager
{
	/** An array mapping operation names to OperationPage objects */
	public array $operationPages;

	/** Stores the name of the operation parameter */
	public string $operationParam;

	/** The message prefix to be displayed when an invalid operation was specified */
	public string $invalidOperationMessage;

	/**
	 * Constructs a new CRUDPageManager instance.
	 *
	 * @param $operationPages An array mapping operation names to OperationPage objects
	 * @param $invalidOperationMessage The message prefix to be displayed when an invalid operation was specified
	 * @param $operationParam Stores the name of the operation parameter
	 */
	public function __construct(array $operationPages = array(), string $invalidOperationMessage = "Invalid operation:", string $operationParam = "__operation")
	{
		$this->operationPages = $operationPages;
		$this->operationParam = $operationParam;
		$this->invalidOperationMessage = $invalidOperationMessage;

		/* Attach operationParam to the operation pages */
		foreach($this->operationPages as $id => $operationPage)
			$operationPage->operationParam = $operationParam;
	}

	/**
	 * Indicates whether the user has specified an operation parameter.
	 *
	 * @return true if this is the case, else false
	 */
	public function userProvidedOperationParam(): bool
	{
		return array_key_exists($this->operationParam, $_REQUEST);
	}

	/**
	 * Examines the route for a selected operation page.
	 *
	 * @param $application Application layout where the page belongs to
	 * @param $route Route to investigate
	 * @param $index The index of the page to be visited
	 */
	public function examineOperationPageRoute(Application $application, Route $route, int $index): void
	{
		$operation = $_REQUEST[$this->operationParam];

		if(array_key_exists($operation, $this->operationPages))
		{
			$operationPage = $this->operationPages[$operation];
			$operationPage->examineRoute($application, $route, $index);
		}
		else
			throw new BadRequestException($this->invalidOperationMessage." ".$operation);
	}
}
?>
