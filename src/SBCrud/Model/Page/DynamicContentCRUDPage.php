<?php
namespace SBCrud\Model\Page;
use SBCrud\Model\CRUDModel;
use SBCrud\Model\CRUDPage;
use SBCrud\Model\Page\Manager\CRUDManager;
use SBLayout\Model\Application;
use SBLayout\Model\Route;
use SBLayout\Model\Page\DynamicContentPage;
use SBLayout\Model\Page\Page;
use SBLayout\Model\Page\Content\Contents;

/**
 * A Dynamic Content CRUD Page that uses its successive path component as a
 * parameter.
 */
abstract class DynamicContentCRUDPage extends DynamicContentPage implements CRUDPage
{
	private CRUDManager $crudManager;

	/**
	 * Constructs a new dynamic content CRUD page object.
	 *
	 * @param $title Title of the page
	 * @param $param Name to be given to the parameter
	 * @param $keyFields Associative array mapping URL parameters to fields that can be used to check them
	 * @param $defaultContents The default contents to be displayed in the content sections
	 * @param $errorContents The contents to be displayed in the content sections in case of an error
	 * @param $contentsPerOperation The contents to be displayed when an operation parameter has been set
	 * @param $dynamicSubPage The dynamic sub page that interprets the URL parameter component
	 * @param $keysInvalidMessage The message to be displayed when the keys are considered invalid
	 */
	public function __construct(string $title, string $param, array $keyFields, Contents $defaultContents, Contents $errorContents, array $contentsPerOperation = null, Page $dynamicSubPage, string $keysInvalidMessage = "The keys are invalid!")
	{
		parent::__construct($title, $param, $errorContents, $dynamicSubPage);
		$this->crudManager = new CRUDManager($keyFields, $defaultContents, $errorContents, $contentsPerOperation, $keysInvalidMessage);
	}

	/**
	 * @see CRUDPage::constructCRUDModel()
	 */
	public abstract function constructCRUDModel(): CRUDModel;

	/**
	 * @see CRUDPage::getKeyFields()
	 */
	public function getKeyFields(): array
	{
		return $this->crudManager->keyFields;
	}

	/**
	 * @see Page::examineRoute()
	 */
	public function examineRoute(Application $application, Route $route, int $index = 0): void
	{
		parent::examineRoute($application, $route, $index);

		if($route->determineCurrentPage() === $this)
			$this->contents = $this->crudManager->resolveContents($this);
	}
}
?>
