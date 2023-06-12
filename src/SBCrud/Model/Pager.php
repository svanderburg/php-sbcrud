<?php
namespace SBCrud\Model;
use Closure;

/**
 * Captures the properties of a page that navigates a user through a data
 * collection that is divided into pages of a fixed size.
 */
class Pager
{
	/** An object that represents a collection of data */
	public mixed $obj;

	/** Determines the page size */
	public int $pageSize;

	/** Name of a function that determines the total amount of pages */
	public string|Closure $queryFunction;

	/** Name of the parameter in the parameter map that indicates the page size */
	public string $paramName;

	/** Label of the previous button */
	public string $previousLabel;

	/** Label of the next button */
	public string $nextLabel;

	/**
	 * Constructs a new pager instance.
	 *
	 * @param $obj An object that represents a collection data
	 * @param $pageSize Determines the page size
	 * @param $queryFunction Function that determines the total amount of pages
	 * @param $previousLabel Label of the previous button
	 * @param $nextLabel Label of the next button
	 * @param $paramName Name of the parameter in the parameter map that indicates the page size (defaults to: page)
	 */
	public function __construct(mixed $obj, int $pageSize, string|Closure $queryFunction, string $previousLabel = "&laquo; Previous", string $nextLabel = "Next &raquo;", string $paramName = "page")
	{
		$this->obj = $obj;
		$this->pageSize = $pageSize;
		$this->queryFunction = $queryFunction;
		$this->previousLabel = $previousLabel;
		$this->nextLabel = $nextLabel;
		$this->paramName = $paramName;
	}

	/**
	 * Determines which page is currently selected.
	 *
	 * @param $requestParameters An array containing request parameters, e.g. $_GET/$_POST/$_REQUEST
	 * @return Current page number
	 */
	public function determineCurrentPage(array $requestParameters): int
	{
		if(array_key_exists($this->paramName, $requestParameters))
			return (int)($requestParameters[$this->paramName]);
		else
			return 0;
	}
}
?>
