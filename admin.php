<?php include "base.php"; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">  
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<title>Create an Account</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript" src="js/texttodo.js"></script>

<link rel="stylesheet" href="css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="css/textToDo.css">
</head>  

<body>  
 <div id="admin">
   <h1>Administrator Page</h1>
   <h4>Statistics</h4>
     
   <?php
   		$getNumUsersQuery = "select count(*) from USER";
		$getNumUsersResult = mysqli_query($dbc, $getNumUsersQuery) or die("bad query".mysqli_error($dbc));
		$row = mysqli_fetch_array($getNumUsersResult);
		$numUsers = $row['count(*)'];

		$getNumListsQuery = "select count(*) from LIST";
		$getNumListsResult = mysqli_query($dbc, $getNumListsQuery) or die("bad query".mysqli_error($dbc));
		$row = mysqli_fetch_array($getNumListsResult);
		$numLists = $row['count(*)'];

		$getNumTasksQuery = "select count(*) from TODOITEMS";
		$getNumTasksResult = mysqli_query($dbc, $getNumTasksQuery) or die("bad query".mysqli_error($dbc));
		$row = mysqli_fetch_array($getNumTasksResult);
		$numTasks = $row['count(*)'];

		echo "Number of Users: $numUsers<br>Number of To-Do Lists: $numLists<br>Number of Tasks: $numTasks";
   ?>

   <h4>Reporting</h4>

   <?php
   		$getUsernamesQuery = "select UserID, UserName from USER";
		$getUsernamesResult = mysqli_query($dbc, $getUsernamesQuery) or die("bad query".mysqli_error($dbc));

		echo "<form method='post'><select name='UserNames'>";
		while ($row = mysqli_fetch_array($getUsernamesResult)) {
			echo "<option value='" . $row['UserID'] . "'>" . $row['UserName'] . "</option>";
		}
		echo "</select>&nbsp;<input type='submit' name='submit' value='Go' /></form>";

		if(isset($_POST['submit'])) {
			$UserID = $_POST['UserNames'];

			$getNameQuery = "select * from USER where UserID = '$UserID'";
			$getNameResult = mysqli_query($dbc, $getNameQuery) or die("bad query".mysqli_error($dbc));
			$row = mysqli_fetch_array($getNameResult);
			$fname = $row['FirstName'];
			$lname = $row['LastName'];
			$uname = $row['UserName'];

			$getUserInfoQuery = "select count(*) from SUBSCRIPTION where UserID = '$UserID'";
			$getUserInfoResult = mysqli_query($dbc, $getUserInfoQuery) or die("bad query".mysqli_error($dbc));
			$row = mysqli_fetch_array($getUserInfoResult);
			$numSubs = $row['count(*)'];
			echo $fname . " " . $lname . " (" . $uname . ") is currently subscribed to $numSubs to-do lists!";
		}

		$getMaxUserQuery = "select UserID, count(*) as magnitude from SUBSCRIPTION group by UserID order by magnitude desc limit 1";
		$getMaxUserResult = mysqli_query($dbc, $getMaxUserQuery) or die("bad query".mysqli_error($dbc));
		$row = mysqli_fetch_array($getMaxUserResult);
		$UserID = $row['UserID'];
		$amount = $row['magnitude'];
		$getNameQuery = "select * from USER where UserID = '$UserID'";
		$getNameResult = mysqli_query($dbc, $getNameQuery) or die("bad query".mysqli_error($dbc));
		$row = mysqli_fetch_array($getNameResult);
		$fnamemax = $row['FirstName'];
		$lnamemax = $row['LastName'];
		$unamemax = $row['UserName'];
		echo "<br>" . $fnamemax . " " . $lnamemax . " (" . $unamemax . ") is currently subscribed to the most to-do lists! ($amount)";
   ?>

   <h4>Day &amp; Time</h4>

   <?php

   		$getMondayQuery = "select count(*) from TODOITEMS where WEEKDAY(ReminderDate) = 0";
		$getMondayResult = mysqli_query($dbc, $getMondayQuery) or die("bad query".mysqli_error($dbc));
		$row1 = mysqli_fetch_array($getMondayResult);
		$mondayCount = $row1['count(*)'];

		$getTuesdayQuery = "select count(*) from TODOITEMS where WEEKDAY(ReminderDate) = 1";
		$getTuesdayResult = mysqli_query($dbc, $getTuesdayQuery) or die("bad query".mysqli_error($dbc));
		$row2 = mysqli_fetch_array($getTuesdayResult);
		$tuesdayCount = $row2['count(*)'];

		$getWednesdayQuery = "select count(*) from TODOITEMS where WEEKDAY(ReminderDate) = 2";
		$getWednesdayResult = mysqli_query($dbc, $getWednesdayQuery) or die("bad query".mysqli_error($dbc));
		$row3 = mysqli_fetch_array($getWednesdayResult);
		$wednesdayCount = $row3['count(*)'];

		$getThursdayQuery = "select count(*) from TODOITEMS where WEEKDAY(ReminderDate) = 3";
		$getThursdayResult = mysqli_query($dbc, $getThursdayQuery) or die("bad query".mysqli_error($dbc));
		$row4 = mysqli_fetch_array($getThursdayResult);
		$thursdayCount = $row4['count(*)'];

		$getFridayQuery = "select count(*) from TODOITEMS where WEEKDAY(ReminderDate) = 4";
		$getFridayResult = mysqli_query($dbc, $getFridayQuery) or die("bad query".mysqli_error($dbc));
		$row5 = mysqli_fetch_array($getFridayResult);
		$fridayCount = $row5['count(*)'];

		$getSaturdayQuery = "select count(*) from TODOITEMS where WEEKDAY(ReminderDate) = 5";
		$getSaturdayResult = mysqli_query($dbc, $getSaturdayQuery) or die("bad query".mysqli_error($dbc));
		$row6 = mysqli_fetch_array($getSaturdayResult);
		$saturdayCount = $row6['count(*)'];

		$getSundayQuery = "select count(*) from TODOITEMS where WEEKDAY(ReminderDate) = 6";
		$getSundayResult = mysqli_query($dbc, $getSundayQuery) or die("bad query".mysqli_error($dbc));
		$row7 = mysqli_fetch_array($getSundayResult);
		$sundayCount = $row7['count(*)'];

		echo "Breakdown of reminder dates by weekday:<ul><li>Monday: $mondayCount</li><li>Tuesday: $tuesdayCount</li><li>Wednesday: $wednesdayCount</li><li>Thursday: $thursdayCount</li><li>Friday: $fridayCount</li><li>Saturday: $saturdayCount</li><li>Sunday: $sundayCount</li></ul>";

		$getMorningQuery = "select count(*) from TODOITEMS where TIME(ReminderDate) < '12:00:00'";
		$getMorningResult = mysqli_query($dbc, $getMorningQuery) or die("bad query".mysqli_error($dbc));
		$row8 = mysqli_fetch_array($getMorningResult);
		$morningCount = $row8['count(*)'];

		$getAfternoonQuery = "select count(*) from TODOITEMS where TIME(ReminderDate) >= '12:00:00'";
		$getAfternoonResult = mysqli_query($dbc, $getAfternoonQuery) or die("bad query".mysqli_error($dbc));
		$row9 = mysqli_fetch_array($getAfternoonResult);
		$afternoonCount = $row9['count(*)'];

		echo "Breakdown of reminder dates by time of day:<ul><li>Before noon: $morningCount</li><li>After noon: $afternoonCount</li></ul>";
   ?>

   <h4>Search</h4>

   Search for number of keyword appearances: <form method="post"><input type="text" name="searchterm" id="searchterm" /> <input type="submit" name="submitsearch" value="Go" /></form>

   <?php

   		if (isset($_POST['submitsearch'])) {
   			$keyword = strtolower($_POST['searchterm']);
   			$getKeywordQuery = "select count(*) from TODOITEMS where (lower(Subject) like '%$keyword%') or (lower(Description) like '%$keyword%')";
			$getKeywordResult = mysqli_query($dbc, $getKeywordQuery) or die("bad query".mysqli_error($dbc));
			$row = mysqli_fetch_array($getKeywordResult);
			$keywordCount = $row['count(*)'];
			echo "The keyword '$keyword' has been used in $keywordCount to-do items!";
   		}

   ?>

   <br>

   <a href="index.php">Go back</a> to the homepage!

</div>

</body>
</html>