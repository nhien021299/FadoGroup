<?php
require_once 'DataProvider.php';
if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
		case 'productChart': productChart();break;
		case 'billChart': billChart();break;
		
    }
}

function productChart(){
	$dateTo = addslashes($_POST['dateTo']);
	$dateFrom = addslashes($_POST['dateFrom']);
	$type = addslashes($_POST['type']);
	$sql = "SELECT SUM(bd.Quantity) AS Quantity, p.Name, p.Price FROM product as p join billdetail as bd on p.ID = bd.ProductID join bill as b on bd.BillID = b.ID WHERE b.Status != 3 ";
	
	if ($type != ""){
		$sql .="AND p.Type ='".$type."'";
	}
	if ($dateFrom != ""){
		$sql .="AND b.Time >='".$dateFrom."'";
	}
	if ($dateTo != ""){
		$sql .="AND b.Time <='".$dateTo."'";
	}
	$sql .=" GROUP BY p.Name";
	$result=DataProvider::executeQuery($sql);
	$chart = array();
    while ($row = mysqli_fetch_array($result))
	{
		$chart[] = array(
			"y" => $row['Quantity'], 
			"label" => $row['Name'],
			"Price" => $row['Price']
		);
	}
	echo json_encode($chart);
    die;
}

function billChart(){
	$dateTo = addslashes($_POST['dateTo']);
	$dateFrom = addslashes($_POST['dateFrom']);
	$sql = "SELECT COUNT(*) as Count,
			CASE 
				WHEN Status = 1 THEN 'Chờ xử lý'
				WHEN Status = 2 THEN 'Đã xử lý'
				WHEN Status = 3 THEN 'Đã hủy'
			END AS Status
			FROM bill WHERE 1 ";
	if ($dateFrom != ""){
		$sql .="AND Time >='".$dateFrom."'";
	}
	if ($dateTo != ""){
		$sql .="AND Time <='".$dateTo."'";
	}
	$sql .=" GROUP BY Status";
	$result=DataProvider::executeQuery($sql);
	$chart = array();
    while ($row = mysqli_fetch_array($result))
	{
		$chart[] = array(
			"y" => $row['Count'], 
			"label" => $row['Status']
		);
	}
	echo json_encode($chart);
    die;
}

?>
