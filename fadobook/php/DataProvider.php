<?php
class DataProvider
{
	public static function executeQuery($sql)
	{
		$hostName = "localhost";
   		$databaseName = "bookstore";
   		$username = "root";
		$password = "";
		error_reporting(E_ALL);
		// 1. Tao ket noi CSDL
		if (!($connection = mysqli_connect($hostName,$username,$password)))
			die ("cant' connect to localhost");
		if (!(mysqli_select_db($connection,$databaseName)))
			die ("can't find database");
		//2. Thiet lap font Unicode
		if (!(mysqli_query($connection,"SET CHARACTER SET 'utf8'")))
			die ("can't decode to UTF8");
		// Thuc thi cau truy van
		if (!($result = mysqli_query($connection,$sql)))
			die ("can't execute the command");
		// Dong ket noi CSDL
		if (!(mysqli_close($connection)))
			die ("can't close database connection ");
		return $result;
	}
}
?>