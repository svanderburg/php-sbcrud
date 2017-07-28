<?php
namespace SBCrud\Model\Page\Manager;
use Exception;
use SBCrud\Model\CRUDPage;
use SBLayout\Model\Page\Content\Contents;

/**
 * Takes care of managing CRUD operations for a specific CRUD page.
 */
class CRUDManager
{
	/** Associative array mapping URL parameters to fields that can be used to check them */
	public $keyFields;

	/** Indicates true if the key values are valid, else false */
	public $validKeys;

	/** The default contents to be displayed in the content sections */
	public $defaultContents;

	/** The contents to be displayed in the content sections in case of an error */
	public $errorContents;

	/** The contents to be displayed when an operation parameter has been set */
	public $contentsPerOperation;

	/** The message to be displayed when the keys are considered invalid */
	public $keysInvalidMessage;

	/**
	 * Constructs a new CRUD manager object.
	 *
	 * @param array $keyFields Associative array mapping URL parameters to fields that can be used to check them
	 * @param Contents $defaultContents The default contents to be displayed in the content sections
	 * @param Contents $errorContents The contents to be displayed in the content sections in case of an error
	 * @param array $contentsPerOperation The contents to be displayed when an operation parameter has been set
	 * @param string $keysInvalidMessage The message to be displayed when the keys are considered invalid
	 */
	public function __construct(array $keyFields, Contents $defaultContents, Contents $errorContents, array $contentsPerOperation, $keysInvalidMessage)
	{
		$this->keyFields = $keyFields;
		$this->defaultContents = $defaultContents;
		$this->errorContents = $errorContents;
		$this->contentsPerOperation = $contentsPerOperation;
		$this->validKeys = true;
		$this->keysInvalidMessage = $keysInvalidMessage;
	}

	private function importKeyValues(array $values)
	{
		foreach($values as $key => $value)
			$this->keyFields[$key]->value = $value;
	}

	private function checkKeyFields()
	{
		foreach($this->keyFields as $key => $field)
		{
			if(!$field->checkField($key))
			{
				$this->validKeys = false;
				break;
			}
		}
	}

	private function selectContents()
	{
		if(array_key_exists("__operation", $_REQUEST) && array_key_exists($_REQUEST["__operation"], $this->contentsPerOperation))
			return $this->contentsPerOperation[$_REQUEST["__operation"]];
		else
			return $this->defaultContents;
	}

	private function throwError($errorMessage)
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
	 * @param CRUDPage $crudPage Any page implementing CRUD operations
	 * @return Contents The resolved contents object
	 */
	public function resolveContents(CRUDPage $crudPage)
	{
		if(array_key_exists("query", $GLOBALS))
		{
			$this->importKeyValues($GLOBALS["query"]);
			$this->checkKeyFields();
		}

		if($this->validKeys)
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
			return $this->throwError($this->keysInvalidMessage);
	}
}
?>
