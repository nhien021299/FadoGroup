<?php
require_once 'DataProvider.php';
if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
		case 'addCategory': addCategory();break;
		case 'editCategory': editCategory();break;
		case 'deleteCategory': deleteCategory();break;
    }
}
function addCategory(){
	$categoryID = addslashes($_POST['categoryID']);
	$categoryName = addslashes($_POST['categoryName']);
	
	$sql = "INSERT INTO category(Category, Category_name) VALUES(" .
			"'" .$categoryID. "'," . 
			"'" .$categoryName. "')"; 

	DataProvider::executeQuery($sql);
	die("0");
}
function editCategory(){
	$newCategoryID = addslashes($_POST['newCategoryID']);
	$categoryName = addslashes($_POST['categoryName']);
	$oldCategoryID = addslashes($_POST['oldCategoryID']);
	
	$sql = "UPDATE category SET" .
		" Category_name='". $categoryName . "'";
	
	if( $newCategoryID != $oldCategoryID){
		$sql .=", Category='".$newCategoryID."'";
	}
	
	$sql .=" WHERE Category='" . $oldCategoryID . "';";
	DataProvider::executeQuery($sql);
	die("0");
}
function deleteCategory(){
	$categoryID = addslashes($_POST['categoryID']);

	$sql =" DELETE FROM category WHERE Category='" . $categoryID . "';";
	DataProvider::executeQuery($sql);
	die("0");
}

?>
