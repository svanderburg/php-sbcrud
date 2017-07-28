<?php
namespace Example\Model\CRUD;
use PDO;
use SBCrud\Model\CRUDModel;
use SBCrud\Model\CRUDPage;
use SBData\Model\Form;
use SBData\Model\Field\KeyLinkField;
use SBData\Model\Field\TextField;
use SBData\Model\Table\DBTable;
use Example\Model\Entity\Book;

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

		function deleteBookLink(Form $form)
		{
			return $_SERVER["SCRIPT_NAME"]."/books/".$form->fields["isbn"]->value."?__operation=delete_book";
		}

		$this->table = new DBTable(array(
			"isbn" => new KeyLinkField("ISBN", '\Example\Model\CRUD\composeBookLink', true),
			"Title" => new TextField("Title", true),
			"Author" => new TextField("Author", true)
		), array(
			"Delete" => '\Example\Model\CRUD\deleteBookLink'
		));

		/* Compose a statement that queries the persons */
		$this->table->stmt = Book::queryAll($this->dbh);
	}
}
?>
