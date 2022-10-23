<?php
namespace SBCrud\Model\Page\Manager;
use Exception;
use SBData\Model\ParameterMap;
use SBCrud\Model\CRUDPage;
use SBLayout\Model\Page\Content\Contents;

/**
 * Takes care of managing CRUD operations for a specific CRUD page.
 */
class CRUDManager
{
	/** An object mapping the URL keys to parameter values that can be checked for consistency */
	public ParameterMap $keyParameterMap;

	/** The default contents to be displayed in the content sections */
	public Contents $defaultContents;

	/** The contents to be displayed in the content sections in case of an error */
	public Contents $errorContents;

	/** The contents to be displayed when an operation parameter has been set */
	public array $contentsPerOperation;

	/** The message prefix to be displayed when the keys are considered invalid */
	public string $keysInvalidMessage;

	/**
	 * Constructs a new CRUD manager object.
	 *
	 * @param $keyParameterMap An object mapping the URL keys to parameter values that can be checked for consistency
	 * @param $defaultContents The default contents to be displayed in the content sections
	 * @param $errorContents The contents to be displayed in the content sections in case of an error
	 * @param $contentsPerOperation The contents to be displayed when an operation parameter has been set
	 * @param $keysInvalidMessage The message to be displayed when the keys are considered invalid
	 */
	public function __construct(ParameterMap $keyParameterMap, Contents $defaultContents, Contents $errorContents, array $contentsPerOperation, string $keysInvalidMessage)
	{
		$this->keyParameterMap = $keyParameterMap;
		$this->defaultContents = $defaultContents;
		$this->errorContents = $errorContents;
		$this->contentsPerOperation = $contentsPerOperation;
		$this->keysInvalidMessage = $keysInvalidMessage;
	}

	private function selectContents(): Contents
	{
		if(array_key_exists("__operation", $_REQUEST) && array_key_exists($_REQUEST["__operation"], $this->contentsPerOperation))
			return $this->contentsPerOperation[$_REQUEST["__operation"]];
		else
			return $this->defaultContents;
	}

	private function throwError(string $errorMessage): Contents
	{
		$GLOBALS["error"] = $errorMessage;
		return $this->errorContents;
	}

	/**
	 * Resolves the appropriate contents by importing the key values from
	 * the $GLOBALS["query"] array, validating the keys and selecting the
	 * contents that matches the provided $_REQUEST["__operation"]
	 * parameter.
	 *
	 * @param $crudPage Any page implementing CRUD operations
	 * @return The resolved contents object
	 */
	public function resolveContents(CRUDPage $crudPage): Contents
	{
		if(array_key_exists("query", $GLOBALS))
		{
			$this->keyParameterMap->importValues($GLOBALS["query"]);
			$this->keyParameterMap->checkValues();
		}

		if($this->keyParameterMap->checkValid())
		{
			$contents = $this->selectContents();
			global $crudModel;
			$crudModel = $crudPage->constructCRUDModel();

			try
			{
				$crudModel->executeOperation();
				return $contents;
			}
			catch(Exception $ex)
			{
				return $this->throwError($ex->getMessage());
			}
		}
		else
			return $this->throwError($this->keyParameterMap->composeErrorMessage($this->keysInvalidMessage));
	}
}
?>
