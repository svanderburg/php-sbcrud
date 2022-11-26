<p>
	<a href="?__operation=create_book">Add book</a>
</p>
<?php
global $table, $route;

\SBLayout\View\HTML\displayBreadcrumbs($route);
\SBData\View\HTML\displaySemiEditableTable($table);
?>
