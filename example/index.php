<?php
error_reporting(E_STRICT | E_ALL);

set_include_path("./lib/sblayout:./lib/sbdata:../sbcrud:./includes");

require_once("layout/model/Application.class.php");
require_once("layout/model/section/StaticSection.class.php");
require_once("layout/model/section/MenuSection.class.php");
require_once("layout/model/section/ContentsSection.class.php");
require_once("layout/model/page/StaticContentPage.class.php");
require_once("layout/model/page/PageAlias.class.php");
require_once("layout/model/page/HiddenStaticContentPage.class.php");
require_once("layout/model/page/DynamicContentPage.class.php");

require_once("model/page/BooksCRUDPage.class.php");
require_once("model/page/BookCRUDPage.class.php");

require_once("layout/view/html/index.inc.php");

$dbh = new PDO("mysql:host=localhost;dbname=books", "root", "admin", array(
	PDO::ATTR_PERSISTENT => true
));

$application = new Application(
	/* Title */
	"Bookstore",

	/* CSS stylesheets */
	array("default.css"),

	/* Sections */
	array(
		"header" => new StaticSection("header.inc.php"),
		"menu" => new MenuSection(0),
		"contents" => new ContentsSection(true)
	),

	/* Pages */
	new StaticContentPage("Home", new Contents("home.inc.php"), array(
		"404" => new HiddenStaticContentPage("Page not found", new Contents("error/404.inc.php")),

		"home" => new PageAlias("Home", ""),
		"books" => new BooksCRUDPage($dbh, new BookCRUDPage($dbh))
	))
);

displayRequestedPage($application);
?>
