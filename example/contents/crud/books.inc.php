<?php
require_once("data/view/html/table.inc.php");
?>
<p>
	<a href="?__operation=create_book">Add book</a>
</p>
<?php
global $crudModel;

displaySemiEditableTable($crudModel->table);
?>
