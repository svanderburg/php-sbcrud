<?php
global $table, $route;
\SBLayout\View\HTML\displayBreadcrumbs($route);
?>
<p>
	<a href="?__operation=create_book">Add book</a>
</p>
<?php
\SBData\View\HTML\displaySemiEditableTable($table);
?>
