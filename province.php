<?php
########## MySql details (Replace with yours) #############
$db_username = "greenpeace"; 
$db_password = "warroom138";		
$hostname = "127.0.0.1"; //Mysql Hostname
$db_name = 'greenpeace'; //Database Name
###################################################################

try {
$conn = new PDO("mysql:host=$hostname; dbname=$db_name", $db_username, $db_password);
$conn->exec("set names utf8");//    echo "Connected to database";
}
catch (PDOException $e) {
    echo $e->getMessage();
}


if ($_REQUEST['m']=="province"){
	$country_code=$_GET['country_code'];
	$qry="select province_name,province_code from world_province where country_code='".$country_code."' order by province_name";
	$result = $conn->prepare($qry);
	$result->execute();
	$count=$result->rowCount();
	if ($result !== false) { 
		if ($count > 1){
			$p_op.="<option value=''>Please select</option>";
			}
		foreach($result as $row) {
			$p_op.="<option value='".$row['province_code']."' >".$row['province_name']."</option>";
			}
		}
	}

$cb=$_REQUEST['callback'];
//echo "$cb({\"list\":'$op'})";
echo "$cb({\"province\":\"$p_op\"})";


//$callback = isset($_GET['callback']) ? preg_replace('/[^a-z0-9$_]/si', '', $_GET['callback']) : false;
//header('Content-Type: ' . ($callback ? 'application/javascript' : 'application/json') . ';charset=UTF-8');

//echo $body;

?>