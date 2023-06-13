<?php
namespace SBCrud\Model;
use SBLayout\Model\Route;

/**
 * Provides utility functions for automatically propagating request parameters to sub pages.
 */
class RouteUtils
{
	/**
	 * Composes a better self reference than PHP_SELF that retains URL encoding.
	 *
	 * @return The path to itself similar to PHP_SELF with URL encoding
	 */
	public static function composeSelfURL(): string
	{
		return strtok($_SERVER["REQUEST_URI"], '?');
	}

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
		$url = RouteUtils::composeSelfURL().$pathSuffix;

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
	 * @param $separator The separator to use between the request parameters. By default, it is &
	 */
	public static function composePreviousURLWithParameters(Route $route, string $pathSuffix = "", string $separator = "&"): string
	{
		$parsedUrl = parse_url($route->composeParentPageURL($_SERVER["SCRIPT_NAME"], $separator));
		$url = $parsedUrl["path"].$pathSuffix;

		if(array_key_exists("query", $parsedUrl) && $parsedUrl["query"] !== null)
			$url .= "?".$parsedUrl["query"];

		return $url;
	}
}
?>
