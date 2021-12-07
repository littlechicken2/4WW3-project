<?php

	$search = trim($_GET['search=']);

	$conn = mysqli_connect("gamgle1.cnpyzludztg5.us-east-2.rds.amazonaws.com:3306", "admin", "#cookies!", "Stores");
	$result = mysqli_query($conn, "SELECT * FROM `Locations` WHERE `Name` LIKE '%$search%'");

	$data = array();
	while ($row = mysqli_fetch_object($result))
	{
	    array_push($data, $row);
	}
	echo json_encode($data);
	exit();
	

?>