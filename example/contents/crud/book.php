<?php
$booksURL = $_SERVER["SCRIPT_NAME"]."/books";
global $crudModel;
?>
<p>
	<a href="<?= $booksURL ?>?<?= http_build_query(array("page"=> $crudModel->requestParameterMap->values["page"]->value), "", "&amp;", PHP_QUERY_RFC3986) ?>">&laquo; Books</a> |
	<a href="<?= $booksURL ?>?__operation=create_book">Add book</a>
</p>
<?php
global $crudModel;

\SBData\View\HTML\displayEditableForm($crudModel->form,
	"Submit",
	"One or more fields are incorrectly specified and marked with a red color!",
	"This field is incorrectly specified!");
?>
