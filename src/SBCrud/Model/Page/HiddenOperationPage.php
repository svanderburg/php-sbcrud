<?php
namespace SBCrud\Model\Page;

/**
 * A page that exposes a CRUD operation to the user that is invisible in an operation toolbar.
 */
class HiddenOperationPage extends OperationPage
{
	/**
	 * @see Page::checkVisibility()
	 */
	public function checkVisibility(): bool
	{
		return false;
	}
}
?>
