<?php
class Book
{
	public static function queryAll(PDO $dbh)
	{
		$stmt = $dbh->prepare("select * from book order by ISBN");
		if(!$stmt->execute())
			throw new Exception($stmt->errorInfo()[2]);

		return $stmt;
	}

	public static function queryOne(PDO $dbh, $isbn)
	{
		$stmt = $dbh->prepare("select * from book where ISBN = ?");
		if(!$stmt->execute(array($isbn)))
			throw new Exception($stmt->errorInfo()[2]);

		return $stmt;
	}

	public static function insert(PDO $dbh, array $book)
	{
		$stmt = $dbh->prepare("insert into book values (?, ?, ?)");
		if(!$stmt->execute(array($book['isbn'], $book['Title'], $book['Author'])))
			throw new Exception($stmt->errorInfo()[2]);

		return $stmt;
	}
	
	public static function update(PDO $dbh, array $book, $isbn)
	{
		$stmt = $dbh->prepare("update book set ".
			"ISBN = ?, ".
			"Title = ?, ".
			"Author = ? ".
			"where ISBN = ?");
		if(!$stmt->execute(array($book['isbn'], $book['Title'], $book['Author'], $isbn)))
			throw new Exception($stmt->errorInfo()[2]);

		return $stmt;
	}
	
	public static function remove(PDO $dbh, $isbn)
	{
		$stmt = $dbh->prepare("delete from book where ISBN = ?");
		if(!$stmt->execute(array($isbn)))
			throw new Exception($stmt->errorInfo()[2]);

		return $stmt;
	}
}
?>
