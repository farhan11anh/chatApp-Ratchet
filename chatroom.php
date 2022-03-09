<?php 
session_start();

// melakukan cek saat user sudah melakukan login atau belum
if(!isset($_SESSION['user_data']))
{
	header('location:index.php');
}

require('database/ChatUser.php');

require('database/ChatRooms.php');

$chat_object = new ChatRooms;

$chat_data = $chat_object->get_all_chat_data();

$user_object = new ChatUser;

$user_data = $user_object->get_user_all_data();

// var_dump($user_data);

?>

<!DOCTYPE html>
<html>
<head>
	<title>Chat</title>
	<!-- auto reload tiap detik -->
	<!-- <meta http-equiv="refresh" content="1" /> -->
	<!-- Bootstrap core CSS -->
    <link href="vendor-front/bootstrap/bootstrap.min.css" rel="stylesheet">

    <link href="vendor-front/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" type="text/css" href="vendor-front/parsley/parsley.css"/>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor-front/jquery/jquery.min.js"></script>
    <script src="vendor-front/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor-front/jquery-easing/jquery.easing.min.js"></script>

    <script type="text/javascript" src="vendor-front/parsley/dist/parsley.min.js"></script>
	<style type="text/css">
		html,
		body {
		  height: 100%;
		  width: 100%;
		  margin: 0;
		}
		#wrapper
		{
			display: flex;
		  	flex-flow: column;
		  	height: 100%;
		}
		#remaining
		{
			flex-grow : 1;
		}
		#messages {
			height: 200px;
			background: whitesmoke;
			overflow: auto;
		}
		#chat-room-frm {
			margin-top: 10px;
		}
		#user_list
		{
			height:450px;
			overflow-y: auto;
		}

		#messages_area
		{
			height: 650px;
			overflow-y: auto;
			background-color:#e6e6e6;
		}

		.chat-box
		{
			width: 400px;
			height: 100px;
			background-color: blue;
			position: absolute;
			border-radius: 200px;
			text-align: center;
			padding-top: 10px;
			color: white;
			font-size: 40px;
			bottom: 20px;
			right: 20px;
			z-index: 3;
		}
		.close
		{
			display: none;
			width:100px;
			height:100px;
			background-color:blue;
			position:absolute;
			text-align:center;
			padding-top:24px;
			color:white;
			font-size: 40px;
			z-index: 3;
			border-radius:200px;
			bottom: 20px;
    		right: 150px;

		}
		.chatroom
		{
			display: none;
			max-width: 400px;
			margin-left: auto;
			margin-right: auto;
			animation-name: apear;
			animation-duration: 1s;
			position: relative;

		}
		@keyframes apear
		{
			from {
				top: 100px;
				display: block;

			}
			to {
				top: 0px;
				display: none;
			}
		}
		.hidencht
		{
			display: block;
		}

		.showCt{
			position: absolute;
			display: block;
			right: 40px;
			bottom: 120px;
			z-index: 5;
		}

		::-webkit-scrollbar {
			height: 0px;
			width: 0px;
			background: #000;
		}

	</style>
</head>
<body>
	<div class="chat-box">
		chat
	</div>
	<div class="close">
		X
	</div>
	<div class="container">

	<input type="button" class="btn btn-primary mt-2 mb-2 float-right" name="logout" id="logout" value="Logout" />
	<a href="privatechat.php" class="btn btn-secondary mt-2 mb-2 float-right mr-3">Private Chat</a>
		<br /><br> <hr>
        <h3 class="text-center">Group Chat</h3>
        <br />
		<div class="row">

		<div class="col-12">
				<?php

				$login_user_id = '';

				foreach($_SESSION['user_data'] as $key => $value)
				{
					$login_user_id = $value['id'];
					// var_dump($login_user_id);
					// die();
				?>

				<input type="hidden" name="login_user_id" id="login_user_id" value="<?php echo $login_user_id; ?>" />
				<div class="mt-3 mb-3 text-center">
					<img src="<?php echo $value['profile']; ?>" width="150" class="img-fluid rounded-circle img-thumbnail" />
					<h3 class="mt-2"><?php echo $value['name']; ?></h3>
					<a href="profile.php" class="btn btn-secondary mt-2 mb-2">Profile</a>
				</div>
				<?php
				}
				?>

				<div class="card mt-3">
					<div class="card-header">User List</div>
					<div class="card-body" id="user_list">
						<div class="list-group list-group-flush">
						<?php
						if(count($user_data) > 0)
						{
							foreach($user_data as $key => $user)
							{
								$icon = '<i class="fa fa-circle text-danger"></i>';

								if($user['user_login_status'] == 'Login')
								{
									$icon = '<i class="fa fa-circle text-success"></i>';
								}

								if($user['user_id'] != $login_user_id)
								{
									echo '
									<a class="list-group-item list-group-item-action">
										<img src="'.$user["user_profile"].'" class="img-fluid rounded-circle img-thumbnail" width="50" />
										<span class="ml-1"><strong>'.$user["user_name"].'</strong></span>
										<span class="mt-2 float-right">'.$icon.'</span>
									</a>
									';
								}

							}
						}
						?>
						</div>
					</div>
				</div>

			</div>
			
			<div class="col-lg-8 chatroom">
				<div class="card">
					<div class="card-header">
						<div class="row">
							<div class="col col-sm-6">
								<h3>Chat Room</h3>
							</div>
							<!-- <div class="col col-sm-6 text-right">
								<a href="privatechat.php" class="btn btn-success btn-sm">Private Chat</a>
							</div> -->
						</div>
					</div>
					<div class="card-body" id="messages_area">
					<?php
					foreach($chat_data as $chat)
					{
						if(isset($_SESSION['user_data'][$chat['userid']]))
						{
							$position = 'text-left';
							$from = 'Me';
							$row_class = 'row justify-content-end';
							$background_class = 'text-dark alert-light';
						}
						else
						{	
							$position = 'text-right';
							$from = $chat['user_name'];
							$row_class = 'row justify-content-start';
							$background_class = 'alert-success';
						}

						echo '
						<div class="'.$row_class.'">
							<div class="col-sm-10">
								<div class="shadow-sm alert '.$background_class.'">
									<div class="'.$position.'">
										<b>'.$from.'</b> <br>
										'.$chat["msg"].'
									</div>
									<div class="'.$position.'">
										<small><i>'.$chat["created_on"].'</i></small>
									</div>
								</div>
							</div>
						</div>
						';
					}
					?>
					</div>
				</div>

				<form method="post" id="chat_form" data-parsley-errors-container="#validation_error">
					<div class="input-group mb-3">
						<input class="form-control" id="chat_message" name="chat_message" placeholder="Type Message Here" data-parsley-maxlength="1000" data-parsley-pattern="/^[a-zA-Z0-9\s]+$/" required></input>
						<div class="input-group-append">
							<button type="submit" name="send" id="send" class="btn btn-primary" style="width:100px">Kirim</button>
						</div>
					</div>
					<div id="validation_error"></div>
				</form>
			</div>

			<div class="com-lg-2"></div>

		</div>
	</div>
</body>
<script type="text/javascript">
	
	$(document).ready(function(){

		// inisialisai port yang digunakan dalam chat
		var conn = new WebSocket('ws://localhost:8080');
		conn.onopen = function(e) {
		    console.log("Connection established!");
		};

		// mengirim pesan
		conn.onmessage = function(e) {
		    console.log(e.data);

		    var data = JSON.parse(e.data);

		    var row_class = '';

		    var background_class = '';

			// cek data yang akan ditampilkan
		    if(data.from == 'Me')
		    {
		    	row_class = 'row justify-content-end';
		    	background_class = 'text-dark alert-light';
		    }
		    else
		    {
		    	row_class = 'row justify-content-end';
		    	background_class = 'alert-success';
		    }

		    var html_data = "<div class='"+row_class+"'><div class='col-sm-10'><div class='shadow-sm alert "+background_class+"'><b>"+data.from+" - </b>"+data.msg+"<br /><div class='text-right'><small><i>"+data.dt+"</i></small></div></div></div></div>";

		    $('#messages_area').append(html_data);

		    $("#chat_message").val("");
		};

		$('#chat_form').parsley();

		$('#messages_area').scrollTop($('#messages_area')[0].scrollHeight);

		// mengirimkan pesan dan menyimpan pada database
		$('#chat_form').on('submit', function(event){

			event.preventDefault();

			if($('#chat_form').parsley().isValid())
			{

				var user_id = $('#login_user_id').val();

				var message = $('#chat_message').val();

				var data = {
					userId : user_id,
					msg : message
				};

				conn.send(JSON.stringify(data));

				$('#messages_area').scrollTop($('#messages_area')[0].scrollHeight);

			}

		});

		conn.onclose = function(e){
			console.log('conection closed');
		}

		const test = $('#login_user_id').val();
		console.log(test)
		
		// logout dengan mengirimkan data menggunakan ajax.
		$('#logout').click(function(){

			user_id = $('#login_user_id').val();

			$.ajax({
				url:"action.php",
				method:"POST",
				data:"user_id="+user_id+"&action=leave",
				success:function(data)
				{
					var response = JSON.parse(data);
					console.log(response.status);

					if(response.status == 1)
					{
						conn.close();
						location = 'index.php';
					} else {
						console.log("a")
					}
				}
			})

		});

	});
	
</script>

<script>

	// variabel untuk tiap komponen
	const chatbox = document.querySelector('.chat-box');
	const close = document.querySelector('.close');
	const chatroom = document.querySelector('.chatroom');

	chatbox.addEventListener('click', function(){
		chatroom.classList.add('showCt');
		close.classList.add('hidencht')
		chatbox.style.display="none";
	});

	close.addEventListener('click', function(){
		chatroom.classList.remove('showCt');
		close.classList.remove('hidencht');
		chatbox.style.display="block";
	})


	setInterval(function(){
		$('#user_list').load(window.location.href + ' #user_list')
	}, 100)



</script>


</html>