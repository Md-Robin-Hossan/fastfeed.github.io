<?php  
require 'config/config.php';
require 'includes/form_handlers/register_handler.php';
require 'includes/form_handlers/login_handler.php';
?>

<?php
$success = "";
$error_message = "";


?>

<html>
<head>
	<title>Fastfeed - log in or sign up</title>
	<link rel="icon" href="Fa-Feed-Icon/Fa-Feed.png" type="image/gif" sizes="20x20">
	<link rel="stylesheet" type="text/css" href="assets/css/register_style.css">
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="assets/js/register.js"></script>
</head>
<body>

	<?php  

	if(isset($_POST['register_button'])) {
		echo '
		<script>

		$(document).ready(function() {
			$("#first").hide();
			$("#second").show();
		});

		</script>

		';
	}


	?>

	<div class="wrapper">

		<div class="Information">
			<p>Fastfeed helps you connect and share with the people in your life.</p>
		</div>

		<div class="login_box">

			<div class="login_header">
				<h1>Fastfeed</h1>
				Login or sign up below
			</div>
			<br>
			<div id="first">

				<form action="register.php" method="POST" autocomplete="off">
					
				<div class="tblLogin">
				<?php 
					if(!empty($success == 1)) { 
				?>
				<div class="tableheader">Enter OTP</div>
				<p style="color:#31ab00;">Check your email for the OTP</p>
					
				<div class="tablerow">
					<input type="text" name="otp" placeholder="One Time Password" class="login-input" required>
				</div>
				<div class="tableheader"><input type="submit" name="submit_otp" value="Submit" class="btnSubmit"></div>
				<?php 
					} else if ($success == 2) {
				?>
				<p style="color:#31ab00;">Welcome, You have successfully loggedin!</p>
				<?php
					}
					else {
				?>
					<input type="email" name="log_email" placeholder="Email Address" value="<?php 
					if(isset($_SESSION['log_email'])) {
						echo $_SESSION['log_email'];
					} 
					?>" required>
					<br>
					<input type="password" name="log_password" placeholder="Password" id="myInput">
					<span class="eye_span" onclick="myFunction()">
						<i class="fa fa-eye" id="hide1"></i>
						<i class="fa fa-eye-slash" id="hide2"></i>
					</span>
					<br>
					<?php if(in_array("Email or password was incorrect<br>", $error_array)) echo  "Email or password was incorrect<br>"; ?>
					<input type="submit" name="login_button" name="submit_email" value="Log In">
					<br>
					<br>
					<a href="#" id="signup" class="signup">Create New Account?</a>
					<br>
					<br>	
					<?php 
						}
					?>
					</div>	
				</form>
			</div>

		

			<script>
				function myFunction() {
				var x = document.getElementById("myInput");
				var y = document.getElementById("hide1");
				var z = document.getElementById("hide2");
				if (x.type === "password") {
					x.type = "text";
					y.style.display= "block";
					z.style.display = "none";
				} else {
					x.type = "password";
					y.style.display= "none";
					z.style.display = "block";
				}
				}
			</script>



			<div id="second">

				<form  autocomplete="off" action="register.php" method="POST">
					<input type="text" name="reg_fname" placeholder="First Name" value="<?php 
					if(isset($_SESSION['reg_fname'])) {
						echo $_SESSION['reg_fname'];
					} 
					?>" required>
					<br>
					<?php if(in_array("Your first name must be between 2 and 25 characters<br>", $error_array)) echo "Your first name must be between 2 and 25 characters<br>"; ?>
					
					


					<input type="text" name="reg_lname" placeholder="Last Name" value="<?php 
					if(isset($_SESSION['reg_lname'])) {
						echo $_SESSION['reg_lname'];
					} 
					?>" required>
					<br>
					<?php if(in_array("Your last name must be between 2 and 25 characters<br>", $error_array)) echo "Your last name must be between 2 and 25 characters<br>"; ?>

					<select type="text" name="university_name" placeholder="Enter your university name" value="<?php 
					if(isset($_SESSION['university_name'])) {
						echo $_SESSION['university_name'];
					} 
					?>" required>
						<optgroup label="Choose your university name">
						<option>Daffodil International University</option>
						<option>Hamdard University Bangladesh</option>
						</optgroup>
					</select>
					<br>

				<div class="radio_user" style=" position:relative; left: -118px;">
				<input class="form-check-input" type="radio" name="profession"  value="Teacher">Teacher
				<input class="form-check-input" type="radio" name="profession"  value="Student" checked>Student
				</div>

					<input type="email" name="reg_email" placeholder="Enter your university email" value="<?php 
					if(isset($_SESSION['reg_email'])) {
						echo $_SESSION['reg_email'];
					} 
					?>" required>
					<br>
					<?php if(in_array("Please Enter your Versity Email<br>", $error_array)) echo "Your Emails Not Valied <br>"; ?>

					<input type="email" name="reg_email2" placeholder="Confirm your university email" value="<?php 
					if(isset($_SESSION['reg_email2'])) {
						echo $_SESSION['reg_email2'];
					} 
					?>" required>
					<br>
					
					<?php if(in_array("Email already in use<br>", $error_array)) echo "Email already in use<br>"; 
					else if(in_array("Invalid email format<br>", $error_array)) echo "Invalid email format<br>";
					else if(in_array("Emails don't match<br>", $error_array)) echo "Emails don't match<br>"; 
					else if(in_array("Please enter your versity email<br>", $error_array)) echo "Please enter your versity email<br>"; ?>


					<input type="password" name="reg_password" placeholder="Password" required>
					<br>
					<input type="password" name="reg_password2" placeholder="Confirm Password" required>
					<br>
					<?php if(in_array("Your passwords do not match<br>", $error_array)) echo "Your passwords do not match<br>"; 
					else if(in_array("Your password can only contain english characters or numbers<br>", $error_array)) echo "Your password can only contain english characters or numbers<br>";
					else if(in_array("Your password must be betwen 5 and 30 characters<br>", $error_array)) echo "Your password must be betwen 5 and 30 characters<br>"; ?>



					<input type="submit" name="register_button" value="Register">
					<br>

					<?php if(in_array("<span style='color: #14C800;'>You're all set! Go ahead and login!</span><br>", $error_array)) echo "<span style='color: #14C800;'>You're all set! Go ahead and login!</span><br>"; ?>
					<a href="#" id="signin" class="signin">Already have an account? Sign in here!</a>
				</form>
			</div>

		</div>

	</div>


</body>
</html>