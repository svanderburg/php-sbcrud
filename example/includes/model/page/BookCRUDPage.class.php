<?php
require_once("crud/model/page/StaticContentCRUDPage.class.php");
require_once(dirname(__FILE__)."/../crud/BookCRUDModel.class.php");

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
			new Contents("crud/book.inc.php"),
			/* Error contents */
			new Contents("crud/error.inc.php"),
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
