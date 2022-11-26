<?php
use SBData\Model\Form;
use SBData\Model\Table\DBTable;
use SBData\Model\Table\Anchor\AnchorRow;
use SBData\Model\Field\KeyLinkField;
use SBData\Model\Field\TextField;
use Examples\Full\Model\Entity\Book;

global $dbh, $table;

$composeBookLink = function (KeyLinkField $field, Form $form): string
{
	$isbn = $field->exportValue();
	return $_SERVER["PHP_SELF"]."/".rawurlencode($isbn);
};

$deleteBookLink = function (Form $form): string
{
	$isbn = $form->fields["isbn"]->exportValue();
	return $_SERVER["SCRIPT_NAME"]."/books/".rawurlencode($isbn)."?__operation=delete_book".AnchorRow::composeRowParameter($form);
};

$table = new DBTable(array(
	"isbn" => new KeyLinkField("ISBN", $composeBookLink, true),
	"Title" => new TextField("Title", true),
	"Author" => new TextField("Author", true)
), array(
	"Delete" => $deleteBookLink
));

$table->stmt = Book::queryAll($dbh);
?>
