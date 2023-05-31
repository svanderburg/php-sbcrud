<?php
global $table, $route;
\SBLayout\View\HTML\displayBreadcrumbs($route);
\SBCrud\View\HTML\displayOperationToolbar($route);
\SBData\View\HTML\displaySemiEditableTable($table);
?>
