<?php
session_start();
require_once 'DataProvider.php';
if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
		case 'login': login();break;
		case 'logout': logout();break;
		case 'signup': signup();break;
		case 'saveInfo': saveInfo();break;
		case 'changePassword': changePassword();break;
		case 'showDetailBill': showDetailBill();break;
		case 'showProductsBill': showProductsBill();break;
		
    }
}
function login(){

	$email = addslashes($_POST['email']);
	$password = addslashes($_POST['password']);
	
	$sql = "SELECT * FROM user WHERE Email='". $email ."' AND Password = '". $password ."'";
	$result = DataProvider::executeQuery($sql);
	if( mysqli_num_rows($result) == 0 ) {
		die("1");
	} else {
		while ($row = mysqli_fetch_array($result))
		{
			if($row['Status'] == 1){
				die("2");
			}
			$loginInformation = array('Email'=>$row['Email'], 'Name'=>$row['Name']);
		}
		$_SESSION["isLoginUser"] = array($loginInformation);
		die("0");
	}
	
}

function signup(){
	$name = addslashes($_POST['name']);
	$email = addslashes($_POST['email']);
	$password = addslashes($_POST['password']);
	
	$sql = "SELECT * FROM user WHERE Email='". $email ."'";
	$result = DataProvider::executeQuery($sql);
	if( mysqli_num_rows($result) != 0 ) {
		die("1");
	}

	$sql = "INSERT INTO user(Name, Email, Password) VALUES(" .
			"'" .$name. "'," . 
			"'" .$email. "'," . 
			"'" .$password. "')";
	$result = DataProvider::executeQuery($sql);
	$loginInformation = array('Email'=>$email, 'Name'=>$name);
	$_SESSION["isLoginUser"] = array($loginInformation);
	die("0");
}

function logout(){
	unset($_SESSION["isLoginUser"]);
	die("0");
}

function saveInfo(){
	if(!isset($_SESSION['isLoginUser'])){
		die("1");
	} 

	$email = "";

	foreach($_SESSION['isLoginUser'] as $k => $v){
		$email =  $_SESSION['isLoginUser'][$k]['Email'];
	}

	$name = addslashes($_POST['name']);
	$phone = addslashes($_POST['phone']);
	$address = addslashes($_POST['address']);
	
	$sql = "UPDATE user SET" .
		" Name='". $name . "',".
		" Phone='". $phone . "',".
		" Address='". $address . "'".
		" WHERE	Email='" . $email . "';";
	DataProvider::executeQuery($sql);
	die("0");
}

function changePassword(){
	if(!isset($_SESSION['isLoginUser'])){
		die("1");
	} 

	$email = "";
	foreach($_SESSION['isLoginUser'] as $k => $v){
		$email =  $_SESSION['isLoginUser'][$k]['Email'];
	}

	$oldPassword = addslashes($_POST['oldPassword']);
	$newPassword = addslashes($_POST['newPassword']);
	
	$sql = "SELECT * FROM user WHERE Email='". $email ."' AND Password = '". $oldPassword ."'";
	$result = DataProvider::executeQuery($sql);
	if( mysqli_num_rows($result) == 0 ) {
		die("2");
	} 
	
	$sql = "UPDATE user SET" .
		" Password='". $newPassword . "'".
		" WHERE	Email='" . $email . "';";
	DataProvider::executeQuery($sql);
	die("0");
}

function showDetailBill(){
	if(isset($_SESSION['isLoginUser'])){
		$email = "";
		foreach($_SESSION['isLoginUser'] as $k => $v){
			$email =  $_SESSION['isLoginUser'][$k]['Email'];
		}
	} else {
		die("1");
	}

	$id = addslashes($_POST['id']);
	
	$sql = "SELECT * FROM bill WHERE user='". $email ."' AND ID = '". $id  ."'";
	$result = DataProvider::executeQuery($sql);
	if( mysqli_num_rows($result) == 0 ) {
		die("2");
	} else {
		while ($row = mysqli_fetch_array($result))
		{
			$infoBill = array(
				"Quantity" => $row['Quantity'],
				"Total" => $row['Total'],
				"Name" => $row['Name'], 
				"Phone" => $row['Phone'],
				"Address" => $row['Address'],
				"Time" => $row['Time'],
				"Note" => $row['Note'],
				"Status" => $row['Status']
			);
		}
		echo json_encode($infoBill);
    	die;
	}
	
}

function showProductsBill(){
	$id = addslashes($_POST['id']);
	
	$sql = "SELECT DISTINCT p.*, bd.Quantity as 'bdQuantity' FROM product as p JOIN billdetail as bd on p.ID = bd.ProductID WHERE p.ID IN (SELECT ProductID FROM billdetail WHERE BillID = '".$id."') AND bd.BillID = '".$id."'";
	$result = DataProvider::executeQuery($sql);
	$productsBill= array();
	while ($row = mysqli_fetch_array($result))
	{
		$productsBill[] = array(
			"ID" => $row['ID'],
			"Name" => $row['Name'],
			"Pic" => $row['Pic'], 
			"Price" => $row['Price'],
			"Quantity" => $row['bdQuantity']
		);
	}
	echo json_encode($productsBill);
	die;
	
}
?>
