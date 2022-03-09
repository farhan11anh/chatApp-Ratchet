<?php

//Database_connection.php

//melakukan koneksi database menggunakan metode PDO
class Database_connection
{
	function connect()
	{
		$connect = new PDO("mysql:host=localhost; dbname=chat", "root", "");

		return $connect;
	}
}

?>