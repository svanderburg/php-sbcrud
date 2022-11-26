<?php
namespace Examples\ReadOnly\Model\Page;
use PDO;
use SBLayout\Model\PageNotFoundException;
use SBLayout\Model\Page\Content\Contents;
use SBCrud\Model\Page\DetailPage;
use Examples\ReadOnly\Model\Entity\Book;

class BookPage extends DetailPage
{
	public array $entity;

	public function __construct(PDO $dbh, string $isbn)
	{
		parent::__construct("Book", new Contents("books/book.php", "books/book.php"));

		$stmt = Book::queryOne($dbh, $isbn);
		if(($entity = $stmt->fetch()) === false)
			throw new PageNotFoundException("Cannot find book with ISBN: ".$isbn);

		$this->title = $entity["Title"];
		$this->entity = $entity;
	}
}
?>
