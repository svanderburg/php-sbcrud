<?php
namespace SBCrud\Model\Page;
use SBData\Model\ParameterMap;
use SBCrud\Model\CRUDModel;
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
	private CRUDManager $crudManager;

	/**
	 * Constructs a new static content CRUD page object.
	 *
	 * @param $title Title of the page
	 * @param $keyParameterMap An object mapping the URL keys to parameter values that can be checked for consistency
	 * @param $requestParameterMap An object mapping request parameter keys to values that can be checked for consistency
	 * @param $defaultContents The default contents to be displayed in the content sections
	 * @param $errorContents The contents to be displayed in the content sections in case of an error
	 * @param $contentsPerOperation The contents to be displayed when an operation parameter has been set
	 * @param $subPages An associative array mapping ids to sub pages
	 * @param $keysInvalidMessage The message to be displayed when the keys are considered invalid
	 * @param $parametersInvalidMessage The message to be displayed when the request parameters are considered invalid
	 */
	public function __construct(string $title, ParameterMap $keyParameterMap, ParameterMap $requestParameterMap, Contents $defaultContents, Contents $errorContents, array $contentsPerOperation, array $subPages = array(), string $keysInvalidMessage = "The following keys are invalid:", string $parametersInvalidMessage = "The following parameters are invalid:")
	{
		parent::__construct($title, $errorContents, $subPages);
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

	/**
	 * @see CRUDPage::emitCanonicalHeader()
	 */
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
