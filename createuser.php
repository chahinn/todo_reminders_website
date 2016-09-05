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
<?php
if(isset($_POST['createuser']))
{
	$firstName = $_POST['firstname'];
	$lastName = $_POST['lastname'];
	$email = $_POST['email'];
	$userName = $_POST['username'];
	$password = sha1($_POST['password']);
	$confirmPassword = sha1($_POST['confirmpassword']);
	$phoneNumber = $_POST['phonenumber'];

	$checkEmailQuery = "select Email from USER where Email='$email'";
	$emailResult = mysqli_query($dbc, $checkEmailQuery);

	$checkUsernameQuery = "select UserName from USER where UserName='$userName'";
	$usernameResult = mysqli_query($dbc, $checkUsernameQuery);

	if ($password != $confirmPassword) {
		echo "Passwords do not match!";
	} else if (mysqli_num_rows($emailResult) != 0) {
		echo "Email address is already in use!";
	} else if (mysqli_num_rows($usernameResult) != 0) {
		echo "Username is already in use!";
	} else {
		$query = "insert into USER (FirstName, LastName, Email, UserName, Password, PhoneNumber) values ('$firstName', '$lastName', '$email', '$userName', '$password', '$phoneNumber')";
		$result = mysqli_query($dbc, $query) or die("bad query".mysqli_error($dbc));
		//echo "result: " . $result;
		echo "Your user account has been created successfully! <a href='index.php'>Click here</a> to go back to the login page.";
	}

	mysqli_close($dbc);

}
  
?>
 <div id="register">
   <h1>Register</h1>
     
   <p>Please enter your details below to register. Or <a href="index.php">go back</a> to the login page.</p>
     
    <form method="post" name="registerform" id="registerform">
    <fieldset>
        First Name: <input type="text" name="firstname" id="firstname"/><br><br>
		Last Name: <input type="text" name="lastname" id="lastname"/><br><br>
		Email Address: <input type="text" name="email" id="email"/><br><br>
		Username: <input type="text" name="username" id="username"/><br><br>
		Password: <input type="password" name="password" id="password"/><br><br>
		Confirm Password: <input type="password" name="confirmpassword" id="confirmpassword"/><br><br>
		Phone Number: <input type="text" name="phonenumber" id="phonenumber"/><br><br>
		<input type="submit" name="createuser" id="createuser" value="Create User">
    </fieldset>
    </form>

 
</div>
</body>
</html>