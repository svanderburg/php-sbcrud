<?php
use SBData\Model\ReadOnlyForm;
use SBData\Model\Form;
use SBData\Model\Table\DBTable;
use SBData\Model\Table\Action;
use SBData\Model\Table\Anchor\AnchorRow;
use SBData\Model\Field\KeyLinkField;
use SBData\Model\Field\TextField;
use SBCrud\Model\RouteUtils;
use Examples\Paged\Model\Entity\Book;

global $dbh, $table, $pageSize;

$composeBookLink = function (KeyLinkField $field, ReadOnlyForm $form): string
{
	$isbn = $field->exportValue();
	return RouteUtils::composeSelfURLWithParameters("&amp;", "/".rawurlencode($isbn));
};

$deleteBookLink = function (ReadOnlyForm $form): string
{
	$isbn = $form->fields["isbn"]->exportValue();
	return RouteUtils::composeSelfURLWithParameters("&amp;", "/".rawurlencode($isbn), array("__operation" => "delete_book")).AnchorRow::composeRowParameter($form);
};

$table = new DBTable(array(
	"isbn" => new KeyLinkField("ISBN", $composeBookLink, true),
	"Title" => new TextField("Title", true),
	"Author" => new TextField("Author", true)
), array(
	"Delete" => new Action($deleteBookLink)
));

$pageSize = 10;

$table->setStatement(Book::queryPage($dbh, (int)($GLOBALS["requestParameters"]["page"]), $pageSize));
?>
