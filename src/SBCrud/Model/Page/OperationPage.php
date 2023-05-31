<?php
namespace SBCrud\Model\Page;
use SBLayout\Model\Application;
use SBLayout\Model\Route;
use SBLayout\Model\Page\ContentPage;
use SBLayout\Model\Page\Content\Contents;
use SBData\Model\ParameterMap;
use SBCrud\Model\Page\Manager\CheckedContentManager;

/**
 * A page that exposes a CRUD operation to the user.
 */
class OperationPage extends ContentPage implements CheckedPage, OperationParamPage
{
	/** Stores the name of the operation parameter */
	public string $operationParam;

	/** A utility object that manages CRUD pages */
	public CheckedContentManager $checkedContentManager;

	/**
	 * Constructs a new OperationPage instance.
	 *
	 * @param $title Title of the page that is used as a label in a menu section
	 * @param $contents A content object storing properties of the content sections of a page
	 * @param $operationParam Stores the name of the operation parameter
	 * @param $menuItem PHP file that renders the menu item. Leaving it null just renders a hyperlink
	 */
	public function __construct(string $title, Contents $contents, string $operationParam = "__operation", string $menuItem = null)
	{
		parent::__construct($title, $contents, $menuItem);
		$this->operationParam = $operationParam;
		$this->checkedContentManager = new CheckedContentManager($this);
	}

	/**
	 * @see Page::deriveURL()
	 */
	function deriveURL(string $baseURL, string $id): string
	{
		if(str_contains($baseURL, "?"))
			return $baseURL."&amp;".$this->operationParam."=".rawurlencode($id);
		else
			return $baseURL."?".$this->operationParam."=".rawurlencode($id);
	}

	/**
	 * @see CheckedPage#createRequestParameterMap()
	 */
	public function createRequestParameterMap(): ParameterMap
	{
		return new ParameterMap();
	}

	/**
	 * @see OperationParamPage#getOperationParam()
	 */
	public function getOperationParam(): string
	{
		return $this->operationParam;
	}

	/**
	 * @see Page::examineRoute()
	 */
	public function examineRoute(Application $application, Route $route, int $index = 0): void
	{
		parent::examineRoute($application, $route, $index);
		$this->checkedContentManager->exportRequestParameters(false);
		header("X-Robots-Tag: noindex, nofollow"); // Operation pages are never supposed to be indexed by search engines
	}
}
?>
