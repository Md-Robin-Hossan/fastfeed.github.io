<?php 
include("includes/header.php");
include("includes/form_handlers/settings_handler.php");
?>

<div class="main_column column">
	

	<?php
	echo "<img src='" . $user['profile_pic'] ."' class='small_profile_pic'>";
	?>
	<a href="upload.php" class="update_img"><i class="fal fa-camera"></i><span class="up-text">Update Image</span></a>


	<br><br><br><br><br>

	<h4 style="text-align: center;font-size: 20px;">Account Settings</h4>

	<p style="text-align: center;">Modify the values and click 'Update Details'</p>
	<br>

	<?php
	$user_data_query = mysqli_query($con, "SELECT first_name, last_name, email FROM users WHERE username='$userLoggedIn'");
	$row = mysqli_fetch_array($user_data_query);

	$first_name = $row['first_name'];
	$last_name = $row['last_name'];
	$email = $row['email'];
	?>
	<br><br>


	<form action="settings.php" method="POST">

		<span class="in_text">First Name:</span> <input type="text" name="first_name" value="<?php echo $first_name; ?>" id="settings_input"><br>

		<span class="in_text">Last Name:</span> <input type="text" name="last_name" value="<?php echo $last_name; ?>" id="settings_input"><br>
		<span class="in_text">Email:    </span> <input type="text" name="email" value="<?php echo $email; ?>" id="settings_input"><br>

		<br>
		<?php echo $message; ?>

		<input type="submit" name="update_details" id="save_details" value="Update Details" class="info settings_submit"><br><br>
	</form>
	<br><br>
	<h4 style="text-align: center;font-size: 20px;">Change Password</h4>
	<br><br>
	<form action="settings.php" method="POST">
	<span class="in_text">Old Password:</span> <input type="password" name="old_password" id="settings_input"><br>
	<span class="in_text">New Password:</span> <input type="password" name="new_password_1" id="settings_input"><br>
	<span class="in_text">Confirm Password :</span> <input type="password" name="new_password_2" id="settings_input"><br>
	<br>
		<?php echo $password_message; ?>

		<input type="submit" name="update_password" id="save_details" value="Update Password" class="info settings_submit"><br>
	</form>
	<br><br>
	<h4 style="text-align: center;font-size: 20px;">Close Account</h4>
	<form action="settings.php" method="POST">
		<input type="submit" name="close_account" id="close_account" value="Close Account" class="danger settings_submit">
	</form>

	<br><br>
</div>