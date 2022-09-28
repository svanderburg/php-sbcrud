<?php
namespace Example\Model\CRUD;
use PDO;
use SBCrud\Model\CRUDModel;
use SBCrud\Model\CRUDPage;
use SBData\Model\Form;
use SBData\Model\Field\KeyLinkField;
use SBData\Model\Field\TextField;
use SBData\Model\Table\DBTable;
use SBData\Model\Table\Anchor\AnchorRow;
use Example\Model\Entity\Book;

class BooksCRUDModel extends CRUDModel
{
	public PDO $dbh;

	public ?DBTable $table = null;

	public function __construct(CRUDPage $crudPage, PDO $dbh)
	{
		parent::__construct($crudPage);
		$this->dbh = $dbh;
	}

	public function executeOperation(): void
	{
		function composeBookLink(KeyLinkField $field, Form $form): string
		{
			$isbn = $field->exportValue();
			return $_SERVER["PHP_SELF"]."/".$isbn;
		}

		function deleteBookLink(Form $form): string
		{
			$isbn = $form->fields["isbn"]->exportValue();
			return $_SERVER["SCRIPT_NAME"]."/books/".$isbn."?__operation=delete_book".AnchorRow::composePreviousRowParameter($form);
		}

		$this->table = new DBTable(array(
			"isbn" => new KeyLinkField("ISBN", __NAMESPACE__.'\\composeBookLink', true),
			"Title" => new TextField("Title", true),
			"Author" => new TextField("Author", true)
		), array(
			"Delete" => __NAMESPACE__.'\\deleteBookLink'
		));

		/* Compose a statement that queries the persons */
		$this->table->stmt = Book::queryAll($this->dbh);
	}
}
?>
