<?php
namespace Examples\Full\Model\CRUD;
use PDO;
use SBLayout\Model\Route;
use SBLayout\Model\Page\ContentPage;
use SBData\Model\Field\TextField;
use SBData\Model\Field\HiddenField;
use SBData\Model\Table\Anchor\AnchorRow;
use SBCrud\Model\RouteUtils;
use SBCrud\Model\CRUDForm;
use SBCrud\Model\CRUD\CRUDInterface;
use SBCrud\Model\Page\OperationParamPage;
use Examples\Full\Model\Entity\Book;

class BookCRUDInterface extends CRUDInterface
{
	public PDO $dbh;

	public Route $route;

	public OperationParamPage $currentPage;

	public CRUDForm $form;

	public function __construct(PDO $dbh, Route $route, OperationParamPage $currentPage)
	{
		parent::__construct($currentPage);
		$this->dbh = $dbh;
		$this->route = $route;
		$this->currentPage = $currentPage;
	}

	private function constructForm(): CRUDForm
	{
		return new CRUDForm(array(
			"isbn" => new TextField("ISBN", true, 20),
			"Title" => new TextField("Title", true, 40),
			"Author" => new TextField("Author", true, 40)
		), $this->operationParam);
	}

	private function viewBook(): void
	{
		$this->form = $this->constructForm();
		$this->form->importValues($this->currentPage->entity);
		$this->form->setOperation("update_book");
	}

	private function createBook(): void
	{
		$this->form = $this->constructForm();
		$this->form->setOperation("insert_book");
	}

	private function insertBook(): void
	{
		$this->form = $this->constructForm();
		$this->form->importValues($_REQUEST);
		$this->form->checkFields();

		if($this->form->checkValid())
		{
			$book = $this->form->exportValues();
			Book::insert($this->dbh, $book);

			header("Location: ".RouteUtils::composeSelfURL()."/".rawurlencode($book['isbn']));
			exit();
		}
	}

	private function updateBook(): void
	{
		$this->form = $this->constructForm();
		$this->form->importValues($_REQUEST);
		$this->form->checkFields();

		if($this->form->checkValid())
		{
			$book = $this->form->exportValues();
			$isbn = $GLOBALS["query"]["isbn"];
			Book::update($this->dbh, $book, $isbn);

			header("Location: ".$this->route->composeParentPageURL($_SERVER["SCRIPT_NAME"])."/".rawurlencode($book['isbn']));
			exit();
		}
	}

	private function deleteBook(): void
	{
		$isbn = $GLOBALS["query"]["isbn"];
		Book::remove($this->dbh, $isbn);
		header("Location: ".$this->route->composeParentPageURL($_SERVER["SCRIPT_NAME"]).AnchorRow::composePreviousRowFragment());
		exit();
	}

	protected function executeCRUDOperation(?string $operation): void
	{
		if($operation === null)
			$this->viewBook();
		else
		{
			switch($operation)
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
			}
		}
	}
}
?>
