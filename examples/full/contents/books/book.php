<?php
global $route, $crudInterface;

\SBLayout\View\HTML\displayBreadcrumbs($route);
\SBData\View\HTML\displayEditableForm($crudInterface->form);
?>
