<?php
namespace Example\Model\Entity;
use Exception;
use PDO;
use PDOStatement;

class Book
{
	public static function queryNumOfBooks(PDO $dbh): int
	{
		$stmt = $dbh->prepare("select count(*) from book order by ISBN");
		if(!$stmt->execute())
			throw new Exception($stmt->errorInfo()[2]);

		if(($row = $stmt->fetch()) === false)
			return 0;
		else
			return (int)($row[0]);
	}

	public static function queryPage(PDO $dbh, int $page, int $pageSize): PDOStatement
	{
		$offset = (int)($page * $pageSize);

		$stmt = $dbh->prepare("select * from book order by ISBN limit ?, ?");
		$stmt->bindParam(1, $offset, PDO::PARAM_INT);
		$stmt->bindParam(2, $pageSize, PDO::PARAM_INT);

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
