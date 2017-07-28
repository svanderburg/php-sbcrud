<?php
namespace SBCrud\Model\Page;
use SBCrud\Model\CRUDPage;
use SBCrud\Model\Page\Manager\CRUDManager;
use SBLayout\Model\Application;
use SBLayout\Model\Page\DynamicContentPage;
use SBLayout\Model\Page\Page;
use SBLayout\Model\Page\Content\Contents;

/**
 * A Dynamic Content CRUD Page that uses its successive path component as a
 * parameter.
 */
abstract class DynamicContentCRUDPage extends DynamicContentPage implements CRUDPage
{
	private $crudManager;

	/**
	 * Constructs a new dynamic content CRUD page object.
	 *
	 * @param string $title Title of the page
	 * @param string $param Name to be given to the parameter
	 * @param array $keyFields Associative array mapping URL parameters to fields that can be used to check them
	 * @param Contents $defaultContents The default contents to be displayed in the content sections
	 * @param Contents $errorContents The contents to be displayed in the content sections in case of an error
	 * @param array $contentsPerOperation The contents to be displayed when an operation parameter has been set
	 * @param Page $dynamicSubPage The dynamic sub page that interprets the URL parameter component
	 * @param string $keysInvalidMessage The message to be displayed when the keys are considered invalid
	 */
	public function __construct($title, $param, array $keyFields, Contents $defaultContents, Contents $errorContents, array $contentsPerOperation = null, Page $dynamicSubPage, $keysInvalidMessage = "The keys are invalid!")
	{
		parent::__construct($title, $param, $errorContents, $dynamicSubPage);
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
	 * @see Page::lookupSubPage()
	 */
	public function lookupSubPage(Application $application, array $ids, $index = 0)
	{
		$subPage = parent::lookupSubPage($application, $ids, $index);

		if($subPage === $this)
			$this->contents = $this->crudManager->resolveContents($this);

		return $subPage;
	}
}
?>
