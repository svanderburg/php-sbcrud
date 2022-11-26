<?php
use SBData\Model\Form;
use SBData\Model\Table\PagedDBTable;
use SBData\Model\Table\Anchor\AnchorRow;
use SBData\Model\Field\KeyLinkField;
use SBData\Model\Field\TextField;
use SBCrud\Model\RouteUtils;
use Examples\Paged\Model\Entity\Book;

global $dbh, $table;

$queryNumOfBookPages = function (PDO $dbh, int $pageSize): int
{
	return ceil(Book::queryNumOfBooks($dbh) / $pageSize);
};

$composeBookLink = function (KeyLinkField $field, Form $form): string
{
	$isbn = $field->exportValue();
	return RouteUtils::composeSelfURLWithParameters("&amp;", "/".rawurlencode($isbn));
};

$deleteBookLink = function (Form $form): string
{
	$isbn = $form->fields["isbn"]->exportValue();
	return RouteUtils::composeSelfURLWithParameters("&amp;", "/".rawurlencode($isbn), array("__operation" => "delete_book"));
};

$pageSize = 10;

$table = new PagedDBTable(array(
	"isbn" => new KeyLinkField("ISBN", $composeBookLink, true),
	"Title" => new TextField("Title", true),
	"Author" => new TextField("Author", true)
), $dbh, $pageSize, $queryNumOfBookPages, array(
	"Delete" => $deleteBookLink
));

$table->stmt = Book::queryPage($dbh, (int)($GLOBALS["requestParameters"]["page"]), $pageSize);
?>
