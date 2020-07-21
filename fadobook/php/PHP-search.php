<?php
session_start();
require_once 'DataProvider.php';

if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
        case 'paginationGetData': paginationGetData();break;
        case 'paginationGetPages': paginationGetPages();break;
    }
}

function paginationGetData(){
    $sortBasic = addslashes($_POST['sortBasic']);
    $searchString = addslashes($_POST['searchString']);
    $numOfItems = addslashes($_POST['numOfItems']);
    $currentPage = addslashes($_POST['currentPage']);

    $sql = "SELECT * FROM product WHERE Name LIKE '%".$searchString."%' AND Status = 0 ";

    switch($sortBasic){
        case "1": $sql.="ORDER BY Name ASC ";break;
        case "2": $sql.="ORDER BY Name DESC ";break;
        case "3": $sql.="ORDER BY Price ASC ";break;
        case "4": $sql.="ORDER BY Price DESC ";break;
    }

    $sql.= " LIMIT ". (($currentPage-1)*$numOfItems) .",".(($currentPage-1)*$numOfItems+$numOfItems);


    $result = DataProvider::executeQuery($sql);
    $allProducts = array();
    while ($row = mysqli_fetch_array($result))
	{
		$allProducts[] = array(
			"ID" => $row['ID'], 
			"Name" => $row['Name'],
			"Price" => $row['Price'],
			"Pic" => $row['Pic']
		);
	}
	echo json_encode($allProducts);
    die;
}
function paginationGetPages(){
    $searchString = addslashes($_POST['searchString']);

    $sql = "SELECT * FROM product WHERE WHERE Name LIKE '%".$searchString."%' AND Status = 0";

    $result = DataProvider::executeQuery($sql);
    $numberOfItems = mysqli_num_rows($result);
    
    echo ($numberOfItems);
    die;
}
?>