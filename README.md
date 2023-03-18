php-sbcrud
==========
Sometimes it may be desired to develop web-based information systems, typically
using a relational database for storage. This library provides abstractions to
make developing such information systems more convenient.

The concepts of this library are built on top of the
[php-sblayout](https://github.com/svanderburg/php-sblayout) library to organize
layouts of web application pages and
[php-sbdata](https://github.com/svanderburg/php-sbdata) that takes care of
validating and displaying data elements.

More specifically, this package provides the following features:
* Data validation for input parameters
* Construction of master-detail pages
* Construction of CRUD pages
* State parameter propagation

Installation
============
This package can be embedded in any PHP project by using
[PHP composer](https://getcomposer.org). Add the following items to your
project's `composer.json` file:

```json
{
  "repositories": [
    {
      "type": "git",
      "url": "https://github.com/svanderburg/php-sbcrud.git"
    }
  ],

  "require": {
    "svanderburg/php-sbcrud": "@dev",
  }
}
```

and run:

```bash
$ composer install
```

Installing development dependencies
===================================
When it is desired to modify the code or run the examples inside this
repository, the development dependencies must be installed by opening
the base directory and running:

```bash
$ composer install
```

Usage
=====
This package contains a variety of features to make the development of web-based
information systems (typically using a relational DBMS as a backend) more
convenient.

Data validation for input parameters
------------------------------------
The purpose of the `php-sblayout` is to organize layouts. It uses the path
components in a URL to determine which page has been requested by the user and
automatically generates the requested page from static parts (that are the same
for any page of the application) and dynamic parts (that change for each
selected page).

A common feature for web-based information systems is that users are allowed to
change data (e.g. by providing GET/POST parameters or a path component). Input
provided by users cannot be trusted and must be checked for validity (e.g.
whether they do not exceed a maximum length, and whether they consist of the
right characters).

The `php-sblayout` leaves the responsibility of checking input parameters to
the user. The first use case of this library is to use the features of
`php-sbdata` to automatically check input parameters.

For example, we can create a trivial application whose main purpose is to
display the name of a user with an optional a custom greeting. For example, when
invoking the following URL:

```
http://localhost/check/index.php/name/Sander
```

The user should see:

```
Hello Sander
```

It is also possible to add an optional `greeting` parameter that specifies how
the caller is greeted (the default is: `Hello`). For example, by opening the
following URL:

```
http://localhost/check/index.php/name/Sander?greeting=Hi
```

The user should see:

```
Hi Sander
```

The prefix and name parameters are not allowed to be longer than 10 characters.

For example, the following request should return a bad request page because the
greeting is too long:

```
http://localhost/check/index.php/name/Sander?greeting=Averylonglonglongwelcome
```

We can map to the following URL: `/index.php/name` to a `MasterPage` (an
extension of the `DynamicContentPage` from the `php-sblayout` framework) by
overriding the class with the following properties:

```php
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
```

In the above class, we have specified the following properties:

* We construct a page with title: `Name` that uses the `name` identifier for
  the variable that stores the value of the path component (that is appended to
  the URL). The resulting value is stored in: `$GLOBALS["query"]["name"]`.
  It displays the `name.php` code snippet in the contents section. This snippet
  displays instructions to the user explaining how a name with a greeting can be
  displayed.
* The `createParamValue` method constructs a `Value` object that specifies how
  the `name` path component should be validated. In this case, it specifies that
  it needs to be a string with a maximum length of 10.
* The `createDetailPage` method constructs the sub page of this page -- the
  page that is responsible for consuming the path parameter and displaying the
  greeting to the user.

We can define the `PrintNamePage` class that is responsible for displaying
a greeting to the user as follows:

```php
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
```

The above class extends the `DetailPage` class (an extension of the
`StaticContentPage` of the `php-sblayout` framework) with the following
properties:

* We construct a page with title: `Print name` that displays the
  `name/printname.php` PHP snippet to display a greeting to the user.
* The `createRequestParameterMap` returns a `ParameterMap` that specifies how
  `$_REQUEST` parameters need to be validated. By using a `SaneStringValue`
  object, the `greeting` parameter is automatically sanitized (from trailing
  white spaces etc.) and is not allowed to be longer than 10 characters. The
  default greeting is: `Hello`.

The parameter values of path components can be accessed through the
`$GLOBALS["query"]` array whereas the request parameters can be accessed through
the `$GLOBALS["requestParameters"]` array. These variables should be used
instead of PHP's `$_REQUEST`, `$_GET`, and `$_POST`, whose values have not been
checked or sanitized.

For example, we can display the content page: `name/printname.php` as follows
to construct the greeting to the user:

```php
<p><?= $GLOBALS["requestParameters"]["greeting"]." ".$GLOBALS["query"]["name"] ?></p>
```

In case, any of the parameters is invalid, a `BadRequestException` is thrown and
the user gets automatically redirected to the `400` error page (that explains
the user why the request has failed).

We can attach the `NamePage` to an application layout as follows:

```php
use SBLayout\Model\Application;
use SBLayout\Model\Section\ContentsSection;
use SBLayout\Model\Section\MenuSection;
use SBLayout\Model\Section\StaticSection;
use SBLayout\Model\Page\HiddenStaticContentPage;
use SBLayout\Model\Page\PageAlias;
use SBLayout\Model\Page\StaticContentPage;
use SBLayout\Model\Page\Content\Contents;
use Examples\Check\Model\Page\NamePage;

$application = new Application(
	/* Title */
	"Print name",

	/* CSS stylesheets */
	array("default.css"),

	/* Sections */
	array(
		"header" => new StaticSection("header.php"),
		"menu" => new MenuSection(0),
		"contents" => new ContentsSection(true)
	),

	/* Pages */
	new StaticContentPage("Home", new Contents("home.php"), array(
		"400" => new HiddenStaticContentPage("Bad request", new Contents("error/400.php")),
		"404" => new HiddenStaticContentPage("Page not found", new Contents("error/404.php")),

		"home" => new PageAlias("Home", ""),
		"name" => new NamePage()
	))
);

\SBLayout\View\HTML\displayRequestedPage($application);
```

In the above code fragment, we have attached a `NamePage` object instance to the
`name` sub page in the application. Because `NamePage` inherits from
`MasterPage` (that indirectly inherits from `Page`) we can attach it as a sub
page to any page that we want.

Creating master and detail pages
--------------------------------
In addition to parameter checking, another important use case of this framework
is to facilitate the construction of *master* and *detail* pages. This use case
explains the rationale behind the naming of the page classes.

We have picked the name: `MasterPage` for pages that are supposed to display
collections of records, whereas a `DetailPage` is designed to display individual
records, that can be queried by providing a path component as a parameter.

For example, for a library system we may want to display a table of books by
opening the following URL:

```
http://localhost/index.php/books
```

The properties of an individual book can be displayed by appending a path
component as a parameter:

```
http://localhost/index.php/books/978-0131429383
```

The last path component: `978-0131429383` refers to the ISBN number of an
individual book.

We can construct a `BooksPage` (that is a sub class of `MasterPage`) as follows:

```php
namespace Examples\ReadOnly\Model\Page;
use PDO;
use SBLayout\Model\Page\Content\Contents;
use SBLayout\Model\Page\ContentPage;
use SBData\Model\Value\Value;
use SBCrud\Model\Page\MasterPage;

class BooksPage extends MasterPage
{
	public PDO $dbh;

	public function __construct(PDO $dbh)
	{
		parent::__construct("Books", "isbn", new Contents("books.php", "books.php"));
		$this->dbh = $dbh;
	}

	public function createParamValue(): Value
	{
		return new Value(true, 17);
	}

	public function createDetailPage(array $query): ?ContentPage
	{
		return new BookPage($this->dbh, $query["isbn"]);
	}
}
```

The above class has the following properties:

* It specifies a page with title: `Books` in which the appended path component
  value is stored in the `$GLOBALS["query"]["isbn"]` variable. It uses the
  `contents/books.php` PHP snippet to display a table with an overview of books,
  using the `controller/books.php` controller to query all books and
  constructing a `DBTable` from it.
* It specifies through the `createParamValue` method that the path component
  (`isbn`) has a maximum length of 17 characters.
* It constructs a detail page (a `BookPage` object) that displays an individual
  book by using the `isbn` parameter to query the properties of the requested
  book.

We can define the `BookPage` (a sub class of `DetailPage`) as follows:

```php
<?php
namespace Examples\ReadOnly\Model\Page;
use PDO;
use SBLayout\Model\PageNotFoundException;
use SBLayout\Model\Page\Content\Contents;
use SBCrud\Model\Page\DetailPage;
use Examples\ReadOnly\Model\Entity\Book;

class BookPage extends DetailPage
{
	public array $entity;

	public function __construct(PDO $dbh, string $isbn)
	{
		parent::__construct("Book", new Contents("books/book.php", "books/book.php"));

		$stmt = Book::queryOne($dbh, $isbn);
		if(($entity = $stmt->fetch()) === false)
			throw new PageNotFoundException("Cannot find book with ISBN: ".$isbn);

		$this->title = $entity["Title"];
		$this->entity = $entity;
	}
}
?>
```

The above class defines a constructor with the following properties:

* It creates a page with default title: `Book` and uses a dedicated controller
  and content page (both are named: `books/book.php`)
* It queries the individual book record and adjusts the page title to match the
  book title.
* In case that the book cannot be found, it throws a: `PageNotFoundException`.
  The `php-sblayout` framework will automatically redirect the user to the 404
  error page that displays the provided error message.

Because it is desired to have the ability to change the title of a page to match
an individual book title, every `DetailPage` (and hence every `BookPage`) is a
unique object instance. This is in contrast to most other `Page` instances
that are part of the `Application` object -- they are immutable singleton
instances.

Because it is desired to construct unique object instances for detail pages
explains why you must override the `createDetailPage` method of a `MasterPage`
-- it makes it possible to lazily construct unique instances of a detail page.

Creating CRUD pages
-------------------
The previous example only supports read operations. We may also want to give
the user the ability to make *modifications*, by implementing create, update,
and delete operations. To make this possible we need to extend our previous
master-detail URL convention with additional operations.

For modern web applications developed today, it is a common habit to facilitate
CRUD operations by implementing a REST API following a convention in which HTTP
operations are used in a specific way, for example:

* `GET /books`. Retrieves a collection of records
* `POST /books`. Inserts new records
* `GET /books/978-0131429383`. Retrieves the properties of an individual record
* `PUT /books/978-0131429383`. Updates the properties of an individual record
* `DELETE /books/978-0131429383`. Deletes the selected record

REST operations typically use JSON for the input and output of data.

In this framework, we cannot directly use these REST conventions because it aims
to be page-driven and the reduction of JavaScript usage to a minimum (for
non-essential functionality mostly). As a result, it avoids doing any JSON
transformations on the client-side. HTML can basically only transfer data by
making `GET` or `POST` requests through hyperlinks or forms.

This framework follows URL conventions that are close to REST, but instead of
using an HTTP operation, it uses a request parameter to determine the kind of
operation that needs to be executed (by default the parameter name is:
`__operation`, but it can be changed to any other identifier by through the
`$operationParam` parameter). If no operation parameter is specified, the
framework assumes that the user invoked the read operation.

We can apply this convention to our books example as follows:

* `/index.php/books`. Retrieves and displays a collection of records
* `/index.php/books?__operation=add_book`. Shows a screen that the user can use
  to create a new record
* `/index.php/books?__operation=insert_book`. Inserts a provided book into the
  data store.
* `/index.php/book/978-0131429383`. Retrieves and displays an individual record.
  It also provides facilities (e.g. input fields) allowing the user to change
  the record.
* `/index.php/book/978-0131429383?__operation=update_book`. Updates the selected
  book.
* `/index.php/book/978-0131429383?__operation=delete_book`. Deletes the selected
  book.

The above URLs can be invoked both through HTTP `GET` and `POST` requests.

To extend the previous books example to give the user the ability to change
data, we must change the displayed pages for each operation. For example, when
opening the `/index.php/books` page we should see a table, but when requesting
`/index.php/books?__operation=add_book` then we should see an input form.

By inheriting from `CRUDMasterPage` and `CRUDDetailPage` rather than `MasterPage`
and `DetailPage`, we can specify what content to display when an operation
parameter was specified.

For example, the following example changes the `BooksPage` to implement the
`add_book` and `insert_book` operations:

```php
namespace Examples\Full\Model\Page;
use PDO;
use SBLayout\Model\Page\ContentPage;
use SBLayout\Model\Page\Content\Contents;
use SBData\Model\Value\Value;
use SBCrud\Model\Page\CRUDMasterPage;
use SBCrud\Model\Page\OperationPage;

class BooksPage extends CRUDMasterPage
{
	public PDO $dbh;

	public function __construct(PDO $dbh)
	{
		parent::__construct("Books", "isbn", new Contents("books.php", "books.php"), array(
			"add_book" => new OperationPage("Add book", new Contents("add_book.php", "add_book.php")),
			"insert_book" => new OperationPage("Insert book", new Contents("insert_book.php", "insert_book.php"))
		));
		$this->dbh = $dbh;
	}

	public function createParamValue(): Value
	{
		return new Value(true, 17);
	}

	public function createDetailPage(array $query): ?ContentPage
	{
		return new BookPage($this->dbh, $query["isbn"]);
	}
}
```

The most notable change in the above example is that we extend the `BooksPage`
class from `CRUDMasterPage` and that in the constructor we specify
`OperationPage`s that need to be displayed when an operation was provided as a
parameter:

* When the user specifies the `add_book` operation, the layout manager returns a
  controller that creates an empty form and content section that renders a form.
* The `insert_book` operation causes the layout manager to invoke a controller
  that inserts the record.

If no operation was specified, the page retains its original behaviour -- it
will simply use the controller and content page to display a table with an
overview of books.

Creating CRUD interfaces
------------------------
Although the above facilities make it possible to change the pages for every CUD
operation, specifying separate controllers and content pages for each operation
may be quite inconvenient.

For example, the `add_book`, `update_book` and the page that displays an
individual book (`/index.php/books/978-0131429383`) use the same `Form` to
display and validate the properties of a book 

Furthermore, almost all non-read operations (with the exception of the books
master view) need to display an individual record.

All these requirements introduce quite a bit of code duplication.

A more convenient solution is to unify all controllers by creating a custom
`CRUDInterface` object that stores the implementation of all CRUD operation of
an object (such as a `Book`) in a central place:

```php
namespace Examples\Full\Model\CRUD;
use PDO;
use SBLayout\Model\Route;
use SBLayout\Model\Page\ContentPage;
use SBData\Model\Field\TextField;
use SBData\Model\Field\HiddenField;
use SBData\Model\Table\Anchor\AnchorRow;
use SBCrud\Model\RouteUtils;
use SBCrud\Model\CRUDForm;
use SBCrud\Model\CRUD\CRUDInterface;
use SBCrud\Model\Page\CRUDPage;
use Examples\Full\Model\Entity\Book;

class BookCRUDInterface extends CRUDInterface
{
	public PDO $dbh;

	public Route $route;

	public CRUDPage $currentPage;

	public CRUDForm $form;

	public function __construct(PDO $dbh, Route $route, CRUDPage $currentPage)
	{
		parent::__construct($currentPage);
		$this->dbh = $dbh;
		$this->route = $route;
		$this->currentPage = $currentPage;
	}

	private function constructForm(): CRUDForm
	{
		return new CRUDForm(array(
			"isbn" => new TextField("ISBN", true, 20),
			"Title" => new TextField("Title", true, 40),
			"Author" => new TextField("Author", true, 40)
		), $this->operationParam);
	}

	private function viewBook(): void
	{
		$this->form = $this->constructForm();
		$this->form->importValues($this->currentPage->entity);
		$this->form->setOperation("update_book");
	}

	private function addBook(): void
	{
		$this->form = $this->constructForm();
		$this->form->setOperation("insert_book");
	}

	private function insertBook(): void
	{
		$this->form = $this->constructForm();
		$this->form->importValues($_REQUEST);
		$this->form->checkFields();

		if($this->form->checkValid())
		{
			$book = $this->form->exportValues();
			Book::insert($this->dbh, $book);

			header("Location: ".RouteUtils::composeSelfURL()."/".rawurlencode($book['isbn']));
			exit();
		}
	}

	private function updateBook(): void
	{
		$this->form = $this->constructForm();
		$this->form->importValues($_REQUEST);
		$this->form->checkFields();

		if($this->form->checkValid())
		{
			$book = $this->form->exportValues();
			$isbn = $GLOBALS["query"]["isbn"];
			Book::update($this->dbh, $book, $isbn);

			header("Location: ".$this->route->composeParentPageURL($_SERVER["SCRIPT_NAME"])."/".rawurlencode($book['isbn']));
			exit();
		}
	}

	private function deleteBook(): void
	{
		$isbn = $GLOBALS["query"]["isbn"];
		Book::remove($this->dbh, $isbn);
		header("Location: ".$this->route->composeParentPageURL($_SERVER["SCRIPT_NAME"]).AnchorRow::composePreviousRowFragment());
		exit();
	}

	protected function executeCRUDOperation(?string $operation): void
	{
		if($operation === null)
			$this->viewBook();
		else
		{
			switch($operation)
			{
				case "add_book":
					$this->addBook();
					break;
				case "insert_book":
					$this->insertBook();
					break;
				case "update_book":
					$this->updateBook();
					break;
				case "delete_book":
					$this->deleteBook();
					break;
			}
		}
	}
}
```

The above class creates an interface that captures all CRUD operations for
`Book`s in a central place:

* The only mandatory method that a `CRUDInterface` sub class needs to implement
  is: `executeCRUDOperation` that decides which operation to execute based on
  the specified operation parameter. If an operation parameter is provided, it
  invokes the appropriate CRUD operation. If no operation was specified (`null`),
  it invokes the view operation.
* Every operation is implemented as a separate method to keep the code clean.
* Reuse of the same `Form` is made possible by using the `constructForm` method.
  In the above example, we use `CRUDForm` (that is a simple wrapper over the
  `Form` class in the `php-sbdata` framework) that makes it convenient to specify
  which CRUD operation needs to be executed.
* To safely refer to the self URL, we use a wrapper function named:
  `RouteUtils::composeSelfURL()` rather than PHP's unsafe `$_SERVER["PHP_SELF"]`
  that unescapes special characters.

The above class makes it possible to write a unified controller for all
book-related operations (`controllers/books/book.php`):

```php
use Examples\Full\Model\CRUD\BookCRUDInterface;

global $crudInterface, $dbh, $route, $currentPage;

$crudInterface = new BookCRUDInterface($dbh, $route, $currentPage);
$crudInterface->executeOperation();
```

The above controller will simply instantiate the `BookCRUDInterface` and
executes the requested operation.

Furthermore, since all operation pages need to display an individual book, we
can also use the same content page for all book operations
(`contents/books/book.php`):

```php
global $route, $crudInterface;

\SBLayout\View\HTML\displayBreadcrumbs($route);
\SBData\View\HTML\displayEditableForm($crudInterface->form);
```

The above content section displays breadcrumbs (showing the route that user
followed to open the page), and the form with the requested book data.

We can can wrap the above controller and content sections in a wrapper called
`BookContents`:

```php
namespace Examples\Full\Model\Page\Content;
use SBLayout\Model\Page\Content\Contents;

class BookContents extends Contents
{
	public function __construct()
	{
		parent::__construct("books/book.php", "books/book.php");
	}
}
```

and simplify the implementation of the `BooksPage` as follows:

```php
namespace Examples\Full\Model\Page;
use PDO;
use SBLayout\Model\Page\ContentPage;
use SBLayout\Model\Page\Content\Contents;
use SBData\Model\Value\Value;
use SBCrud\Model\Page\CRUDMasterPage;
use SBCrud\Model\Page\OperationPage;
use Examples\Full\Model\Page\Content\BookContents;

class BooksPage extends CRUDMasterPage
{
	public PDO $dbh;

	public function __construct(PDO $dbh)
	{
		parent::__construct("Books", "isbn", new Contents("books.php", "books.php"), array(
			"add_book" => new OperationPage("Add book", new BookContents()),
			"insert_book" => new OperationPage("Insert book", new BookContents())
		));
		$this->dbh = $dbh;
	}

	public function createParamValue(): Value
	{
		return new Value(true, 17);
	}

	public function createDetailPage(array $query): ?ContentPage
	{
		return new BookPage($this->dbh, $query["isbn"]);
	}
}
```

In the above example, all operation pages refer to the same contents:
`BookContents` that always displays the same controller and content sections.
Similarly, the `BookPage` that manages the operations of an individual book also
only need to refer to `BookContents`.

State parameter propagation
---------------------------
For master pages (that typically display collections of records), it is often
desired to perform stateful operations on the requested data collection. For
example, we may want to support *pagination* -- if the collection of data is
large we may want to reduce network bandwidth by dividing it into *pages* of a
fixed size (e.g. 20 records) and only display one page at the time.

For example, by adding pagination support, we may be able to view the first 20
book records with:

```
/index.php/books?page=0
```

and the next 20 with:

```
/index.php/books?page=1
```

Moreover, we may also want to make the ordering of the records configurable or
allow a user to filter data by providing query parameters.

When performing a CRUD operation from an altered master page and returning back
to that page from a detail page, knowledge about the state needs to be retained.
Not retaining this state provides a suboptimal user experience. For example, if
previous state is not retained, a user always gets redirected to the first page
after deleting a record, which is undesirable.

To retain knowledge about the state of parent pages, all `requestParameters` are
transitive -- sub pages retain the knowledge about the request parameters of
their parent pages. As a result, it is recommended that sub pages do not pick the
same parameter names as any of their parent pages.

When opening a sub page, it will also automatically parse the request parameters
of all their parents. As a result, the breadcrumbs feature still remembers the
settings of any of its parent pages.

There is one requirement imposed on developers to allow this to state retention
feature to work -- when a page needs to invoke the URL of any of its sub pages, it
also needs to propagate its request parameter values.

So, for example, when it is desired to open an individual book page, it may be
tempting to generate a URL relative the current URL:

```php
$subPageUrl = RouteUtils::composeSelfURL()."/".rawurlencode($isbn);
```

The downside is that opening the link above loses the knowledge of the state of
the current and any parent page.

To automatically propagate all request parameters, you can use the following
function call instead:

```php
use SBCrud\Model\RouteUtils;

$subPageUrl = RouteUtils::composeSelfURLWithParameters(null, "/".rawurlencode($isbn));
```

The above function call composes a URL relative to itself and automatically
propagates all request parameters.

Likewise, to compose a URL relative to the parent URL, you should use:
`RouteURL::composePreviousURLWithParameters`.

There is a penalty for propagting state parameters -- due to parameter
propagation, there are multiple URLs that represent the same output that may
confuse search engines. To clear up that confusion, a page will always output a
canonical HTTP header that tells the requester the URL without all propagated
parameters:

```
Link: <http://localhost/paged/index.php/books>; rel="canonical"
```

Operation pages are never supposed to be indexed by search engines. As a result,
they emit the following HTTP header:

```
X-Robots-Tag: noindex, nofollow
```

Examples
========
This package contains the previously described examples that can be found in the
`examples/` sub folder:

* `check` contains the example that shows how to check the validity of input
  parameters
* `readonly` shows a read-only book application example that demonstrates how
  to create master and detail pages
* `full` shows a full CRUD book example that also provides the user the ability
  to change data.
* `paged` extends the previous example with pagination support. It uses state
  parameter propagation methods to retain knowledge about the pagination setting.

API documentation
=================
This package includes API documentation that can be generated with
[Doxygen](https://www.doxygen.nl):

```bash
$ doxygen
```

License
=======
The contents of this package is available under the
[Apache Software License](http://www.apache.org/licenses/LICENSE-2.0.html)
version 2.0
