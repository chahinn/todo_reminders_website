<?php include "base.php"; ?>

<html>
<head>

<title>TextToDo</title>

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

<?php

if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username'])) {

?>
	<div id="main">
	<div id="banner">
	<div class="west">
	<h2>TextToDo</h2>
	</div>
	<div class="east">
	Hello, <?php echo $_SESSION['FirstName']?>!&nbsp;&nbsp;
	<input type="button" name="homebtn" id="homebtn" value="Home" />
	<input type="button" name="logoutbtn" id="logoutbtn" value="Logout" />
	</div><!--
	--></div>
	<div id="leftnav" class="west">

	<div id="yourlists">
	<h3>Your Lists</h3>
	<p id="listOfLists">

	<?php 
		$UserName = $_SESSION['Username'];
		$UserIDquery = "select UserID from USER where UserName = '$UserName'";
		$getUserID = mysqli_query($dbc, $UserIDquery);
		$row = mysqli_fetch_array($getUserID);
		$UserID = $row['UserID'];
		$_SESSION['UserID'] = $UserID;

		echo "<input type='hidden' name='HiddenUserID' id='HiddenUserID' value='$UserID'>";

		$getListsQuery = "select l.ListID, ListName from LIST l, SUBSCRIPTION s where s.UserID = $UserID and l.ListID = s.ListID";
		$getLists = mysqli_query($dbc, $getListsQuery);
		$numLists = mysqli_num_rows($getLists);

		if ($numLists == 0) {
			echo "You don't have any lists! Click the button below to create a new one.";
		} else {
			echo "<ul>";
			while ($row = mysqli_fetch_array($getLists)) {
				echo "<li><a href='index.php?ListID=" . $row["ListID"] . "'>" . $row["ListName"] . "</a></li>";
			}
			echo "</ul>";
		}
		
	?>

	</p>

	
	<input type="button" name ="addlistbtn" id="addlistbtn" value="Add a To-Do List!"/>

	<br><br>
	
	<fieldset id="addListFieldset" class="invisible">
    	<legend>Enter List Information</legend>
	    <form method="post">
	    List Name: <input pattern=".{1,15}" required title="1 to 15 characters" type="text" name="listnametxt" id="listnametxt" /><br><br>
	    <input type="submit" name="submitlistbtn" id="submitlistbtn" value="Create List!" /> <input type="button" id="cancellistbtn" value="Cancel" />
	    </form>
    </fieldset>

    </div>

    <div id="members">
    
    <?php

    if (isset($_GET["ListID"])) {
    	$ListID = $_GET["ListID"];
    	$getSubscribersQuery = "select UserName from USER where UserID in (select UserID from SUBSCRIPTION where ListID = '$ListID')";
    	$getSubscribers = mysqli_query($dbc, $getSubscribersQuery);
		$numSubscribers = mysqli_num_rows($getSubscribers);

		if ($numSubscribers == 0) {
			echo "This list has no subscribers!";
		} else {
			echo "<h3>Subscribed Users</h3>";
			echo "<ul>";
			while ($row = mysqli_fetch_array($getSubscribers)) {
				echo "<li>" . $row["UserName"] . "</li>";
			}
			echo "</ul>";
			echo "<input type='button' name ='addpersontolistbtn' id='addpersontolistbtn' value='Add User to List!'/>&nbsp;<input type='button' name ='leavelistbtn' id='leavelistbtn' value='Leave List!'/>";
		}
    }

    ?>

    <br><br>

    <fieldset id="addpersonFieldset" class="invisible">
    	<legend>Enter Username Information</legend>
	    <form method="post">
	    Username: <input type="text" name="usernametxt" id="usernametxt" /><br><br>
	    <input type="submit" name="submitpersonbtn" id="submitpersonbtn" value="Add User!" /> <input type="button" id="cancelpersonbtn" value="Cancel" />
	    </form>
    </fieldset>

    </div>

	</div><!--

	--><div id="content" class="east">

	<?php 

		date_default_timezone_set('America/New_York');

		if (isset($_GET["ListID"])) {

			$selectedList = $_GET["ListID"];

			echo "<input type='hidden' name='HiddenListID' id='HiddenListID' value='$selectedList'>";

			$nameQuery = "select ListName from LIST where ListID = '$selectedList'";
			$getName = mysqli_query($dbc, $nameQuery);
			$row = mysqli_fetch_array($getName);

			?>
			<h1><?php echo $row['ListName']?></h1>  <br>  
			<div class="west">
			<input type="button" name ="additembtn" id="additembtn" value="Add a To-Do Item!"/>
			<input type="button" name ="completetasksbtn" id="completetasksbtn" value="Mark Selected Complete!"/>
			<input type="button" name ="incompletetasksbtn" id="incompletetasksbtn" value="Mark Selected Incomplete!"/>
			<input type="button" name ="remindbtn" id="remindbtn" value="Remind Members Now!"/>
			<input type="button" name ="updateitembtn" id="updateitembtn" value="Update Selected Item!"/>
			</div>
			<div class="east">
			<input type="button" name ="deletelistbtn" id="deletelistbtn" value="Delete Current List!" class="btn-danger btn-md"/>
			</div>

			<br><br>

			<fieldset id="addtodoitemFieldset" class="invisible">
		    	<legend>Enter To Do Item Information</legend>
			    <form method="post">
			    Subject: <input type="text" name="subjecttxt" id="subjecttxt" /><br>
			    Description: <br><textarea name="descriptiontxt" id="descriptiontxt" cols=40 rows=6></textarea><br>
			    Reminder Date:<br>Month 

			    <select name="chooseMonth" id="chooseMonth">
					<option value='01'>January</option>
					<option value='02'>February</option>
					<option value='03'>March</option>
					<option value='04'>April</option>
					<option value='05'>May</option>
					<option value='06'>June</option>
					<option value='07'>July</option>
					<option value='08'>August</option>
					<option value='09'>September</option>
					<option value='10'>October</option>
					<option value='11'>November</option>
					<option value='12'>December</option>
				</select>

				
				Day

				<select name="chooseDay" id="chooseDay">
					<option value='01'>01</option>
					<option value='02'>02</option>
					<option value='03'>03</option>
					<option value='04'>04</option>
					<option value='05'>05</option>
					<option value='06'>06</option>
					<option value='07'>07</option>
					<option value='08'>08</option>
					<option value='09'>09</option>
					<option value='10'>10</option>
					<option value='11'>11</option>
					<option value='12'>12</option>
					<option value='13'>13</option>
					<option value='14'>14</option>
					<option value='15'>15</option>
					<option value='16'>16</option>
					<option value='17'>17</option>
					<option value='18'>18</option>
					<option value='19'>19</option>
					<option value='20'>20</option>
					<option value='21'>21</option>
					<option value='22'>22</option>
					<option value='23'>23</option>
					<option value='24'>24</option>
					<option value='25'>25</option>
					<option value='26'>26</option>
					<option value='27'>27</option>
					<option value='28'>28</option>
					<option value='29'>29</option>
					<option value='30'>30</option>
					<option value='31'>31</option>
				</select>

				
				Year <input type="text" name="chooseYear" size="4" id="chooseYear" />

				<br>

				Hour
				<select name="chooseHour" id="chooseHour">
					<option value='00'>12 am</option>
					<option value='01'>1 am</option>
					<option value='02'>2 am</option>
					<option value='03'>3 am</option>
					<option value='04'>4 am</option>
					<option value='05'>5 am</option>
					<option value='06'>6 am</option>
					<option value='07'>7 am</option>
					<option value='08'>8 am</option>
					<option value='09'>9 am</option>
					<option value='10'>10 am</option>
					<option value='11'>11 am</option>
					<option value='12'>12 pm</option>
					<option value='13'>1 pm</option>
					<option value='14'>2 pm</option>
					<option value='15'>3 pm</option>
					<option value='16'>4 pm</option>
					<option value='17'>5 pm</option>
					<option value='18'>6 pm</option>
					<option value='19'>7 pm</option>
					<option value='20'>8 pm</option>
					<option value='21'>9 pm</option>
					<option value='22'>10 pm</option>
					<option value='23'>11 pm</option>
				</select>


				Minute
				<select name="chooseMinute" id="chooseMinute">
				<?php 
					$x = 0;
					while ($x < 60) {
						echo "<option value='" . $x . "'>" . $x . "</option>";
						$x++;
					}
				?>
				</select>

				Seconds
				<select name="chooseSeconds" id="chooseSeconds">
				<?php 
					$y = 0;
					while ($y < 60) {
						echo "<option value='" . $y . "'>" . $y . "</option>";
						$y++;
					}
				?>
				</select>

				<br><br>


			    <input type="submit" name="submittodobtn" id="submittodobtn" value="Add To Do Item!" /> <input type="button" id="canceltodobtn" value="Cancel" />
			    </form>
		    </fieldset>

		    &nbsp;&nbsp;&nbsp;&nbsp;

		    <fieldset id="updateItemFieldset" class="invisible">
		    	<legend>Update Task Information</legend>
			    <form method="post">
			    New Subject: <input type="text" name="newsubjecttxt" id="newsubjecttxt" /><br>
			    New Description: <br><textarea name="newdescriptiontxt" id="newdescriptiontxt" cols=40 rows=6></textarea><br>
			    New Reminder Date:<br> <!--<input type="text" name="newdatetimereminder" id="newdatetimereminder" />-->

			    Month 

			    <select name="newchooseMonth" id="newchooseMonth">
					<option value='01'>January</option>
					<option value='02'>February</option>
					<option value='03'>March</option>
					<option value='04'>April</option>
					<option value='05'>May</option>
					<option value='06'>June</option>
					<option value='07'>July</option>
					<option value='08'>August</option>
					<option value='09'>September</option>
					<option value='10'>October</option>
					<option value='11'>November</option>
					<option value='12'>December</option>
				</select>

				
				Day

				<select name="newchooseDay" id="newchooseDay">
					<option value='01'>01</option>
					<option value='02'>02</option>
					<option value='03'>03</option>
					<option value='04'>04</option>
					<option value='05'>05</option>
					<option value='06'>06</option>
					<option value='07'>07</option>
					<option value='08'>08</option>
					<option value='09'>09</option>
					<option value='10'>10</option>
					<option value='11'>11</option>
					<option value='12'>12</option>
					<option value='13'>13</option>
					<option value='14'>14</option>
					<option value='15'>15</option>
					<option value='16'>16</option>
					<option value='17'>17</option>
					<option value='18'>18</option>
					<option value='19'>19</option>
					<option value='20'>20</option>
					<option value='21'>21</option>
					<option value='22'>22</option>
					<option value='23'>23</option>
					<option value='24'>24</option>
					<option value='25'>25</option>
					<option value='26'>26</option>
					<option value='27'>27</option>
					<option value='28'>28</option>
					<option value='29'>29</option>
					<option value='30'>30</option>
					<option value='31'>31</option>
				</select>

				
				Year <input type="text" name="newchooseYear" size="4" id="newchooseYear" />

				<br>

				Hour
				<select name="newchooseHour" id="newchooseHour">
					<option value='00'>12 am</option>
					<option value='01'>1 am</option>
					<option value='02'>2 am</option>
					<option value='03'>3 am</option>
					<option value='04'>4 am</option>
					<option value='05'>5 am</option>
					<option value='06'>6 am</option>
					<option value='07'>7 am</option>
					<option value='08'>8 am</option>
					<option value='09'>9 am</option>
					<option value='10'>10 am</option>
					<option value='11'>11 am</option>
					<option value='12'>12 pm</option>
					<option value='13'>1 pm</option>
					<option value='14'>2 pm</option>
					<option value='15'>3 pm</option>
					<option value='16'>4 pm</option>
					<option value='17'>5 pm</option>
					<option value='18'>6 pm</option>
					<option value='19'>7 pm</option>
					<option value='20'>8 pm</option>
					<option value='21'>9 pm</option>
					<option value='22'>10 pm</option>
					<option value='23'>11 pm</option>
				</select>


				Minute
				<select name="newchooseMinute" id="newchooseMinute">
				<?php 
					$x = 0;
					while ($x < 60) {
						echo "<option value='" . $x . "'>" . $x . "</option>";
						$x++;
					}
				?>
				</select>

				Seconds
				<select name="newchooseSeconds" id="newchooseSeconds">
				<?php 
					$y = 0;
					while ($y < 60) {
						echo "<option value='" . $y . "'>" . $y . "</option>";
						$y++;
					}
				?>
				</select>

			    <br><br>
			    <input type="submit" name="submitupdatedtodobtn" id="submitupdatedtodobtn" value="Update Task!" /> <input type="button" id="cancelupdatedtodobtn" value="Cancel" />
			    </form>
		    </fieldset>

			<?php

			$getToDoItemsQuery = "select * from TODOITEMS where ListID = '$selectedList' and Completed = 0";
			$getItems = mysqli_query($dbc, $getToDoItemsQuery);
			$numItems = mysqli_num_rows($getItems);
			echo "<br><h3>Incomplete Tasks</h3>";
			if ($numItems == 0) {
				echo "There are no incomplete items!";
			} else {
				echo "<ul class='tasksList'>";
				while ($row = mysqli_fetch_array($getItems)) {
					$dueDate = strtotime($row['ReminderDate']);
					$month = date('M', $dueDate);
					$day = date('j', $dueDate);
					$year = date('Y', $dueDate);
					$hour = date('g', $dueDate);
					$min = date('i', $dueDate);
					$sec = date('s', $dueDate);
					$ampm = date('a', $dueDate);

					echo "<li><input type='checkbox' name='todoitemsid' value='" . $row['ToDoItemID'] . "'>&nbsp;<b>Subject</b>:&nbsp;" . $row['Subject'] . ", <b>Description</b>:&nbsp;" . $row['Description'] . ", <b>Due Date</b>:&nbsp;" . $month . "&nbsp;" . $day . ", " . $year . "&nbsp;at&nbsp;" . $hour . ":" . $min . ":" . $sec . "&nbsp;" . $ampm . "</li>"; 
				}
				echo "</ul>";
			}

			echo "<br>";

			$getToDoItemsCompleteQuery = "select * from TODOITEMS where ListID = '$selectedList' and Completed = 1";
			$getItemsComplete = mysqli_query($dbc, $getToDoItemsCompleteQuery);
			$numItemsComplete = mysqli_num_rows($getItemsComplete);
			echo "<h3>Complete Tasks</h3>";
			if ($numItemsComplete == 0) {
				echo "There are no completed items!";
			} else {
				echo "<ul class='tasksList'>";
				while ($rowCompleted = mysqli_fetch_array($getItemsComplete)) {
					$dueDate = strtotime($rowCompleted['ReminderDate']);
					$month = date('M', $dueDate);
					$day = date('j', $dueDate);
					$year = date('Y', $dueDate);
					$hour = date('g', $dueDate);
					$min = date('i', $dueDate);
					$sec = date('s', $dueDate);
					$ampm = date('a', $dueDate);

					echo "<li><input type='checkbox' name='todoitemsid' value='" . $rowCompleted['ToDoItemID'] . "'>&nbsp;<b>Subject</b>:&nbsp;" . $rowCompleted['Subject'] . ", <b>Description</b>:&nbsp;" . $rowCompleted['Description'] . ", <b>Due Date</b>:&nbsp;" . $month . "&nbsp;" . $day . ", " . $year . "&nbsp;at&nbsp;" . $hour . ":" . $min . ":" . $sec . "&nbsp;" . $ampm . "</li>";
				}
				echo "</ul>";
			}

		} else {
			?>
			<h1>Welcome to your homepage, <?php echo $_SESSION['FirstName']?>!</h1>
			<p>Please choose a list to view or create a new one using the button on the left!</p>
			<p>Here's a quick look at your next 5 upcoming reminders:</p>

			<?php

			$UserID = $_SESSION['UserID'];

			$getMostUrgentQuery = "select Subject, Description, ReminderDate from SUBSCRIPTION s, TODOITEMS t where s.UserID = '$UserID' and t.ListID = s.ListID and t.Completed = 0 order by ReminderDate asc limit 5";
			$getMostUrgentResult = mysqli_query($dbc, $getMostUrgentQuery);

			echo "<ul>";
				while ($rowUrgent = mysqli_fetch_array($getMostUrgentResult)) {
					$dueDate = strtotime($rowUrgent['ReminderDate']);
					$month = date('M', $dueDate);
					$day = date('j', $dueDate);
					$year = date('Y', $dueDate);
					$hour = date('g', $dueDate);
					$min = date('i', $dueDate);
					$sec = date('s', $dueDate);
					$ampm = date('a', $dueDate);

					echo "<li><b>Subject</b>:&nbsp;" . $rowUrgent['Subject'] . ", <b>Description</b>:&nbsp;" . $rowUrgent['Description'] . ", <b>Due Date</b>:&nbsp;" . $month . "&nbsp;" . $day . ", " . $year . "&nbsp;at&nbsp;" . $hour . ":" . $min . ":" . $sec . "&nbsp;" . $ampm . "</li>";
				}
				echo "</ul>";

		}

	?>

    

	</div>
	</div>
	
      
<?php

} elseif(!empty($_POST['username']) && !empty($_POST['password'])) {

	$username = $_POST['username'];
	$password = sha1($_POST['password']);
     
    $loginQuery = "select * from USER where UserName = '$username' AND Password = '$password'";

    $checklogin = mysqli_query($dbc, $loginQuery);
     
    if(mysqli_num_rows($checklogin) == 1) {
        $row = mysqli_fetch_array($checklogin);

        $firstName = $row['FirstName'];
        $lastName = $row['LastName'];
        $email = $row['Email'];
        $userName = $row['UserName'];
        $phoneNumber = $row['PhoneNumber'];
         
        $_SESSION['FirstName'] = $firstName;
        $_SESSION['LastName'] = $lastName;
        $_SESSION['EmailAddress'] = $email;
        $_SESSION['Username'] = $username;
        $_SESSION['PhoneNumber'] = $phoneNumber;

        $_SESSION['LoggedIn'] = 1;
         
        echo "<div id='redirect'><h1>Success</h1>";
        echo "<p>We are now redirecting you to the member area.</p></div>";
        echo "<meta http-equiv='refresh' content='0;index.php' />";
    } else {
        echo "<h1>Error</h1>";
        echo "<p>Sorry, your account could not be found. Please <a href=\"index.php\">click here to try again</a>.</p>";
    }
} else {

?>

<div id="signin">
   <h1>Member Login</h1>
     
   <p>Thanks for visiting! Please either login below, or <a href="createuser.php">click here to register</a>.<br>
   <a href="admin.php">Click here</a> for the administrator page.</p>
     
    <form method="post" action="index.php" name="loginform" id="loginform">
    <fieldset>
        <label for="username">Username:&nbsp;</label><input type="text" name="username" id="username" /><br />
        <label for="password">Password:&nbsp;</label><input type="password" name="password" id="password" /><br />
        <input type="submit" name="login" id="login" value="Login" /><br />
    </fieldset>
    </form>
</div>
     
<?php

}

?>

</body>

</html>
