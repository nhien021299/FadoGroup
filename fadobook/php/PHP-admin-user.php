<?php
require_once 'DataProvider.php';
if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
		case 'changeStatus': changeStatus();break;
    }
}

function changeStatus(){
	$email = addslashes($_POST['email']);
	$status = addslashes($_POST['status']);

	$sql = "SELECT * FROM user WHERE Email='". $email ."'";
	$result = DataProvider::executeQuery($sql);
	if( mysqli_num_rows($result) == 0 ) {
		die("1");
	} 
	
	$sql = "UPDATE user SET" .
		" Status='". $status . "'".
		" WHERE Email='" . $email . "'";
	DataProvider::executeQuery($sql);
	die("0");
}

?>
