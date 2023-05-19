<?php
use SBData\Model\ReadOnlyForm;
use SBData\Model\Table\DBTable;
use SBData\Model\Field\KeyLinkField;
use SBData\Model\Field\TextField;
use SBData\Model\Table\PagedDBTable;
use SBCrud\Model\RouteUtils;
use Examples\ReadOnly\Model\Entity\Book;

global $dbh, $table;

$selfURL = RouteUtils::composeSelfURL();

$composeBookLink = function (KeyLinkField $field, ReadOnlyForm $form) use ($selfURL): string
{
	$isbn = $field->exportValue();
	return $selfURL."/".rawurlencode($isbn);
};

$table = new DBTable(array(
	"isbn" => new KeyLinkField("ISBN", $composeBookLink, true),
	"Title" => new TextField("Title", true),
	"Author" => new TextField("Author", true)
));

$table->setStatement(Book::queryAll($dbh));
?>
