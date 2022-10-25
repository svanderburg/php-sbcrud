<?php
namespace Example\Model\CRUD;
use PDO;
use SBCrud\Model\CRUDModel;
use SBCrud\Model\CRUDPage;
use SBData\Model\Form;
use SBData\Model\Field\KeyLinkField;
use SBData\Model\Field\TextField;
use SBData\Model\Table\PagedDBTable;
use SBData\Model\Table\Anchor\AnchorRow;
use Example\Model\Entity\Book;

class BooksCRUDModel extends CRUDModel
{
	public PDO $dbh;

	public ?PagedDBTable $table = null;

	public function __construct(CRUDPage $crudPage, PDO $dbh)
	{
		parent::__construct($crudPage);
		$this->dbh = $dbh;
	}

	public function executeOperation(): void
	{
		function queryNumOfBookPages(PDO $dbh, int $pageSize): int
		{
			return ceil(Book::queryNumOfBooks($dbh) / $pageSize);
		}

		function composeBookLink(KeyLinkField $field, Form $form): string
		{
			$isbn = $field->exportValue();

			return $_SERVER["PHP_SELF"]."/".$isbn."?".http_build_query(array(
				"page" => $form->fields["page"]->exportValue()
			), "", "&amp;", PHP_QUERY_RFC3986);
		}

		function deleteBookLink(Form $form): string
		{
			$isbn = $form->fields["isbn"]->exportValue();

			return $_SERVER["SCRIPT_NAME"]."/books/".$isbn."?".http_build_query(array(
				"__operation" => "delete_book",
				"page" => $form->fields["page"]->exportValue()
			), "", "&amp;", PHP_QUERY_RFC3986).AnchorRow::composeRowParameter($form);
		}

		$pageSize = 10;

		$this->table = new PagedDBTable(array(
			"isbn" => new KeyLinkField("ISBN", __NAMESPACE__.'\\composeBookLink', true),
			"Title" => new TextField("Title", true),
			"Author" => new TextField("Author", true)
		), $this->dbh, $pageSize, __NAMESPACE__."\\queryNumOfBookPages", $this->requestParameterMap, array(
			"Delete" => __NAMESPACE__.'\\deleteBookLink'
		));

		/* Compose a statement that queries the persons */
		$this->table->stmt = Book::queryPage($this->dbh, $this->requestParameterMap->values["page"]->value, $pageSize);
	}
}
?>
