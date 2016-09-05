<?php

include "base.php";

date_default_timezone_set('America/New_York');

$TaskID = $_POST['TaskID'];

$findTaskIDQuery = "select * from TODOITEMS where ToDoItemID = '$TaskID'";
$getTaskIDResult = mysqli_query($dbc, $findTaskIDQuery) or die("bad query".mysqli_error($dbc));

$row = mysqli_fetch_array($getTaskIDResult);
$Subject = $row['Subject'];
$Description = $row['Description'];
$ReminderDate = $row['ReminderDate'];

$time = strtotime($ReminderDate);
$year = date('Y', $time);
$month = date('m', $time);
$day = date('d', $time);
$hour = date('H', $time);
$minute = date('i', $time);
$second = date('s', $time);

echo '{"Subject": "' . $Subject . '", "Description": "' . $Description . '", "Year": "' . $year . '", "Month": "' . $month . '", "Day": "' . $day . '", "Hour": "' . $hour . '", "Minute": "' . $minute . '", "Second": "' . $second . '"}';

?>