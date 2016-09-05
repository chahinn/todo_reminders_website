<?php

include "base.php";

$ListID = $_POST['ListID'];
$UserName = $_POST['UserName'];

$findUserIDQuery = "select UserID from USER where UserName = '$UserName'";
$getUserIDResult = mysqli_query($dbc, $findUserIDQuery) or die("bad query".mysqli_error($dbc));
$numItems = mysqli_num_rows($getUserIDResult);

if ($numItems == 0) {
	echo "failure";
} else {
	$row = mysqli_fetch_array($getUserIDResult);
	$UserID = $row['UserID'];
	$insertUserQuery = "insert into SUBSCRIPTION (UserID, ListID) values ($UserID, $ListID)";
	//echo "QUERY IS: " . $insertUserQuery;
	$insertUserResult = mysqli_query($dbc, $insertUserQuery) or die("bad query".mysqli_error($dbc));
	echo "success";
}

?>