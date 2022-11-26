<?php
use SBData\Model\Form;
use SBData\Model\Field\TextField;
use Examples\ReadOnly\Model\Entity\Book;

global $form, $currentPage;

$form = new Form(array(
	"isbn" => new TextField("ISBN", true, 20),
	"Title" => new TextField("Title", true, 40),
	"Author" => new TextField("Author", true, 40)
));

$form->importValues($currentPage->entity);
?>
