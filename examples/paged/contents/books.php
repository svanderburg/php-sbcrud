<?php
use SBCrud\Model\RouteUtils;
global $route, $table, $requestParameters;

\SBLayout\View\HTML\displayBreadcrumbs($route);
?>
<p>
	<a href="<?= RouteUtils::composeSelfURLWithParameters("&amp;", "", array("__operation" => "create_book")) ?>">Add book</a>
</p>
<?php

\SBData\View\HTML\displaySemiEditablePagedDBTable($table, $requestParameters);
?>
