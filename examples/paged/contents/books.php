<?php
use SBCrud\Model\RouteUtils;
use SBCrud\Model\Pager;
use Examples\Paged\Model\Entity\Book;

global $dbh, $route, $table, $pageSize;

\SBLayout\View\HTML\displayBreadcrumbs($route);
\SBCrud\View\HTML\displayOperationToolbar($route);

$queryNumOfBookPages = function (PDO $dbh, int $pageSize): int
{
	return ceil(Book::queryNumOfBooks($dbh) / $pageSize);
};

$pager = new Pager($dbh, $pageSize, $queryNumOfBookPages);

\SBCrud\View\HTML\displayPagesNavigation($pager);
\SBData\View\HTML\displaySemiEditableTable($table);
\SBCrud\View\HTML\displayPagesNavigation($pager);
?>
