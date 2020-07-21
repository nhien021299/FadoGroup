<?php
session_start();
require_once 'DataProvider.php';
if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
		case 'login': login();break;
		case 'logout': logout();break;
    }
}
function login(){
	$id = addslashes($_POST['id']);
	$password = addslashes($_POST['password']);
	
	$sql = "SELECT * FROM admin WHERE ID='". $id ."' AND Password = '". $password ."'";
	$result = DataProvider::executeQuery($sql);
	if( mysqli_num_rows($result) == 0 ) {
		die("1");
	} else {
		while ($row = mysqli_fetch_array($result))
		{
			$loginInformation = array('ID'=>$row['ID'], 'Role'=>$row['Role']);
		}
		$_SESSION["isLogin"] = array($loginInformation);
		die("0");
	}
	
}

function logout(){
	unset($_SESSION["isLogin"]);
	die;
}

?>
