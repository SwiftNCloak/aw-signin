<?php 
	$user ="root";
	$pass ="";
	$server="localhost";
	$dbname="records";

	$conn = new mysqli($server,$user,$pass,$dbname);
	if($conn->connect_error){
		die("Connection Error: ".$conn->connect_error);
	}
?>