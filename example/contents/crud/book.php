<?php
$booksURL = $_SERVER["SCRIPT_NAME"]."/books";
global $crudModel;
?>
<p>
	<a href="<?php print($booksURL); ?>?page=<?php print($crudModel->requestParameterMap->values["page"]->value); ?>">&laquo; Books</a> |
	<a href="<?php print($booksURL); ?>?__operation=create_book">Add book</a>
</p>
<?php
global $crudModel;

\SBData\View\HTML\displayEditableForm($crudModel->form,
	"Submit",
	"One or more fields are incorrectly specified and marked with a red color!",
	"This field is incorrectly specified!");
?>
