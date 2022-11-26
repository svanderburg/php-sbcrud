<?php
use Examples\Full\Model\CRUD\BookCRUDInterface;

global $crudInterface, $dbh, $route, $currentPage;

$crudInterface = new BookCRUDInterface($dbh, $route, $currentPage);
$crudInterface->executeOperation();
?>
