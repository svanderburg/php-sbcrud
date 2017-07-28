<?php
namespace Example\Model\Page;
use PDO;
use SBCrud\Model\Page\DynamicContentCRUDPage;
use SBLayout\Model\Page\Content\Contents;
use Example\Model\CRUD\BooksCRUDModel;
use Example\Model\CRUD\BookCRUDModel;

class BooksCRUDPage extends DynamicContentCRUDPage
{
	public $dbh;

	public function __construct(PDO $dbh, $dynamicSubPage = null)
	{
		parent::__construct("Books",
			/* Parameter name */
			"isbn",
			/* Key fields */
			array(),
			/* Default contents */
			new Contents("crud/books.php"),
			/* Error contents */
			new Contents("crud/error.php"),
			/* Contents per operation */
			array(
				"create_book" => new Contents("crud/book.php"),
				"insert_book" => new Contents("crud/book.php")
			),
			$dynamicSubPage);

		$this->dbh = $dbh;
	}
	
	public function constructCRUDModel()
	{
		if(array_key_exists("__operation", $_REQUEST))
		{
			switch($_REQUEST["__operation"])
			{
				case "create_book":
				case "insert_book":
					return new BookCRUDModel($this, $this->dbh);
				default:
					return new BooksCRUDModel($this, $this->dbh);
			}
		}
		else
			return new BooksCRUDModel($this, $this->dbh);
	}
}
?>
