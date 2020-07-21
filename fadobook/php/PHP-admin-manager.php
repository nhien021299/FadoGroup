<?php
require_once 'DataProvider.php';
if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
		case 'addManager': addManager();break;
		case 'editManager': editManager();break;
		case 'deleteManager': deleteManager();break;
    }
}
function addManager(){
	$ID = addslashes($_POST['ID']);
	$password = addslashes($_POST['password']);
	
	$sql = "INSERT INTO admin(ID, Password, Role) VALUES(" .
			"'" .$ID. "'," . 
			"'" .$password. "'," . 
			"'Manager')"; 

	DataProvider::executeQuery($sql);
	die("0");
}
function editManager(){
	$ID = addslashes($_POST['ID']);
	$password = addslashes($_POST['password']);

	$sql = "SELECT * FROM admin WHERE ID='". $ID ."'";
	$result = DataProvider::executeQuery($sql);
	if( mysqli_num_rows($result) == 0 ) {
		die("1");
	} else {
	
		$sql = "UPDATE admin SET" .
			" Password ='". $password . "'";
		
		$sql .=" WHERE ID ='" . $ID . "';";
		DataProvider::executeQuery($sql);
		die("0");
	}
}
function deleteManager(){
	$ID = addslashes($_POST['ID']);

	$sql =" DELETE FROM admin WHERE ID='" . $ID . "';";
	DataProvider::executeQuery($sql);
	die("0");
}

?>
