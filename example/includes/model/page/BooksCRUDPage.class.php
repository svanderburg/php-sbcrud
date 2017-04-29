<?php
require_once("crud/model/page/DynamicContentCRUDPage.class.php");
require_once(dirname(__FILE__)."/../crud/BooksCRUDModel.class.php");
require_once(dirname(__FILE__)."/../crud/BookCRUDModel.class.php");

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
			new Contents("crud/books.inc.php"),
			/* Error contents */
			new Contents("crud/error.inc.php"),
			/* Contents per operation */
			array(
				"create_book" => new Contents("crud/book.inc.php"),
				"insert_book" => new Contents("crud/book.inc.php")
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
