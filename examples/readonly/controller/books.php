<?php
use SBData\Model\Form;
use SBData\Model\Table\DBTable;
use SBData\Model\Field\KeyLinkField;
use SBData\Model\Field\TextField;
use SBData\Model\Table\PagedDBTable;
use Examples\ReadOnly\Model\Entity\Book;

global $dbh, $table;

$composeBookLink = function (KeyLinkField $field, Form $form): string
{
	$isbn = $field->exportValue();
	return $_SERVER["PHP_SELF"]."/".rawurlencode($isbn);
};

$table = new DBTable(array(
	"isbn" => new KeyLinkField("ISBN", $composeBookLink, true),
	"Title" => new TextField("Title", true),
	"Author" => new TextField("Author", true)
));

$table->stmt = Book::queryAll($dbh);
?>
