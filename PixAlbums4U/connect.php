
<?php
//connect database
$mysqli = new mysqli("localhost","root","","app");
//check connection
if($mysqli->connect_errno){
	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
?>