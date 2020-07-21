<?php
require_once 'DataProvider.php';
if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
		case 'addType': addType();break;
		case 'editType': editType();break;
		case 'deleteType': deleteType();break;
    }
}
function addType(){
	$typeID = addslashes($_POST['typeID']);
	$typeName = addslashes($_POST['typeName']);
	
	$sql = "INSERT INTO type(TypeID, TypeName) VALUES(" .
			"'" .$typeID. "'," . 
			"'" .$typeName. "')"; 

	DataProvider::executeQuery($sql);
	die("0");
}
function editType(){
	$newTypeID = addslashes($_POST['newTypeID']);
	$typeName = addslashes($_POST['typeName']);
	$oldTypeID = addslashes($_POST['oldTypeID']);
	
	$sql = "UPDATE type SET" .
		" TypeName='". $typeName . "'";
	
	if( $newTypeID != $oldTypeID){
		$sql .=", TypeID='".$newTypeID."'";
	}
	
	$sql .=" WHERE TypeID='" . $oldTypeID . "';";
	DataProvider::executeQuery($sql);
	die("0");
}
function deleteType(){
	$typeID = addslashes($_POST['typeID']);

	$sql =" DELETE FROM type WHERE TypeID='" . $typeID . "';";
	DataProvider::executeQuery($sql);
	die("0");
}

?>
