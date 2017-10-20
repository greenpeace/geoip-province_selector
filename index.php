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



########## MySql details (Replace with yours) #############
$db_username = "greenpeace"; //Database Username
$db_password = "warroom138"; //Database Password
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

$qry="select country_name,country_code from world_country order by country_name";
$result = $conn->prepare($qry);
$result->execute();
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
				



$cb=$_REQUEST['callback'];
//echo "$cb({\"list\":'$op'})";
echo "$cb({\"list\":\"$op\"})";

/*
$cb=$_REQUEST['callback'];
echo "$cb({\"country\":\"$country\",\"region\":\"$region\",\"city\":\"$city\"})";
*/