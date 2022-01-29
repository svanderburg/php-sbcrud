<?php
namespace SBCrud\Model\Page;
use SBCrud\Model\CRUDPage;
use SBCrud\Model\Page\Manager\CRUDManager;
use SBLayout\Model\Application;
use SBLayout\Model\Route;
use SBLayout\Model\Page\Page;
use SBLayout\Model\Page\StaticContentPage;
use SBLayout\Model\Page\Content\Contents;

/**
 * A static content page that implements CRUD operations.
 */
abstract class StaticContentCRUDPage extends StaticContentPage implements CRUDPage
{
	private $crudManager;

	/**
	 * Constructs a new static content CRUD page object.
	 *
	 * @param string $title Title of the page
	 * @param array $keyFields Associative array mapping URL parameters to fields that can be used to check them
	 * @param Contents $defaultContents The default contents to be displayed in the content sections
	 * @param Contents $errorContents The contents to be displayed in the content sections in case of an error
	 * @param array $contentsPerOperation The contents to be displayed when an operation parameter has been set
	 * @param array $subPages An associative array mapping ids to sub pages
	 * @param string $keysInvalidMessage The message to be displayed when the keys are considered invalid
	 */
	public function __construct($title, array $keyFields, Contents $defaultContents, Contents $errorContents, array $contentsPerOperation, array $subPages = null, $keysInvalidMessage = "The keys are invalid!")
	{
		parent::__construct($title, $errorContents, $subPages);
		$this->crudManager = new CRUDManager($keyFields, $defaultContents, $errorContents, $contentsPerOperation, $keysInvalidMessage);
	}

	/**
	 * @see CRUDPage::constructCRUDModel()
	 */
	public abstract function constructCRUDModel();

	/**
	 * @see CRUDPage::getKeyFields()
	 */
	public function getKeyFields()
	{
		return $this->crudManager->keyFields;
	}

	/**
	 * @see Page::examineRoute()
	 */
	public function examineRoute(Application $application, Route $route, $index = 0)
	{
		parent::examineRoute($application, $route, $index);

		if($route->determineCurrentPage() === $this)
			$this->contents = $this->crudManager->resolveContents($this);
	}
}
?>
