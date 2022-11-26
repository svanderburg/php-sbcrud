<?php
namespace Examples\Check\Model\Page;
use SBLayout\Model\Page\ContentPage;
use SBLayout\Model\Page\Content\Contents;
use SBData\Model\Value\Value;
use SBCrud\Model\Page\MasterPage;

class NamePage extends MasterPage
{
	public function __construct()
	{
		parent::__construct("Name", "name", new Contents("name.php"));
	}

	public function createParamValue(): Value
	{
		return new Value(true, 10);
	}

	public function createDetailPage(array $query): ?ContentPage
	{
		return new PrintNamePage();
	}
}
?>
