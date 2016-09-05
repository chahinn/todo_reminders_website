<?php

include "base.php";

$subject = $_POST['subject'];
$description = $_POST['description'];
$dateTimeReminder = $_POST['dateTimeReminder'];
$taskID = $_POST['taskID'];

$updateToDoItemQuery = "update TODOITEMS set Subject='$subject', Description='$description', ReminderDate='$dateTimeReminder' where ToDoItemID = '$taskID'";

//echo "QUERY IS: " . $insertToDoItemQuery;

$updateToDoItemResult = mysqli_query($dbc, $updateToDoItemQuery) or die("bad query".mysqli_error($dbc));

?>