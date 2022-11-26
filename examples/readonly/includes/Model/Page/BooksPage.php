<?php
namespace Examples\ReadOnly\Model\Page;
use PDO;
use SBLayout\Model\Page\Content\Contents;
use SBLayout\Model\Page\ContentPage;
use SBData\Model\Value\Value;
use SBCrud\Model\Page\MasterPage;

class BooksPage extends MasterPage
{
	public PDO $dbh;

	public function __construct(PDO $dbh)
	{
		parent::__construct("Books", "isbn", new Contents("books.php", "books.php"));
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
