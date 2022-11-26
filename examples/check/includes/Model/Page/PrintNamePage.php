<?php
namespace Examples\Check\Model\Page;
use SBLayout\Model\Page\Content\Contents;
use SBData\Model\ParameterMap;
use SBData\Model\Value\SaneStringValue;
use SBCrud\Model\Page\DetailPage;

class PrintNamePage extends DetailPage
{
	public function __construct()
	{
		parent::__construct("Print name", new Contents("name/printname.php"));
	}

	public function createRequestParameterMap(): ParameterMap
	{
		return new ParameterMap(array(
			"greeting" => new SaneStringValue(true, 10, "Hello")
		));
	}
}
?>
