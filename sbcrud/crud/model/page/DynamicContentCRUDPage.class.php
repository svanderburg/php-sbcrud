<?php
require_once(dirname(__FILE__)."/../CRUDPage.interface.php");
require_once("layout/model/page/DynamicContentPage.class.php");
require_once("layout/model/page/content/Contents.class.php");
require_once("manager/CRUDManager.class.php");

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
	public function lookupSubPage(Page $entryPage, array $ids, $index = 0)
	{
		if($index == count($ids))
			$this->contents = $this->crudManager->resolveContents($this);

		return parent::lookupSubPage($entryPage, $ids, $index);
	}
}
?>
