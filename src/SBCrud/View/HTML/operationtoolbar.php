<?php
/**
 * @file
 * @brief View-HTML-OperationToolbar module
 * @defgroup View-HTML-OperationToolbar
 * @{
 */

namespace SBCrud\View\HTML;
use SBLayout\Model\Route;
use SBCrud\Model\Page\CRUDPage;
use SBCrud\Model\Page\Manager\CRUDPageManager;

function generateOperationLinks(CRUDPageManager $crudPageManager, string $baseURL = ""): void
{
	foreach($crudPageManager->operationPages as $id => $operationPage)
	{
		if($operationPage->checkVisibleInMenu())
		{
			$url = $operationPage->deriveURL($baseURL, $id, "&amp;");
			if($operationPage->menuItem === null)
				\SBLayout\View\HTML\displayMenuItem(false, $url, $operationPage);
			else
				\SBLayout\View\HTML\displayCustomMenuItem(false, $url, $operationPage);
		}
	}
}

/**
 * Displays a toolbar with buttons to all visible operation pages of the current page and parent pages
 *
 * @param $route Route from the entry page to current page to be displayed
 * @param $minLevel The minimum level in the route to display operation pages from
 */
function displayOperationToolbar(Route $route, int $minLevel = 0): void
{
	?>
	<p class="operation-toolbar">
		<?php
		$url = $_SERVER["SCRIPT_NAME"];

		for($i = 0; $i < count($route->ids); $i++)
		{
			$currentId = $route->ids[$i];
			$currentPage = $route->pages[$i + 1];
			$url = $currentPage->deriveURL($url, $currentId, "&amp;");

			if($i >= $minLevel)
			{
				if($currentPage instanceof CRUDPage)
					generateOperationLinks($currentPage->crudPageManager, $url);
			}
		}
	?>
	</p>
	<?php
}

/**
 * @}
 */
?>
