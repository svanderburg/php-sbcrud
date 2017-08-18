<p>
	<a href="?__operation=create_book">Add book</a>
</p>
<?php
global $crudModel;

\SBData\View\HTML\displaySemiEditableTable($crudModel->table, true);
?>
