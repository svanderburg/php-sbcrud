<?php
namespace Example\Model\Entity;
use Exception;
use PDO;
use PDOStatement;

class Book
{
	public static function queryAll(PDO $dbh): PDOStatement
	{
		$stmt = $dbh->prepare("select * from book order by ISBN");
		if(!$stmt->execute())
			throw new Exception($stmt->errorInfo()[2]);

		return $stmt;
	}

	public static function queryOne(PDO $dbh, string $isbn): PDOStatement
	{
		$stmt = $dbh->prepare("select * from book where ISBN = ?");
		if(!$stmt->execute(array($isbn)))
			throw new Exception($stmt->errorInfo()[2]);

		return $stmt;
	}

	public static function insert(PDO $dbh, array $book): void
	{
		$stmt = $dbh->prepare("insert into book values (?, ?, ?)");
		if(!$stmt->execute(array($book['isbn'], $book['Title'], $book['Author'])))
			throw new Exception($stmt->errorInfo()[2]);
	}
	
	public static function update(PDO $dbh, array $book, string $isbn): void
	{
		$stmt = $dbh->prepare("update book set ".
			"ISBN = ?, ".
			"Title = ?, ".
			"Author = ? ".
			"where ISBN = ?");
		if(!$stmt->execute(array($book['isbn'], $book['Title'], $book['Author'], $isbn)))
			throw new Exception($stmt->errorInfo()[2]);
	}
	
	public static function remove(PDO $dbh, string $isbn): void
	{
		$stmt = $dbh->prepare("delete from book where ISBN = ?");
		if(!$stmt->execute(array($isbn)))
			throw new Exception($stmt->errorInfo()[2]);
	}
}
?>
