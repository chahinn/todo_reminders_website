<?php

include "base.php";

$listName = $_POST['listName'];
$UserID = $_SESSION['UserID'];

$insertListQuery = "insert into LIST (ListName, CreationDate) values ('$listName', NOW())";
$insertListResult = mysqli_query($dbc, $insertListQuery) or die("bad query".mysqli_error($dbc));

$getListIDQuery = "select ListID from LIST where ListName = '$listName' and CreationDate = (select max(CreationDate) from LIST where ListName = '$listName')";
$getListIDResult = mysqli_query($dbc, $getListIDQuery) or die("bad query".mysqli_error($dbc));
$numItems = mysqli_num_rows($getListIDResult);

$row = mysqli_fetch_array($getListIDResult);

$ListID = $row['ListID'];

$insertSubscriptionQuery = "insert into SUBSCRIPTION (UserID, ListID) values ('$UserID','$ListID')";
$insertSubscriptionResult = mysqli_query($dbc, $insertSubscriptionQuery) or die("bad query".mysqli_error($dbc));

echo $ListID;

?>