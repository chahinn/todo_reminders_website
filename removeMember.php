<?php

include "base.php";

$UserID = $_POST['UserID'];
$ListID = $_POST['ListID'];

$deleteListfromListQuery = "delete from SUBSCRIPTION where ListID = '$ListID' and UserID = '$UserID'";
$deleteListfromList = mysqli_query($dbc, $deleteListfromListQuery) or die("bad query".mysqli_error($dbc));

?>