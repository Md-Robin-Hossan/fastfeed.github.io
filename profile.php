<?php 
	include("includes/header.php");

  $message_obj = new Message($con, $userLoggedIn);
  


	if(isset($_GET['profile_username'])) {
		$username = $_GET['profile_username'];
		$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
		$user_array = mysqli_fetch_array($user_details_query);

		$num_friends = (substr_count($user_array['friend_array'], ",")) - 1;

	}



if(isset($_POST['remove_friend'])){
	$user = new User($con, $userLoggedIn);
	$user->removeFriend($username);
}
if(isset($_POST['add_friend'])){
	$user = new User($con, $userLoggedIn);
	$user->sendRequest($username);
}


if(isset($_POST['respond_request'])){
	header("Location: requests.php");
}
if(isset($_POST['cancel_request'])) {
  $user = new User($con, $userLoggedIn);
  $user->cancelRequest($username);
}


if(isset($_POST['post_message'])) {
  if(isset($_POST['message_body'])) {
    $body = mysqli_real_escape_string($con, $_POST['message_body']);
    $date = date("Y-m-d H:i:s");
    $message_obj->sendMessage($username, $body, $date);
  }

  $link = '#profileTabs a[href="#messages_div"]';
  echo "<script> 
          $(function() {
              $('" . $link ."').tab('show');
          });
        </script>";
}


?>



	<style>
		.wrapper{
		padding-left: 0px;
        margin-left: 0px;
		}
	</style>

	<div class="profile_left">

		<img src="<?php echo $user_array['profile_pic']; ?>" alt="Something Wrong">
		<h4><?php echo $user_array['first_name'] . " " . $user_array['last_name'];?></h4>
		<div class="profile_info">
		<p><?php echo "Post  " . $user_array['num_posts'];?></p>
		<p><?php echo "Like  " . $user_array['num_likes'];?></p>
		<p><a href="friends.php"  class="friends_hover" style="text-decoration: none;"><?php echo "Friend  " . $num_friends; ?></a></p>
		</div>

		<form action="<?php echo $username; ?>" method="POST">
 			<?php 
 			$profile_user_obj = new User($con, $username); 
 			if($profile_user_obj->isClosed()) {
 				header("Location: user_closed.php");
 			}

 			$logged_in_user_obj = new User($con, $userLoggedIn); 

 			if($userLoggedIn != $username) {

 				if($logged_in_user_obj->isFriend($username)) {
 					echo '<input type="submit" name="remove_friend" class="danger" value="Remove Friend">';
 				
 				}
 				else if ($logged_in_user_obj->didReceiveRequest($username)) {
 					echo '<input type="submit" name="respond_request" class="warning" value="Respond to Request"><br>';
 				}
 				else if ($logged_in_user_obj->didSendRequest($username)) {
 					echo '<input type="submit" name="cancel_request" class="default" value="Request Sent"><br>';
 				}
 				else 
 					echo '<input type="submit" name="add_friend" class="success" value="Add Friend"><br>';

 			}

 			?>		 
 		</form>
     <input type="submit" class="deep_blue" data-toggle="modal" data-target="#post_form" value="Post Something">

			<?php  
				if($userLoggedIn != $username) {
				echo '<div class="profile_info_bottom">';
					echo $logged_in_user_obj->getMutualFriends($username) . " Mutual friends";
				echo '</div>';
				}
			?>
	</div>

	

	<div class="columns profile_main_column">
		
    <ul class="nav nav-tabs" role="tablist" id="profileTabs">
      <li role="presentation" class="active"><a href="#newsfeed_div" aria-controls="newsfeed_div" role="tab" data-toggle="tab">Newsfeed</a></li>
      <li role="presentation"><a href="#messages_div" aria-controls="messages_div" role="tab" data-toggle="tab">Messages</a></li>
    </ul>

    <div class="tab-content">

      <div role="tabpanel" class="tab-pane fade in active" id="newsfeed_div">
        <div class="posts_area"></div>
        <img id="loading" src="assets/images/icons/loading.gif">
      </div>

      <div role="tabpanel" class="tab-pane fade" id="messages_div">

      <?php  

        echo "<h4>You and <a href='" . $username ."'>" . $profile_user_obj->getFirstAndLastName() . "</a></h4><hr><br>";
        echo "<div class='loaded_messages' id='scroll_messages'>";
        echo $message_obj->getMessages($username);
        echo "</div>";
      ?>

        <div class="message_post">
          <form action="" method="POST">
          <textarea onkeypress='auto_grow(this);' onkeydown='auto_grow(this);' name='message_body' id='message_textarea' placeholder='Write your message ...'></textarea>
					<button  type='submit' name='post_message' class='info' id='message_submit'><i class='fad fa-angle-double-up'></i></button>
          </form>
        </div>
        
        <script>
            var div = document.getElementById("scroll_messages");
            div.scrollTop = div.scrollHeight;
        </script>
        </div>



    </div>



	</div>

<div class="info_user">
		<h3>Intro</h3>
		<div class="user_details_left_rights">
			<a href=""><i class="fas fa-user-graduate"></i>
			<?php 
			echo $user_array['university_name'];
			 ?>
			</a>
			<br>
			<a><i class="fad fa-user-tie"></i><span class="C"><?php echo $user_array['profession']; ?></span><a>
</div>
</div>



	<!-- Modal -->
<div class="modal fade" id="post_form" tabindex="-1" role="dialog" aria-labelledby="postModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="postModalLabel">Post something!</h4>
      </div>

      <div class="modal-body">
	  <a href="<?php echo $userLoggedIn; ?>"><img class="head_img U_P" src="<?php echo $user['profile_pic'];?>"></a>
	  <a class="U_N U_T" href="<?php echo $userLoggedIn; ?>"><?php echo $user['first_name']. " " . $user['last_name']; ?></a>


      	<form class="profile_post" aaction="profile.php" method="POST" enctype="multipart/form-data">
              <div class="form-group">
              <input type="file" name="fileToUpload" id="fileToUpload">
              <label for="fileToUpload">
              <i class="material-icons" style="font-size: 40px;">
              add_photo_alternate
              </i>
              </label>
              <textarea class="form-control" name="post_body" placeholder="Write someting to <?php  echo $user_array['first_name']. " " . $user_array['last_name'];?>"></textarea>

      			<input type="hidden" name="user_from" value="<?php echo $userLoggedIn; ?>">
      			<input type="hidden" name="user_to" value="<?php echo $username; ?>">
      		</div>
      	</form>
      </div>


      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" name="post_button" id="submit_profile_post">Post</button>
      </div>
    </div>
  </div>
</div>


<script>
  var userLoggedIn = '<?php echo $userLoggedIn; ?>';
  var profileUsername = '<?php echo $username; ?>';

  $(document).ready(function() {

    $('#loading').show();

    //Original ajax request for loading first posts 
    $.ajax({
      url: "includes/handlers/ajax_load_profile_posts.php",
      type: "POST",
      data: "page=1&userLoggedIn=" + userLoggedIn + "&profileUsername=" + profileUsername,
      cache:false,

      success: function(data) {
        $('#loading').hide();
        $('.posts_area').html(data);
      }
    });

    $(window).scroll(function() {
      var height = $('.posts_area').height(); //Div containing posts
      var scroll_top = $(this).scrollTop();
      var page = $('.posts_area').find('.nextPage').val();
      var noMorePosts = $('.posts_area').find('.noMorePosts').val();

      if ((document.body.scrollHeight == document.body.scrollTop + window.innerHeight) && noMorePosts == 'false') {
        $('#loading').show();

        var ajaxReq = $.ajax({
          url: "includes/handlers/ajax_load_profile_posts.php",
          type: "POST",
          data: "page=" + page + "&userLoggedIn=" + userLoggedIn + "&profileUsername=" + profileUsername,
          cache:false,

          success: function(response) {
            $('.posts_area').find('.nextPage').remove(); //Removes current .nextpage 
            $('.posts_area').find('.noMorePosts').remove(); //Removes current .nextpage 

            $('#loading').hide();
            $('.posts_area').append(response);
          }
        });

      } //End if 

      return false;

    }); //End (window).scroll(function())


  });

  </script>





	</div>
</body>
</html>