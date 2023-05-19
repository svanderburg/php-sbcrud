<?php
use SBData\Model\ReadOnlyForm;
use SBData\Model\Table\DBTable;
use SBData\Model\Table\Action;
use SBData\Model\Table\Anchor\AnchorRow;
use SBData\Model\Field\KeyLinkField;
use SBData\Model\Field\TextField;
use SBCrud\Model\RouteUtils;
use Examples\Full\Model\Entity\Book;

global $dbh, $table;

$selfURL = RouteUtils::composeSelfURL();

$composeBookLink = function (KeyLinkField $field, ReadOnlyForm $form) use ($selfURL): string
{
	$isbn = $field->exportValue();
	return $selfURL."/".rawurlencode($isbn);
};

$deleteBookLink = function (ReadOnlyForm $form) use ($selfURL): string
{
	$isbn = $form->fields["isbn"]->exportValue();
	return $selfURL."/".rawurlencode($isbn)."?__operation=delete_book".AnchorRow::composeRowParameter($form);
};

$table = new DBTable(array(
	"isbn" => new KeyLinkField("ISBN", $composeBookLink, true),
	"Title" => new TextField("Title", true),
	"Author" => new TextField("Author", true)
), array(
	"Delete" => new Action($deleteBookLink)
));

$table->setStatement(Book::queryAll($dbh));
?>
