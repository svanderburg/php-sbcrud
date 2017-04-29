<?php
require_once("data/view/html/table.inc.php");
?>
<p>
	<a href="?__operation=create_book">Add book</a>
</p>
<?php
function deleteBookLink(Form $form)
{
	return $_SERVER["SCRIPT_NAME"]."/books/".$form->fields["isbn"]->value."?__operation=delete_book";
}

global $crudModel;

displayTable($crudModel->table, "deleteBookLink");
?>
