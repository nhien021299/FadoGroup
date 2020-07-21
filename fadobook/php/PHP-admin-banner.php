<?php
require_once 'DataProvider.php';
if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
		case 'addBanner': addBanner();break;
		case 'editBanner': editBanner();break;
		case 'deleteBanner': deleteBanner();break;
    }
}
function addBanner(){
	$link = addslashes($_POST['link']);
	$position = addslashes($_POST['position']);
	
	$extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
	$filename = md5(time().$_FILES['file']['name']);
	$filename = $filename .".". $extension;
	
	move_uploaded_file($_FILES['file']['tmp_name'], '../img/banner/'.$filename);
	$sql = "INSERT INTO banner(Image, Link, Position) VALUES(" .
			"'" .$filename. "'," . 
			"'" .$link. "'," . 
			"'" .$position. "')"; 
	DataProvider::executeQuery($sql);
	die("0");
}
function editBanner(){
	$link = addslashes($_POST['link']);
	$position = addslashes($_POST['position']);
	$id = addslashes($_POST['id']);
	$havePic = $_POST['havePic'];
	
	$sql = "UPDATE banner SET" .
		" Link='". $link . "',".
		" POsition='" . $position . "'";
	
	if( $havePic == "true"){
		$extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
		$filename = md5(time().$_FILES['file']['name']);
		$filename = $filename .".". $extension;
		
		move_uploaded_file($_FILES['file']['tmp_name'], '../img/banner/'.$filename);
		$sql .=", Image='".$filename."'";
	}
	
	$sql .=" WHERE ID='" . $id . "';";
	DataProvider::executeQuery($sql);
	die("0");
}
function deleteBanner(){
	$id = addslashes($_POST['id']);
	$sql =" DELETE FROM banner where ID='" . $id . "';";
	DataProvider::executeQuery($sql);
	die("0");
}


?>
