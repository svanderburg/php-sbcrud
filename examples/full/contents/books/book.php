<?php
global $route, $crudInterface;

\SBLayout\View\HTML\displayBreadcrumbs($route);

\SBData\View\HTML\displayEditableForm($crudInterface->form,
	"Submit",
	"One or more fields are incorrectly specified and marked with a red color!",
	"This field is incorrectly specified!");
?>