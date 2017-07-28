<?php
namespace Example\Model\CRUD;
use Exception;
use PDO;
use SBCrud\Model\CRUDModel;
use SBCrud\Model\CRUDPage;
use SBData\Model\Form;
use SBData\Model\Field\HiddenField;
use SBData\Model\Field\TextField;
use Example\Model\Entity\Book;

class BookCRUDModel extends CRUDModel
{
	public $dbh;

	public $form = null;

	public function __construct(CRUDPage $crudPage, PDO $dbh)
	{
		parent::__construct($crudPage);
		$this->dbh = $dbh;
	}

	private function constructBookForm()
	{
		$this->form = new Form(array(
			"__operation" => new HiddenField(true),
			"isbn" => new TextField("ISBN", true, 20),
			"Title" => new TextField("Title", true, 40),
			"Author" => new TextField("Author", true, 40)
		));
	}
	
	private function createBook()
	{
		$this->constructBookForm();

		$row = array(
			"__operation" => "insert_book"
		);
		$this->form->importValues($row);
	}

	private function insertBook()
	{
		$this->constructBookForm();
		$this->form->importValues($_REQUEST);
		$this->form->checkFields();

		if($this->form->checkValid())
		{
			$book = $this->form->exportValues();
			Book::insert($this->dbh, $book);
			header("Location: ".$_SERVER["SCRIPT_NAME"]."/books/".$book['isbn']);
			exit();
		}
	}

	private function viewBook()
	{
		$this->constructBookForm();

		$stmt = Book::queryOne($this->dbh, $this->keyFields['isbn']->value);

		if(($row = $stmt->fetch()) === false)
		{
			header("HTTP/1.1 404 Not Found");
			throw new Exception("Cannot find book with this ISBN number!");
		}
		else
		{
			$row['__operation'] = "update_book";
			$this->form->importValues($row);
		}
	}

	private function updateBook()
	{
		$this->constructBookForm();
		$this->form->importValues($_REQUEST);
		$this->form->checkFields();

		if($this->form->checkValid())
		{
			$book = $this->form->exportValues();
			Book::update($this->dbh, $book, $this->keyFields['isbn']->value);
			header("Location: ".$_SERVER["SCRIPT_NAME"]."/books/".$book['isbn']);
			exit();
		}
	}

	private function deleteBook()
	{
		Book::remove($this->dbh, $this->keyFields['isbn']->value);
		header("Location: ".$_SERVER['HTTP_REFERER']);
		exit();
	}

	public function executeOperation()
	{
		if(array_key_exists("__operation", $_REQUEST))
		{
			switch($_REQUEST["__operation"])
			{
				case "create_book":
					$this->createBook();
					break;
				case "insert_book":
					$this->insertBook();
					break;
				case "update_book":
					$this->updateBook();
					break;
				case "delete_book":
					$this->deleteBook();
					break;
				default:
					$this->viewBook();
			}
		}
		else
			$this->viewBook();
	}
}
?>
