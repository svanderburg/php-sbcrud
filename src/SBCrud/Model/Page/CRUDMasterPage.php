<?php
namespace SBCrud\Model\Page;
use SBLayout\Model\Application;
use SBLayout\Model\Route;
use SBLayout\Model\Page\Content\Contents;
use SBCrud\Model\Page\Manager\CRUDPageManager;

/**
 * A page that is typically responsible for displaying a collection of data and
 * exposes CRUD operations allowing a user to manage the data.
 * It can construct a detail page responsible for displaying an individual record
 * belonging to the collection that can be requested by appending a path
 * component to the URL.
 */
class CRUDMasterPage extends MasterPage implements CRUDPage
{
	/** A utility object that manages CRUD pages */
	public CRUDPageManager $crudPageManager;

	/**
	 * Constructs a new CRUDMasterPage instance.
	 *
	 * @param $defaultTitle Title of the default page that is used as a label in a menu section
	 * @param $param Name of the parameter that stores the value of the appended path component
	 * @param $defaultContents A content object storing properties of the content sections of the default page
	 * @param $operationPages An array mapping operation names to OperationPage objects
	 * @param $invalidOperationMessage The message prefix to be displayed when an invalid operation was specified
	 * @param $operationParam Stores the name of the operation parameter
	 */
	public function __construct(string $defaultTitle, string $param, Contents $defaultContents, array $operationPages = array(), string $invalidOperationMessage = "Invalid operation:", string $operationParam = "__operation")
	{
		parent::__construct($defaultTitle, $param, $defaultContents);
		$this->crudPageManager = new CRUDPageManager($operationPages, $invalidOperationMessage, $operationParam);
	}

	/**
	 * @see Page::examineRoute()
	 */
	public function examineRoute(Application $application, Route $route, int $index = 0): void
	{
		if(!$route->indexIsAtRequestedPage($index) || !$this->crudPageManager->userProvidedOperationParam())
			parent::examineRoute($application, $route, $index);
		else
		{
			$route->visitPage($this);
			$this->checkedContentManager->exportRequestParameters(false);
			$this->crudPageManager->examineOperationPageRoute($application, $route, $index);
		}
	}

	/**
	 * @see CRUDPage#getOperationParam()
	 */
	public function getOperationParam(): string
	{
		return $this->crudPageManager->operationParam;
	}
}
?>