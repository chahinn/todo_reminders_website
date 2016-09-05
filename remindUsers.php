<?php

require 'twilio-php-master/Services/Twilio.php';

include "base.php";

date_default_timezone_set('America/New_York');

$AccountSid = "AC5a25f2d15f42d8240a4dd07d952709b6";
$AuthToken = "a7c5a0a33cf7795b9ef407df605a8f4f";

$client = new Services_Twilio($AccountSid, $AuthToken);

$chosen = $_POST['chosenTasks'];

$getInfoQuery = "select * from TODOITEMS where ToDoItemID = $chosen";
$getInfoResult = mysqli_query($dbc, $getInfoQuery) or die("bad query".mysqli_error($dbc));
$row = mysqli_fetch_array($getInfoResult);
$subject = $row['Subject'];
$description = $row['Description'];
$reminderDate = $row['ReminderDate'];

$dueDate = strtotime($reminderDate);
$month = date('M', $dueDate);
$day = date('j', $dueDate);
$year = date('Y', $dueDate);
$hour = date('g', $dueDate);
$min = date('i', $dueDate);
$sec = date('s', $dueDate);
$ampm = date('a', $dueDate);

$fname = $_SESSION['FirstName'];
$lname = $_SESSION['LastName'];
$uname = $_SESSION['Username'];

$getPhoneNumberQuery = "select PhoneNumber from TODOITEMS a, LIST b, SUBSCRIPTION c, USER d where a.ToDoItemID in (" . $chosen . ") and a.ListID = b.ListID and b.ListID = c.ListID and c.UserID = d.UserID";

$getPhoneNumberResult = mysqli_query($dbc, $getPhoneNumberQuery) or die("bad query".mysqli_error($dbc));

while ($row = mysqli_fetch_array($getPhoneNumberResult)) {
	$number = $row['PhoneNumber'];
	$sms = $client->account->messages->sendMessage("774-462-5075", $number, "Forced TextToDo Reminder from " . $fname . " " . $lname . " (" . $uname . ")" . ":\nSubject: '$subject'\nDescription: '$description'\nThe deadline is: " . $month . " " . $day . ", " . $year . " at " . $hour . ":" . $min . ":" . $sec . " " . $ampm . ". Don't forget!");
}

?>