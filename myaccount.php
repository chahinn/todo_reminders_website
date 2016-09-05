<?php

### insert new query into table ###

$dbc = @mysqli_connect("localhost", "morsejm", "bbt7nGaZ", "morsejm")
	or die("Connect failed: " . mysqli_connect_error());

$userName = $_POST['inputusername'];
$password = sha1($_POST['inputpassword']);

$checkUsernameQuery = "select UserName from USER where UserName='$userName'";
$usernameResult = mysqli_query($dbc, $checkUsernameQuery);

$checkPasswordQuery = "select Password from USER where UserName='$userName'";
$passwordResult = mysqli_query($dbc, $checkPasswordQuery);
$row = mysqli_fetch_array($passwordResult, MYSQLI_NUM);

$storedPassword = $row[0];

if (mysqli_num_rows($usernameResult) == 0) {
	echo "That username is not registered!";
} else if ($storedPassword != $password) {
	echo "That password is incorrect!";
} else {
	$getNameQuery = "select FirstName, LastName from USER where UserName='$userName'";
	$nameResult = mysqli_query($dbc, $getNameQuery);
	$row2 = mysqli_fetch_array($nameResult, MYSQLI_NUM);
	$fname = $row2[0];
	$lname = $row2[1];
	echo $fname . " " . $lname . " is logged in!";
}

mysqli_close($dbc);

?>