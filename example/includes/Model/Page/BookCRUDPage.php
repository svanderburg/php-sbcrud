<?php
namespace Example\Model\Page;
use PDO;
use SBCrud\Model\Page\StaticContentCRUDPage;
use SBLayout\Model\Page\Content\Contents;
use SBData\Model\Field\TextField;
use Example\Model\CRUD\BookCRUDModel;

class BookCRUDPage extends StaticContentCRUDPage
{
	public $dbh;

	public function __construct(PDO $dbh, array $subPages = null)
	{
		parent::__construct("Book",
			/* Key fields */
			array(
				"isbn" => new TextField("ISBN", true)
			),
			/* Default contents */
			new Contents("crud/book.php"),
			/* Error contents */
			new Contents("crud/error.php"),
			/* Contents per operation */
			array(),
			$subPages);

		$this->dbh = $dbh;
	}

	public function constructCRUDModel()
	{
		return new BookCRUDModel($this, $this->dbh);
	}
}
?>
