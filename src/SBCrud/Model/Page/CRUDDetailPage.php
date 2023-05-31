<?php
namespace SBCrud\Model\Page;
use SBLayout\Model\Application;
use SBLayout\Model\Route;
use SBLayout\Model\Page\Content\Contents;
use SBCrud\Model\Page\Manager\CRUDPageManager;

/**
 * A page that is typically responsible for displaying an individual data record
 * and exposes CRUD operation allowing the user to manage the data.
 */
class CRUDDetailPage extends DetailPage implements OperationParamPage, CRUDPage
{
	/** A utility object that manages CRUD pages */
	public CRUDPageManager $crudPageManager;

	/**
	 * Constructs a new CRUDDetailPage instance.
	 *
	 * @param $defaultTitle Title of the default page that is used as a label in a menu section
	 * @param $defaultContents A content object storing properties of the content sections of the default page
	 * @param $operationPages An array mapping operation names to OperationPage objects
	 * @param $subPages An associative array mapping ids to sub pages
	 * @param $invalidOperationMessage The message prefix to be displayed when an invalid operation was specified
	 * @param $operationParam Stores the name of the operation parameter
	 * @param $menuItem PHP file that renders the menu item. Leaving it null just renders a hyperlink
	 */
	public function __construct(string $defaultTitle, Contents $defaultContents, array $operationPages = array(), array $subPages = array(), string $invalidOperationMessage = "Invalid operation:", string $operationParam = "__operation", string $menuItem = null)
	{
		parent::__construct($defaultTitle, $defaultContents, $subPages, $menuItem);
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
	 * @see OperationParamPage#getOperationParam()
	 */
	public function getOperationParam(): string
	{
		return $this->crudPageManager->operationParam;
	}
}
?>
