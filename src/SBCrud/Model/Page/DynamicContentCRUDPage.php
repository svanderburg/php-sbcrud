<?php
namespace SBCrud\Model\Page;
use SBData\Model\ParameterMap;
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
	 * @param $keyParameterMap An object mapping the URL keys to parameter values that can be checked for consistency
	 * @param $requestParameterMap An object mapping request parameter keys to values that can be checked for consistency
	 * @param $defaultContents The default contents to be displayed in the content sections
	 * @param $errorContents The contents to be displayed in the content sections in case of an error
	 * @param $contentsPerOperation The contents to be displayed when an operation parameter has been set
	 * @param $dynamicSubPage The dynamic sub page that interprets the URL parameter component
	 * @param $keysInvalidMessage The message to be displayed when the keys are considered invalid
	 * @param $parametersInvalidMessage The message to be displayed when the request parameters are considered invalid
	 */
	public function __construct(string $title, string $param, ParameterMap $keyParameterMap, ParameterMap $requestParameterMap, Contents $defaultContents, Contents $errorContents, array $contentsPerOperation = null, Page $dynamicSubPage, string $keysInvalidMessage = "The following keys are invalid:", string $parametersInvalidMessage = "The following parameters are invalid:")
	{
		parent::__construct($title, $param, $errorContents, $dynamicSubPage);
		$this->crudManager = new CRUDManager($keyParameterMap, $requestParameterMap, $defaultContents, $errorContents, $contentsPerOperation, $keysInvalidMessage, $parametersInvalidMessage);
	}

	/**
	 * @see CRUDPage::constructCRUDModel()
	 */
	public abstract function constructCRUDModel(): CRUDModel;

	/**
	 * @see CRUDPage::getKeyParameterMap()
	 */
	public function getKeyParameterMap(): ParameterMap
	{
		return $this->crudManager->keyParameterMap;
	}

	/**
	 * @see CRUDPage::getRequestParameterMap()
	 */
	public function getRequestParameterMap(): ParameterMap
	{
		return $this->crudManager->requestParameterMap;
	}

	public function emitCanonicalHeader(): void
	{
		$this->crudManager->emitCanonicalHeader();
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
