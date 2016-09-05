<?php
session_start();
 
$dbc = @mysqli_connect("localhost", "morsejm", "bbt7nGaZ", "morsejm")
	or die("Connect failed: " . mysqli_connect_error());
?>