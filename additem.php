<?php

require 'twilio-php-master/Services/Twilio.php';

date_default_timezone_set('America/New_York');

$AccountSid = "AC5a25f2d15f42d8240a4dd07d952709b6";
$AuthToken = "a7c5a0a33cf7795b9ef407df605a8f4f";

$client = new Services_Twilio($AccountSid, $AuthToken);

include "base.php";

$ListID = $_POST['ListID'];
$subject = $_POST['subject'];
$description = $_POST['description'];
$dateTimeReminder = $_POST['dateTimeReminder'];

$dueDate = strtotime($dateTimeReminder);
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
$UserID = $_SESSION['UserID'];

$insertToDoItemQuery = "insert into TODOITEMS (ListID, Subject, Description, ReminderDate, CreationDate, Completed) values ('$ListID', '$subject', '$description', '$dateTimeReminder', NOW(), 0)";

//echo "QUERY IS: " . $insertToDoItemQuery;

$insertToDoItemResult = mysqli_query($dbc, $insertToDoItemQuery) or die("bad query".mysqli_error($dbc));

$getPhoneNumberQuery = "select PhoneNumber from USER u, SUBSCRIPTION s where (u.UserID in (select s.UserID from SUBSCRIPTION where s.ListID = $ListID)) and (u.UserID != $UserID)";

$getPhoneNumberResult = mysqli_query($dbc, $getPhoneNumberQuery) or die("bad query".mysqli_error($dbc));

while ($row = mysqli_fetch_array($getPhoneNumberResult)) {
	$number = $row['PhoneNumber'];
	$sms = $client->account->messages->sendMessage("774-462-5075", $number, $fname . " " . $lname . " (" . $uname . ") has created a new TextToDo Reminder:\nSubject: '$subject'\nDescription: '$description'\nThe deadline is: " . $month . " " . $day . ", " . $year . " at " . $hour . ":" . $min . ":" . $sec . " " . $ampm);

	
}

?>