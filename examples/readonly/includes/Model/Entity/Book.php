<?php
namespace Examples\ReadOnly\Model\Entity;
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
}
?>
