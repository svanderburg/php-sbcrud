<?php
use SBCrud\Model\RouteUtils;
?>
<p>
	<a href="<?= RouteUtils::composeSelfURLWithParameters("&amp;", "", array("__operation" => "create_book")) ?>">Add book</a>
</p>
<?php
global $route, $table, $requestParameters;

\SBLayout\View\HTML\displayBreadcrumbs($route);
\SBData\View\HTML\displaySemiEditablePagedDBTable($table, $requestParameters);
?>
