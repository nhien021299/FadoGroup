<?php
require_once 'DataProvider.php';
if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
		case 'editStatus': editStatus();break;
    }
}

function editStatus(){
	$id = addslashes($_POST['id']);
	$status = addslashes($_POST['status']);
	
	$sql = "UPDATE bill SET" .
		" Status='". $status . "'".
		" WHERE ID='" . $id . "'";
	DataProvider::executeQuery($sql);
	die("0");
}

?>
