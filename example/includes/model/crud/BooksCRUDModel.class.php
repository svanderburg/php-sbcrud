<?php
require_once("data/model/table/DBTable.class.php");
require_once("data/model/field/KeyLinkField.class.php");
require_once("data/model/field/TextField.class.php");
require_once("crud/model/CRUDModel.class.php");
require_once("model/entities/Book.class.php");

class BooksCRUDModel extends CRUDModel
{
	public $dbh;

	public $table = null;

	public function __construct(CRUDPage $crudPage, PDO $dbh)
	{
		parent::__construct($crudPage);
		$this->dbh = $dbh;
	}

	public function executeOperation()
	{
		function composeBookLink(KeyLinkField $field, Form $form)
		{
			return $_SERVER["PHP_SELF"]."/".$field->value;
		}

		$this->table = new DBTable(array(
			"isbn" => new KeyLinkField("ISBN", "composeBookLink", true),
			"Title" => new TextField("Title", true),
			"Author" => new TextField("Author", true)
		));

		/* Compose a statement that queries the persons */
		$this->table->stmt = Book::queryAll($this->dbh);
	}
}
?>
