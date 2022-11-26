<?php
use Examples\Paged\Model\CRUD\BookCRUDInterface;

global $crudInterface, $dbh, $route, $currentPage;

$crudInterface = new BookCRUDInterface($dbh, $route, $currentPage);
$crudInterface->executeOperation();
?>
