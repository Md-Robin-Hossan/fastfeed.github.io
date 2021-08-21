<?php  
require 'config/config.php';
include("includes/classes/User.php");
include("includes/classes/Post.php");
include("includes/classes/Message.php");
include("includes/classes/Notification.php");



if (isset($_SESSION['username'])) {
	$userLoggedIn = $_SESSION['username'];
	$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
	$user = mysqli_fetch_array($user_details_query);
}
else {
	header("Location: register.php");
}

?>

<html>
<head>

	<title>Fastfeed</title>
	<link rel="icon" href="Fa-Feed-Icon/Fa-Feed.png" type="image/gif" sizes="20x20">
	<!--JS-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/bootbox.min.js"></script>
	<script src="assets/js/demo.js"></script>
	<script src="assets/js/jquery.jcrop.js"></script>
	<script src="assets/js/jcrop_bits.js"></script>
	<script src="assets/js/jcrop_bits.js"></script>


	<!--CSS-->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/responsive.css">

	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Concert+One&family=Cookie&family=Sacramento&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/jquery.Jcrop.css" type="text/css" />
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


</head>
<body>

	<div class="top_bar"> 

		<div class="logo">
			<a href="index.php">Fastfeed</a>
		</div>

		<div class="search">

			<form action="search.php" method="GET" name="search_form">
				<input type="text" onkeyup="getLiveSearchUsers(this.value, '<?php echo $userLoggedIn; ?>')" name="q" placeholder="Search..." autocomplete="off" id="search_text_input">

				<div class="button_holder">
				<i class="far fa-search"></i>
				</div>

			</form>

			<div class="search_results">
			</div>

			<div class="search_results_footer_empty">
			</div>



		</div>

		<nav>
		<?php
				//Unread messages 
				$messages = new Message($con, $userLoggedIn);
				$num_messages = $messages->getUnreadNumber();

				//Unread notifications 
				$notifications = new Notification($con, $userLoggedIn);
				$num_notifications = $notifications->getUnreadNumber();

				//Unread notifications 
				$user_obj = new User($con, $userLoggedIn);
				$num_requests = $user_obj->getNumberOfFriendRequests();

		?>

		<a href="<?php echo $userLoggedIn; ?>"><img class="head_img" src="<?php echo $user['profile_pic'];?>"></a>
		<a class="U_N" href="<?php echo $userLoggedIn; ?>"><?php echo $user['first_name']; ?></a>
		<a href="index.php" onclick = "getElementById('fa-bell_icon').style.color='red'"><i class="fal fa-home-alt"></i></a>

		<a href="javascript:void(0);"  onclick="getDropdownData('<?php echo $userLoggedIn; ?>', 'message')"  onclick = "getElementById('messenger_icon').style.color='red'"><i class="fab fa-facebook-messenger"></i>

			<?php
					if($num_messages > 0)
					echo '<span class="notification_badge" id="unread_message">' . $num_messages . '</span>';
			?>
		</a>
		
		<a href="javascript:void(0);" onclick="getDropdownData('<?php echo $userLoggedIn; ?>', 'notification')">
				<i class="fal fa-bell"  id="fa-bell_icon"></i>
				<?php
				if($num_notifications > 0)
				 echo '<span class="notification_badge" id="unread_notification">' . $num_notifications . '</span>';
				?>
			</a>

		<a href="requests.php" onclick = "getElementById('user_icon').style.color='red'"><i class="fal fa-user" id="user_icon">
		<?php
				if($num_requests > 0)
				 echo '<span class="notification_badge" id="unread_requests">' . $num_requests . '</span>';
				?>
		</i></a>
		<a href="settings.php"><i class="fal fa-cog"></i></a> 
		<a href="#"><div class="drop-btn">
			<span class="fas fa-caret-down" id="drop_btn_1"></span>
		</div></a>

		<div class="display">
		<div class="drop-menu drop-menu_second">
			<ul class="menu-bar">
				<li><a href="<?php echo $userLoggedIn; ?>">
					<div class="icon"><span class="fal fa-user"></span></div>
					Profile
				</a></li>

				<li class="setting-item"><a href="#">
					<div class="icon"><span class="fal fa-lock"></span></div>
					Privacy <i class="fal fa-angle-right"></i>
				</a></li>

				<li class="help-item"><a href="#">
					<div class="icon"><span class="fal fa-question-circle"></span></div>
					Help & Support  <i class="fal fa-angle-right"></i>
				</a></li>

				<li><a href="includes/handlers/logout.php">
					<div class="icon"><span class="fal fa-sign-out-alt"></span></div>
					Log Out
				</a></li>
			</ul>

			<!--Settings and Privacy menu-section-->
			<ul class="settings-drop">
			<li class="arrow back-setting-btn"><span class="fal fa-arrow-left"></span>Privacy & Settings</li>
				<li><a href="#">
					<div class="icon"><span class="fal fa-info"></span></div>
					Personal info
				</a></li>

				<li><a href="#">
					<div class="icon"><span class="fal fa-check"></span></div>
					Privacy Checkup
				</a></li>



				<li><a href="#">
					<div class="icon"><span class="fal fa-envelope"></span></div>
					Feedback
				</a></li>
			</ul>

			<!--Help & Support-->

			<ul class="help-drop">
			<li class="arrow back-help-btn"><span class="fal fa-arrow-left"></span>Help & Support</li>
				<li><a href="#">
					<div class="icon"><span class="fal fa-question-circle"></span></div>
					Help Center
				</a></li>

				<li><a href="#">
					<div class="icon"><span class="fal fa-check"></span></div>
					Support Inbox
				</a></li>

				<li><a href="#">
					<div class="icon"><span class="fal fa-exclamation-circle"></span></div>
					Report Problem
				</a></li>

			</ul>

		</div>
		</div> 
			
		</nav>



		<div class="dropdown_data_window" style="height:0px; border:none;">
		</div>
		<input type="hidden" id="dropdown_data_type" value="">

		<script>
			var userLoggedIn = '<?php echo $userLoggedIn; ?>';

			$(document).ready(function() {

				$('.dropdown_data_window').scroll(function() {
					var inner_height = $('.dropdown_data_window').innerHeight(); //Div containing data
					var scroll_top = $('.dropdown_data_window').scrollTop();
					var page = $('.dropdown_data_window').find('.nextPageDropdownData').val();
					var noMoreData = $('.dropdown_data_window').find('.noMoreDropdownData').val();

					if ((scroll_top + inner_height >= $('.dropdown_data_window')[0].scrollHeight) && noMoreData == 'false') {

						var pageName; //Holds name of page to send ajax request to
						var type = $('#dropdown_data_type').val();


						if(type == 'notification')
							pageName = "ajax_load_notifications.php";
						else if(type = 'message')
							pageName = "ajax_load_messages.php"


						var ajaxReq = $.ajax({
							url: "includes/handlers/" + pageName,
							type: "POST",
							data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
							cache:false,

							success: function(response) {
								$('.dropdown_data_window').find('.nextPageDropdownData').remove(); //Removes current .nextpage 
								$('.dropdown_data_window').find('.noMoreDropdownData').remove(); //Removes current .nextpage 


								$('.dropdown_data_window').append(response);
							}
						});

					} //End if 

					return false;

				}); //End (window).scroll(function())


			});

	</script>

		
	<script>
		const drop_btn = document.querySelector(".drop-btn");
		const display_menu = document.querySelector(".display");
		const menu_bar = document.querySelector(".menu-bar");
		const settings_drop = document.querySelector(".settings-drop");
		const help_drop = document.querySelector(".help-drop");
		const setting_item = document.querySelector(".setting-item");
		const help_item = document.querySelector(".help-item");
		const back_setting_btn = document.querySelector(".back-setting-btn");
		const back_help_btn = document.querySelector(".back-help-btn");

		drop_btn.onclick = (()=>{	
			display_menu.classList.toggle("show");
		});

		setting_item.onclick = (()=>{
			menu_bar.style.marginLeft = "-260px";
			setTimeout(()=>{
			settings_drop.style.display = "block";
			}, 100);
		});

		help_item.onclick = (()=>{
			menu_bar.style.marginLeft = "-260px";
			setTimeout(()=>{
				help_drop.style.display = "block";
			}, 100);
		});

		back_setting_btn.onclick = (()=>{
			menu_bar.style.marginLeft = "0px";
			settings_drop.style.display = "none";
		});
		back_help_btn.onclick = (()=>{
			menu_bar.style.marginLeft = "-0px";
			help_drop.style.display = "none";
		});
		
	</script>



	</div>



<button id="dark-mode-toggle" class="dark-mode-toggle">
<svg width="100%" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 496"><path fill="currentColor" d="M8,256C8,393,119,504,256,504S504,393,504,256,393,8,256,8,8,119,8,256ZM256,440V72a184,184,0,0,1,0,368Z" transform="translate(-8 -8)"/></svg>
</button>
<script src="./assets/js/darkmode.js"></script>


<div class="wrapper">

