<?php
namespace SBCrud\Model;
use SBData\Model\Form;
use SBData\Model\Label;
use SBData\Model\Field\HiddenField;

/**
 * A wrapped Form that makes it convenient to specify the CRUD operation that needs to be executed to process the user input
 */
class CRUDForm extends Form
{
	/** Name of parameter that stores the operation to execute */
	public string $operationParam;

	/**
	 * Constructs a new CRUDForm instance.
	 *
	 * @param $fields An associative array mapping field names to fields that should be checked and displayed
	 * @param $operationParam Name of parameter that stores the operation to execute
	 * @param $actionURL Action URL where the user gets redirected to (defaults to same page)
	 * @param $submitLabel Label to be displayed on the submit button
	 * @param $validationErrorMessage Error message displayed on form level when a field is invalid
	 * @param $fieldErrorMessage Error message displayed for an invalid field
	 */
	public function __construct(array $fields, string $operationParam = "__operation", string $actionURL = null, Label $submitLabel = null, string $validationErrorMessage = "One or more fields are invalid and marked with a red color", string $fieldErrorMessage = "This value is incorrect!")
	{
		parent::__construct($fields, $actionURL, $submitLabel, $validationErrorMessage, $fieldErrorMessage);
		$this->operationParam = $operationParam;

		// Add a hidden field for the operation parameter
		$this->fields[$this->operationParam] = new HiddenField(true);
	}

	/**
	 * Configures the form to execute a certain CRUD operation.
	 *
	 * @param $operation CRUD operation to execute.
	 */
	public function setOperation(string $operation): void
	{
		$this->fields[$this->operationParam]->importValue($operation);
	}
}
?>
