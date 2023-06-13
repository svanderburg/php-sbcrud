<?php
namespace SBCrud\Model\Page\Manager;
use SBLayout\Model\BadRequestException;
use SBCrud\Model\RouteUtils;
use SBCrud\Model\Page\CheckedPage;

/**
 * Manages a CheckedPage
 */
class CheckedContentManager
{
	/** Refers to the checked page that needs to be managed */
	public CheckedPage $checkedPage;

	/**
	 * Constructs a new CheckedContentManager instance.
	 *
	 * @param $checkedPage Refers to the checked page that needs to be managed
	 */
	public function __construct(CheckedPage $checkedPage)
	{
		$this->checkedPage = $checkedPage;
	}

	private function emitCanonicalHeader(array $requestParameters): void
	{
		if(array_key_exists("HTTPS", $_SERVER) && $_SERVER["HTTPS"] == "on")
			$url = "https://";
		else
			$url = "http://";

		$url .= $_SERVER["HTTP_HOST"].RouteUtils::composeSelfURL();

		if(count($requestParameters) > 0)
			$url .= "?".http_build_query($requestParameters, "", null, PHP_QUERY_RFC3986);

		header('Link: <'.$url.'>; rel="canonical"');
	}

	/**
	 * Exports the request parameters of the managed page as the requestParameter variable.
	 *
	 * @param $emitHeader Indicates whether to emit a canonical page URL header that prunes out propagated request parameters
	 */
	public function exportRequestParameters(bool $emitHeader): void
	{
		$requestParameterMap = $this->checkedPage->createRequestParameterMap();
		$requestParameterMap->importValues($_REQUEST);
		$requestParameterMap->checkValues();

		if($requestParameterMap->checkValid())
		{
			$requestParameters = $requestParameterMap->exportValues();

			if(array_key_exists("requestParameters", $GLOBALS))
				$GLOBALS["requestParameters"] = array_merge($GLOBALS["requestParameters"], $requestParameters);
			else
				$GLOBALS["requestParameters"] = $requestParameters;

			if($emitHeader)
				$this->emitCanonicalHeader($requestParameters);
		}
		else
			throw new BadRequestException($requestParameterMap->composeErrorMessage("Invalid request parameters:"));
	}

	/**
	 * Computes a string suffix with all request parameters as GET parameters.
	 *
	 * @param $argSeparator The symbol that separates arguments
	 * @return GET parameters or an empty string if no request parameters were specified
	 */
	public function generateRequestParameterString(string $argSeparator): string
	{
		if(array_key_exists("requestParameters", $GLOBALS) && count($GLOBALS["requestParameters"]) > 0)
			return "?".http_build_query($GLOBALS["requestParameters"], "", $argSeparator, PHP_QUERY_RFC3986);
		else
			return "";
	}
}
?>
