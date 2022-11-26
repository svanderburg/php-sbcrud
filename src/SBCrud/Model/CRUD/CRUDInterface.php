<?php
namespace SBCrud\Model\CRUD;
use Exception;
use SBLayout\Model\PageException;
use SBLayout\Model\BadRequestException;
use SBCrud\Model\Page\CRUDPage;

/**
 * Provides a uniform interface to expose CRUD operations for a data object.
 */
abstract class CRUDInterface
{
	/** Name of parameter that stores the operation to execute */
	public string $operationParam;

	/**
	 * Constructs a new CRUDInterface instance.
	 *
	 * @param $crudPage CRUDPage that is requested by the user
	 */
	public function __construct(CRUDPage $crudPage)
	{
		$this->operationParam = $crudPage->getOperationParam();
	}

	/**
	 * Decides how to execute a provided CRUD operation
	 *
	 * @param $operation Operation to execute or null for the default operation
	 */
	protected abstract function executeCRUDOperation(?string $operation): void;

	/**
	 * Executes the requested CRUD operation
	 */
	public function executeOperation(): void
	{
		try
		{
			if(array_key_exists($this->operationParam, $_REQUEST))
				$this->executeCRUDOperation($_REQUEST[$this->operationParam]);
			else
				$this->executeCRUDOperation(null);
		}
		catch(PageException $ex)
		{
			throw $ex;
		}
		catch(Exception $ex)
		{
			throw new BadRequestException($ex->getMessage());
		}
	}
}
?>
