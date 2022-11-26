<?php
namespace SBCrud\Model\Page;
use SBLayout\Model\Application;
use SBLayout\Model\Route;
use SBLayout\Model\Page\StaticContentPage;
use SBLayout\Model\Page\Content\Contents;
use SBData\Model\ParameterMap;
use SBCrud\Model\Page\Manager\CheckedContentManager;

/**
 * A page that is typically responsible for displaying an individual data record.
 */
class DetailPage extends StaticContentPage implements CheckedPage
{
	/** Utility object that manages the request parameters */
	public CheckedContentManager $checkedContentManager;

	/**
	 * Constructs a new DetailPage instance.
	 *
	 * @param $title Title of the page that is used as a label in a menu section
	 * @param $contents A content object storing properties of the content sections of a page
	 * @param $subPages An associative array mapping ids to sub pages
	 */
	public function __construct(string $title, Contents $contents, array $subPages = array())
	{
		parent::__construct($title, $contents, $subPages);
		$this->checkedContentManager = new CheckedContentManager($this);
	}

	/**
	 * @see CheckedPage#createRequestParameterMap()
	 */
	public function createRequestParameterMap(): ParameterMap
	{
		return new ParameterMap();
	}

	/**
	 * @see Page::deriveURL()
	 */
	public function deriveURL(string $baseURL, string $id): string
	{
		$baseURLPath = parse_url($baseURL, PHP_URL_PATH);
		return parent::deriveURL($baseURLPath, $id).$this->checkedContentManager->generateRequestParameterString();
	}

	/**
	 * @see Page::examineRoute()
	 */
	public function examineRoute(Application $application, Route $route, int $index = 0): void
	{
		parent::examineRoute($application, $route, $index);

		$emitHeader = $route->indexIsAtRequestedPage($index);
		$this->checkedContentManager->exportRequestParameters($emitHeader);
	}
}
?>
