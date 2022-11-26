<?php
namespace SBCrud\Model\Page;
use SBLayout\Model\Application;
use SBLayout\Model\Route;
use SBLayout\Model\BadRequestException;
use SBLayout\Model\Page\Page;
use SBLayout\Model\Page\ContentPage;
use SBLayout\Model\Page\Content\Contents;
use SBLayout\Model\PageNotFoundException;
use SBData\Model\ParameterMap;
use SBData\Model\Value\Value;
use SBCrud\Model\Page\Manager\CheckedContentManager;

/**
 * A page that is typically responsible for displaying a collection of data.
 * It can construct a detail page responsible for displaying an individual record
 * belonging to the collection that can be requested by appending a path
 * component to the URL.
 */
class MasterPage extends ContentPage implements CheckedPage
{
	/** Name of the parameter that stores the value of the appended path component */
	public string $param;

	/** Prefix of the message to be displayed when the path parameter is invalid */
	public string $invalidQueryParameterMessage;

	/** Utility object that manages the request parameters */
	public CheckedContentManager $checkedContentManager;

	/**
	 * Constructs a new MasterPage instance.
	 *
	 * @param $title Title of the page that is used as a label in a menu section
	 * @param $param Name of the parameter that stores the value of the appended path component
	 * @param $contents A content object storing properties of the content sections of a page
	 * @param $invalidQueryParameterMessage Prefix of the message to be displayed when the path parameter is invalid
	 */
	public function __construct(string $title, string $param, Contents $contents, string $invalidQueryParameterMessage = "Invalid query parameter:")
	{
		parent::__construct($title, $contents);
		$this->param = $param;
		$this->invalidQueryParameterMessage = $invalidQueryParameterMessage;
		$this->checkedContentManager = new CheckedContentManager($this);
	}

	/**
	 * Constructs a value object that can be used to validate the path component parameter
	 *
	 * @return A value object
	 */
	public function createParamValue(): Value
	{
		return new Value();
	}

	/**
	 * @see CheckedPage#createRequestParameterMap()
	 */
	public function createRequestParameterMap(): ParameterMap
	{
		return new ParameterMap();
	}

	/**
	 * Constructs a detail page.
	 *
	 * @param $query An array storing all path component parameters
	 */
	public function createDetailPage(array $query): ?ContentPage
	{
		return null;
	}

	/**
	 * @see Page::deriveURL()
	 */
	public function deriveURL(string $baseURL, string $id): string
	{
		$baseURLPath = parse_url($baseURL, PHP_URL_PATH);
		return parent::deriveURL($baseURLPath, $id).$this->checkedContentManager->generateRequestParameterString();
	}

	private function checkAndComposeQueryParameter(Route $route, int $index): void
	{
		$currentId = $route->getId($index); // Take the first id of the array

		$value = $this->createParamValue();
		$value->value = $currentId;

		if(!$value->checkValue($this->param))
			throw new BadRequestException($this->invalidQueryParameterMessage." ".$value->value);

		$GLOBALS["query"][$this->param] = $value->value;
	}

	private function constructAndVisitDetailPage(Application $application, Route $route, int $index): void
	{
		$detailPage = $this->createDetailPage($GLOBALS["query"]);

		if($detailPage === null)
			throw new PageNotFoundException();
		else
			$detailPage->examineRoute($application, $route, $index + 1);
	}

	/**
	 * @see Page::examineRoute()
	 */
	public function examineRoute(Application $application, Route $route, int $index = 0): void
	{
		if($route->indexIsAtRequestedPage($index))
		{
			$this->checkedContentManager->exportRequestParameters(true);
			parent::examineRoute($application, $route, $index);
		}
		else
		{
			$this->checkedContentManager->exportRequestParameters(false);
			$this->checkAndComposeQueryParameter($route, $index);
			$route->visitPage($this);
			$this->constructAndVisitDetailPage($application, $route, $index);
		}
	}
}
?>
