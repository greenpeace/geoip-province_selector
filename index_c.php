<?php


require_once 'vendor/autoload.php';
use GeoIp2\Database\Reader;

$reader = new Reader('./GeoLite2-City.mmdb');

if ($_REQUEST['ip']){$record=$reader->city($_REQUEST['ip']);}
else {
	$record=$reader->city($_SERVER['REMOTE_ADDR']);

	}

$country_code=$record->country->isoCode; // 'US'

$region=$record->mostSpecificSubdivision->isoCode; // 'MN'

$city=$record->city->name; // 'Minneapolis'


//$country_code="TH";
//$region="10";

########## MySql details (Replace with yours) #############
$db_username = "dbuser"; //Database Username
$db_password = "dbpassword"; //Database Password
$hostname = "127.0.0.1"; //Mysql Hostname
$db_name = 'dbname'; //Database Name
###################################################################
try {
$conn = new PDO("mysql:host=$hostname; dbname=$db_name", $db_username, $db_password);
$conn->exec("set names utf8");//    echo "Connected to database";
}
catch (PDOException $e) {
    echo $e->getMessage();
}

$qry="select country_name,country_code from world_country order by country_name";
$result = $conn->prepare($qry);
$result->execute();
$p_op=$op="<option value=''>Please select</option>";
if ($result !== false) { 
	foreach($result as $row) {
		if (strtoupper($row['country_code'])==strtoupper($country_code)){
			$op.="<option value='".$row['country_code']."' selected='selected'>".$row['country_name']."</option>";
			}
		else{
			$op.="<option value='".$row['country_code']."'>".$row['country_name']."</option>";
			}
		}
	}
				

$qry="select province_name,province_code from world_province where country_code='".$country_code."' order by province_name";
$result = $conn->prepare($qry);
$result->execute();

if ($result !== false) { 
	foreach($result as $row) {
		if (strtoupper($region)==strtoupper($row['province_code'])){
			$p_op.="<option value='".$row['province_code']."' selected='selected'>".$row['province_name']."</option>";
			}
		else {
			$p_op.="<option value='".$row['province_code']."' >".$row['province_name']."</option>";
			}
		}
	}


$cb=$_REQUEST['callback'];

echo "$cb({\"list\":\"$op\",\"province\":\"$p_op\"})";
