<?php
namespace SBCrud\Model;
use SBLayout\Model\Route;

/**
 * Provides utility functions for automatically propagating request parameters to sub pages.
 */
class RouteUtils
{
	/**
	 * Composes a URL relative to itself and automatically propagates all request parameters with it.
	 *
	 * @param $separator The separator to use between the request parameters. By default, it is &
	 * @param $pathSuffix Path to append to the URL
	 * @param $extraGetParameters An array of string mappings that specify additional GET parameters
	 * @return A URL to itself with all propagated request parameters and additions
	 */
	public static function composeSelfURLWithParameters(string $separator = null, string $pathSuffix = "", array $extraGetParameters = array()): string
	{
		$url = $_SERVER["PHP_SELF"].$pathSuffix;

		if(array_key_exists("requestParameters", $GLOBALS))
			$allParameters = array_merge($GLOBALS["requestParameters"], $extraGetParameters);
		else
			$allParameters = $extraGetParameters;

		if(count($allParameters) > 0)
			$url .= "?".http_build_query($allParameters, "", $separator, PHP_QUERY_RFC3986);

		return $url;
	}

	/**
	 * Composes a URL relative to the parent page and automatically propagates all request parameters with it.
	 *
	 * @param $route Route to the currently opened page
	 * @param $pathSuffix Path to append to the URL
	 */
	public static function composePreviousURLWithParameters(Route $route, string $pathSuffix = ""): string
	{
		$parsedUrl = parse_url($route->composeParentPageURL($_SERVER["SCRIPT_NAME"]));
		$url = $parsedUrl["path"].$pathSuffix;

		if(array_key_exists("query", $parsedUrl) && $parsedUrl["query"] !== null)
			$url .= "?".$parsedUrl["query"];

		return $url;
	}
}
?>
