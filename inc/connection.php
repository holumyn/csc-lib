<?php
require("constants.php");

//creating a db connection
$connection=mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
if(!$connection) {
	die("Database connection failed: " . mysqli_connect_error());
}


?>