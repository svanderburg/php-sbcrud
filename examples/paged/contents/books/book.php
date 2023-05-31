<?php
global $route, $crudInterface;

\SBLayout\View\HTML\displayBreadcrumbs($route);
\SBCrud\View\HTML\displayOperationToolbar($route);
\SBData\View\HTML\displayEditableForm($crudInterface->form);
?>
