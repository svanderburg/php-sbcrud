<?php
namespace Examples\Full\Model\Page;
use PDO;
use SBLayout\Model\PageNotFoundException;
use SBCrud\Model\Page\CRUDDetailPage;
use SBCrud\Model\Page\OperationPage;
use SBCrud\Model\Page\HiddenOperationPage;
use Examples\Full\Model\Entity\Book;
use Examples\Full\Model\Page\Content\BookContents;

class BookPage extends CRUDDetailPage
{
	public array $entity;

	public function __construct(PDO $dbh, string $isbn)
	{
		parent::__construct("Book", new BookContents(), array(
			"update_book" => new HiddenOperationPage("Update book", new BookContents()),
			"delete_book" => new OperationPage("Delete book", new BookContents())
		));

		$stmt = Book::queryOne($dbh, $isbn);
		if(($entity = $stmt->fetch()) === false)
			throw new PageNotFoundException("Cannot find book with ISBN: ".$isbn);

		$this->title = $entity["Title"];
		$this->entity = $entity;
	}
}
?>
