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

	/** An object mapping request parameter keys to values that can be checked for consistency */
	public ParameterMap $requestParameterMap;

	/** The default contents to be displayed in the content sections */
	public Contents $defaultContents;

	/** The contents to be displayed in the content sections in case of an error */
	public Contents $errorContents;

	/** The contents to be displayed when an operation parameter has been set */
	public array $contentsPerOperation;

	/** The message prefix to be displayed when the keys are considered invalid */
	public string $keysInvalidMessage;

	/** The message prefix to be displayed when the request parameters are considered invalid */
	public string $parametersInvalidMessage;

	/**
	 * Constructs a new CRUD manager object.
	 *
	 * @param $keyParameterMap An object mapping the URL keys to parameter values that can be checked for consistency
	 * @param $requestParameterMap An object mapping request parameter keys to values that can be checked for consistency
	 * @param $defaultContents The default contents to be displayed in the content sections
	 * @param $errorContents The contents to be displayed in the content sections in case of an error
	 * @param $contentsPerOperation The contents to be displayed when an operation parameter has been set
	 * @param $keysInvalidMessage The message to be displayed when the keys are considered invalid
	 * @param $parametersInvalidMessage The message prefix to be displayed when the request parameters are considered invalid
	 */
	public function __construct(ParameterMap $keyParameterMap, ParameterMap $requestParameterMap, Contents $defaultContents, Contents $errorContents, array $contentsPerOperation, string $keysInvalidMessage, string $parametersInvalidMessage)
	{
		$this->keyParameterMap = $keyParameterMap;
		$this->requestParameterMap = $requestParameterMap;
		$this->defaultContents = $defaultContents;
		$this->errorContents = $errorContents;
		$this->contentsPerOperation = $contentsPerOperation;
		$this->keysInvalidMessage = $keysInvalidMessage;
		$this->parametersInvalidMessage = $parametersInvalidMessage;
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
		/* Validate the keys */
		if(array_key_exists("query", $GLOBALS))
		{
			$this->keyParameterMap->importValues($GLOBALS["query"]);
			$this->keyParameterMap->checkValues();

			if(!$this->keyParameterMap->checkValid())
				return $this->throwError($this->keyParameterMap->composeErrorMessage($this->keysInvalidMessage));
		}

		/* Validate the request parameters */
		$this->requestParameterMap->importValues($_REQUEST);
		$this->requestParameterMap->checkValues();

		if(!$this->requestParameterMap->checkValid())
			return $this->throwError($this->requestParameterMap->composeErrorMessage($this->parametersInvalidMessage));

		/* Resolve contents */
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
}
?>
