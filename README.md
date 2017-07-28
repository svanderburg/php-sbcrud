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

More specifically, this library provides:

* A `CRUDPage` class that can be used to construct pages that integrate with the
  `php-sblayout` manager. The layout manager can be used to render common layout
  sections and provides a URL convention that can be used to uniformly access
  data entities or data sets and their corresponding CRUD operations.
* A `CRUDModel` class giving a uniform interface to a data entity or data set
  implementing CRUD (Create, Read, Update, Write) operations.

Usage
=====
To use the features of this library, you must first compose a layout structure
that includes CRUD pages, then compose the CRUD pages themselves, and finally
provide CRUD models for every data set or data element.

Composing a layout structure that includes CRUD pages
-----------------------------------------------------
The `php-sblayout` library has been designed to declaratively describe the layout
of a web application taking care of *static* sections (which never change) and
*content* sections displaying information based on the entries in the menu
sections that have been selected.

In addition to these layout properties, in a web-based information system, it is
also a good practice that every data set or data entity is reachable by a
distinct URL as well as their corresponding CRUD operations.

These additional properties can be provided by composing `CRUDPage` objects and
adding them to the application's layout:

```php
use SBLayout\Model\Application;
use SBLayout\Model\Page\HiddenStaticContentPage;
use SBLayout\Model\Page\PageAlias;
use SBLayout\Model\Page\StaticContentPage;
use SBLayout\Model\Page\Content\Contents;
use SBLayout\Model\Section\ContentsSection;
use SBLayout\Model\Section\MenuSection;
use SBLayout\Model\Section\StaticSection;
use Example\Model\Page\BooksCRUDPage;
use Example\Model\Page\BookCRUDPage;

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
        "header" => new StaticSection("header.php"),
        "menu" => new MenuSection(0),
        "contents" => new ContentsSection(true)
    ),

    /* Pages */
    new StaticContentPage("Home", new Contents("home.php"), array(
        "404" => new HiddenStaticContentPage("Page not found", new Contents("error/404.php")),

        "home" => new PageAlias("Home", ""),
        "books" => new BooksCRUDPage($dbh, new BookCRUDPage($dbh))
    ))
);

\SBLayout\View\HTML\displayRequestedPage($application);
```

In the above example code fragment, we add two CRUD page objects to the
application's layout:

* The `BooksCRUDPage`'s primary purpose is to display a table with a collection
  of books and can be reached as follows: `http://localhost/index.php/books`.
* The `BookCRUDPage`'s primary purpose is to show a form displaying an
  individual book's properties. The form is reachable from the previously
  described books page and can be reached through the following URL:
  `http://localhost/index.php/books/<ISBN number>`
* By appending the `__operation` GET or POST parameter to any of the previous
  CRUD pages, we can perform desired modifications to the data. For example,
  when opening `http://localhost/index.php/books?__operation=create_book` we get
  a dialog allowing us to provide properties of a new book that should be added
  to the table. When opening
  `http://localhost/index.php/books/848-2482?__operation=delete_book` the book
  with the given ISBN number will be removed from the database and the caller
  gets redirected back to the referrer URL.

Defining CRUD pages
-------------------
In order to construct your own CRUD pages you must define custom sub classes
that inherit from either `StaticContentCRUDPage` or `DynamicContentCRUDPage`.

Moreover, you must override their abstract `constructCRUDModel()` method that
provides a CRUD model object for the data entity or set that we want to read or
modify.

For example, for the books overiew table page
(`http://localhost/index.php/books`), we may want to compose the following CRUD
page object:

```php
use PDO;
use SBCrud\Model\Page\DynamicContentCRUDPage;
use SBLayout\Model\Page\Content\Contents;
use Example\Model\CRUD\BooksCRUDModel;
use Example\Model\CRUD\BookCRUDModel;

class BooksCRUDPage extends DynamicContentCRUDPage
{
    public $dbh;

    public function __construct(PDO $dbh, $dynamicSubPage = null)
    {
        parent::__construct("Books",
            /* Parameter name */
            "isbn",
            /* Key fields */
            array(),
            /* Default contents */
            new Contents("crud/books.php"),
            /* Error contents */
            new Contents("crud/error.php"),
            /* Contents per operation */
            array(
                "create_book" => new Contents("crud/book.php"),
                "insert_book" => new Contents("crud/book.php")
            ),
            $dynamicSubPage);

        $this->dbh = $dbh;
    }

    public function constructCRUDModel()
    {
        if(array_key_exists("__operation", $_REQUEST))
        {
            switch($_REQUEST["__operation"])
            {
                case "create_book":
                case "insert_book":
                    return new BookCRUDModel($this, $this->dbh);
                    break;
                default:
                    return new BooksCRUDModel($this, $this->dbh);
            }
        }
        else
            return new BooksCRUDModel($this, $this->dbh);
    }
}
```

The above CRUD page inherits from `DynamicContentCRUDPage` that itself inherits
from the `php-sblayout`'s `DynamicContentPage` class, which can be used to
interpret URL path components as parameters.

For example, the page shown above treats its successive path component of the
following URL as a parameter: `http://localhost/books/<isbn number>`

In the constructor, we configure various kinds of CRUD page properties:

* We interpret the variable path component (the ISBN number) as a parameter
  (`isbn`) that, in the code, can be referenced as follows:
  `$GLOBALS["query"]["bookId"]`.
* We do not have to validate any keys for this page -- when displaying the
  collection of all books, we do not require any keys.
* We display the `crud/books.php` as the default contents in the page's
  content section and `crud/error.php` in case of an error (when any
  function invoked by the CRUD model yields an exception).
* The contents per operation array can be used to override the displayed
  contents when the `__operation` GET/POST parameter has been provided. For
  example, it will display `contents/book.php` displaying an empty book
  dialog when the URL is called as follows:
  `http://localhost/index.php/books?__operation=create_book`

In addition to constructing a CRUD page object, we must override the
`constructCRUDModel()` method providing a `CRUDModel` object that reads or
modifies the data.

In the example above, a `BooksCRUDModel` object will be provided (providing an
interface to the collection books) unless the `create_book` or `insert_book`
operations are invoked -- in these cases, a `BookCRUDModel` object will be
provided that can be used create a new individual book instance.

In addition to the books page displaying a table of available books, we also
want a page that displays an individual book. This CRUD page can be created as
follows:

```php
use PDO;
use SBCrud\Model\Page\StaticContentCRUDPage;
use SBData\Model\Field\TextField;
use SBLayout\Model\Page\Content\Contents;
use Example\Model\CRUD\BookCRUDModel;

class BookCRUDPage extends StaticContentCRUDPage
{
    public $dbh;
    
    public function __construct(PDO $dbh, array $subPages = null)
    {
        parent::__construct("Book",
            /* Key fields */
            array(
                "isbn" => new TextField("ISBN", true)
            ),
            /* Default contents */
            new Contents("crud/book.php"),
            /* Error contents */
            new Contents("crud/error.php"),

            /* Contents per operation */
            array(),
            $subPages);

        $this->dbh = $dbh;
    }

    public function constructCRUDModel()
    {
        return new BookCRUDModel($this, $this->dbh);
    }
}
```

The above CRUD page implements similar properties as the previously shown CRUD
page, but inherits from the `StaticContentCRUDPage` class, that itself inherits
from `php-sblayout`'s `StaticContentPage` class.

In the constructor, we configure the following properties:

* We configure the $GLOBALS["query"]["isbn"] value (set by the previous CRUD page)
  as the key to query an individual book. It will validated using `php-sbdata`'s
  `checkField()` method for a `TextField`.
* It will display `crud/book.php` by default in the page's contents section
  and `crud/error.php` in case of an error.
* It does not override any contents when a `__operation` GET/POST parameter has
  been provided.

Similar to the previous CRUD page example, this CRUD page must also override the
`constructCRUDModel()` method. Because this page does not require displaying
different contents for any `__operation` parameter, we only need to provide one
CRUD model -- one for an individual book.

Composing a CRUDModel for a data entity or data set
---------------------------------------------------
As shown in the previous two page composition examples, we need to construct a
CRUD model object for the data that we intend to display or modify.

A CRUD model for a specific data set can be created by inheriting from the
`CRUDModel` class. For example the following model can be used to modify
individual books:

```php
use SBData\Model\Form;
use SBData\Model\Field\HiddenField;
use SBData\Model\Field\TextField;
use SBCrud\Model\CRUDModel;
use Example\Model\Entity\Book;

class BookCRUDModel extends CRUDModel
{
    public $dbh;

    public $form = null;

    public function __construct(CRUDPage $crudPage, PDO $dbh)
    {
        parent::__construct($crudPage);
        $this->dbh = $dbh;
    }
    
    private function constructBookForm()
    {
        $this->form = new Form(array(
            "__operation" => new HiddenField(true),
            "isbn" => new TextField("ISBN", true, 20),
            "Author" => new TextField("Author", true, 40),
            "Title" => new TextField("Title", true, 40)
        ));
    }
    
    private function createBook()
    {
        $this->constructBookForm();
        
        $row = array(
            "__operation" => "insert_book"
        );
        $this->form->importValues($row);
    }

    private function insertBook()
    {
        $this->constructBookForm();
        $this->form->importValues($_REQUEST);
        $this->form->checkFields();

        if($this->form->checkValid())
        {
            $book = $this->form->exportValues();
            $stmt = Book::insert($this->dbh, $book);
            header("Location: ".$_SERVER["SCRIPT_NAME"]."/books/".$this->form->fields['isbn']->value);
            exit();
        }
    }

    private function viewBook()
    {
        $this->constructBookForm();

        $stmt = Book::queryOne($this->dbh, $this->keyFields['isbn']->value);

        if(($row = $stmt->fetch()) === false)
        {
            header("HTTP/1.1 404 Not Found");
            throw new Exception("Cannot find book with this ISBN!");
        }
        else
        {
            $row['__operation'] = "update_book";
            $this->form->importValues($row);
        }
    }

    private function updateBook()
    {
        $this->constructBookForm();
        $this->form->importValues($_REQUEST);
        $this->form->checkFields();

        if($this->form->checkValid())
        {
            $book = $this->form->exportValues();
            Book::update($this->dbh, $book, $this->keyFields['isbn']->value);
            $this->viewBook();
        }
    }

    private function deleteBook()
    {
        Book::remove($this->dbh, $this->keyFields['isbn']->value);
        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit();
    }
    
    public function executeOperation()
    {
        if(array_key_exists("__operation", $_REQUEST))
        {
            switch($_REQUEST["__operation"])
            {
                case "create_book":
                    $this->createBook();
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
                default:
                    $this->viewBook();
            }
            else
                $this->viewBook();
        }
    }
}
```
The only obligation that comes with inheriting from `CRUDPage` is that the
`executeOperation()` method must be overridden. The purpose of this method is to
interpret the `__operation` GET/POST parameter and executing the corresponding
operation.

As may be observed in the example shown above, each operation executes a function
that carries out the requested operation. Moreover, the default operation is
`viewBook()` that simply views the requiested book.

Although not strictly a requirement, it is a good practice to validate the
remaining parameters that have been provided as GET or POST parameters before
using them to carry out any modifications. The `Form` and `Table` classes from
the `php-sbdata` library can be used for this purpose.

Finally, when constructing a form or table it may be a good idea to make them a
member of the CRUD page so that they can also be used for viewing (as
demonstrated in the next section).

Displaying a data element of data set
-------------------------------------

In the content sections of the page, the CRUD model can be reached through the
global `$crudModel` variable:

```php
global $crudModel;

\SBData\View\HTML\displayEditableForm($crudModel->form,
    "Submit",
    "One or more fields are incorrectly specified and marked with a red color!",
    "This field is incorrectly specified!");
```

The CRUD model can, for example, be referenced to display the form that is
previously used for validation.

Examples
========
This package contains the previously described books example that can be found
in the `example/` sub folder.

API documentation
=================
This package includes API documentation, which can be generated with
[Doxygen](http://www.doxygen.org). The Makefile in this package contains a `doc`
target and produces the corresponding HTML files in `apidoc`:

    $ make doc

License
=======
The contents of this package is available under the
[Apache Software License](http://www.apache.org/licenses/LICENSE-2.0.html)
version 2.0
