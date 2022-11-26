<?php
namespace Examples\Full\Model\Page\Content;
use SBLayout\Model\Page\Content\Contents;

class BookContents extends Contents
{
	public function __construct()
	{
		parent::__construct("books/book.php", "books/book.php");
	}
}
?>
