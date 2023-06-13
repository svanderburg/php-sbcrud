<?php
/**
 * @file
 * @brief View-HTML-Pager module
 * @defgroup View-HTML-Pager
 * @{
 */

namespace SBCrud\View\HTML;
use SBCrud\Model\Pager;
use SBCrud\Model\RouteUtils;

/**
 * Displays a navigation bar allowing the user to navigate through pages.
 *
 * @param $pager Pager to display
 */
function displayPagesNavigation(Pager $pager): void
{
	$numOfPages = ($pager->queryFunction)($pager->obj, $pager->pageSize);

	if($numOfPages > 1)
	{
		?>
		<div class="pagesnavigation">
			<?php
			$currentPage = $pager->determineCurrentPage($GLOBALS["requestParameters"]);

			if($currentPage > 0)
			{
				?>
				<a href="<?= RouteUtils::composeSelfURLWithParameters("&amp;", "", array($pager->paramName => $currentPage - 1)) ?>"><?= $pager->previousLabel ?></a>
				<a href="<?= RouteUtils::composeSelfURLWithParameters("&amp;", "", array($pager->paramName => 0)) ?>">0</a>
				<?php
			}
			?>
			<a href="<?= RouteUtils::composeSelfURLWithParameters("&amp;", "", array($pager->paramName => $currentPage)) ?>" class="active_page"><strong><?= $currentPage ?></strong></a>
			<?php

			$lastPage = $numOfPages - 1;

			if($currentPage < $lastPage)
			{
				?>
				<a href="<?= RouteUtils::composeSelfURLWithParameters("&amp;", "", array($pager->paramName => $lastPage)) ?>"><?= $lastPage ?></a>
				<a href="<?= RouteUtils::composeSelfURLWithParameters("&amp;", "", array($pager->paramName => $currentPage + 1)) ?>"><?= $pager->nextLabel ?></a>
				<?php
			}
			?>
		</div>
		<?php
	}
}

/**
 * @}
 */
?>
