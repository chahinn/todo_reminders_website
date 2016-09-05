<?php

include "base.php";

$ListID = $_POST['ListID'];

$deleteListfromListQuery = "delete from LIST where ListID = '$ListID'";
$deleteListfromSubscriptionQuery= "delete from SUBSCRIPTION where ListID = '$ListID'";
$deleteListfromToDoItemsQuery= "delete from TODOITEMS where ListID = '$ListID'";

$deleteListfromList = mysqli_query($dbc, $deleteListfromListQuery) or die("bad query".mysqli_error($dbc));
$deleteListfromSubscription = mysqli_query($dbc, $deleteListfromSubscriptionQuery) or die("bad query".mysqli_error($dbc));
$deleteListfromToDoItems = mysqli_query($dbc, $deleteListfromToDoItemsQuery) or die("bad query".mysqli_error($dbc));

?>