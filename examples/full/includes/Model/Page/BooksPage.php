<?php
namespace Examples\Full\Model\Page;
use PDO;
use SBLayout\Model\Page\ContentPage;
use SBLayout\Model\Page\Content\Contents;
use SBData\Model\Value\Value;
use SBCrud\Model\Page\CRUDMasterPage;
use SBCrud\Model\Page\OperationPage;
use Examples\Full\Model\Page\Content\BookContents;

class BooksPage extends CRUDMasterPage
{
	public PDO $dbh;

	public function __construct(PDO $dbh)
	{
		parent::__construct("Books", "isbn", new Contents("books.php", "books.php"), array(
			"create_book" => new OperationPage("Create book", new BookContents()),
			"insert_book" => new OperationPage("Insert book", new BookContents())
		));
		$this->dbh = $dbh;
	}

	public function createParamValue(): Value
	{
		return new Value(true, 17);
	}

	public function createDetailPage(array $query): ?ContentPage
	{
		return new BookPage($this->dbh, $query["isbn"]);
	}
}
?>
