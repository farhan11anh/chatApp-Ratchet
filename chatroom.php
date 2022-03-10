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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

    <link href="vendor-front/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" type="text/css" href="vendor-front/parsley/parsley.css"/>

    <!-- Bootstrap core JavaScript -->
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>

    <!-- Core plugin JavaScript-->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

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
			width: 100px;
			height: 100px;
			background-color: #007bff;
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
			display: block;
			max-width: 100%;
			height: 100%;
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
		.ballon-chat {
			margin: 10px;
		}

	</style>
</head>
<body>
	<div class="chat-box" data-toggle="modal" data-target="#staticBackdrop">
		<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-chat-quote-fill" viewBox="0 0 16 16">
			<path d="M16 8c0 3.866-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.584.296-1.925.864-4.181 1.234-.2.032-.352-.176-.273-.362.354-.836.674-1.95.77-2.966C.744 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7zM7.194 6.766a1.688 1.688 0 0 0-.227-.272 1.467 1.467 0 0 0-.469-.324l-.008-.004A1.785 1.785 0 0 0 5.734 6C4.776 6 4 6.746 4 7.667c0 .92.776 1.666 1.734 1.666.343 0 .662-.095.931-.26-.137.389-.39.804-.81 1.22a.405.405 0 0 0 .011.59c.173.16.447.155.614-.01 1.334-1.329 1.37-2.758.941-3.706a2.461 2.461 0 0 0-.227-.4zM11 9.073c-.136.389-.39.804-.81 1.22a.405.405 0 0 0 .012.59c.172.16.446.155.613-.01 1.334-1.329 1.37-2.758.942-3.706a2.466 2.466 0 0 0-.228-.4 1.686 1.686 0 0 0-.227-.273 1.466 1.466 0 0 0-.469-.324l-.008-.004A1.785 1.785 0 0 0 10.07 6c-.957 0-1.734.746-1.734 1.667 0 .92.777 1.666 1.734 1.666.343 0 .662-.095.931-.26z"/>
		</svg>
	</div>

	<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		<div class="chatroom">
				<div class="card">
					<div class="card-header">
						<div class="row">
							<div class="col col-sm-6">
								<h3>Chat Room</h3>
							</div>
							<div class="col col-sm-6 text-right">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
					<div class="card-body" id="messages_area">
					<?php
					foreach($chat_data as $chat)
					{
						if(isset($_SESSION['user_data'][$chat['userid']]))
						{
							$position = 'text-right';
							$from = 'Me';
							$row_class = 'row justify-content-end';
							$background_class = 'text-dark alert-light';
						}
						else
						{	
							$position = 'text-left';
							$from = $chat['user_name'];
							$row_class = 'row justify-content-start';
							$background_class = 'alert-success';
						}

						echo '
						<div class="'.$row_class.'">
							<div class="ballon-chat">
								<div class="shadow-sm alert '.$background_class.'">
									<div class="'.$position.'">
										<b>'.$from.'</b> <br>
										'.$chat["msg"].'
									</div>
									<div class="'.$position.'">
										<small class="'.$position.'"><i>'.$chat["created_on"].'</i></small>
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
		</div>
	</div>
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
			
			aa
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
							$position = 'text-right';
							$from = 'Me';
							$row_class = 'row justify-content-end';
							$background_class = 'text-dark alert-light';
						}
						else
						{	
							$position = 'text-left';
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
										<small class="'.$position.'"><i>'.$chat["created_on"].'</i></small>
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


		$(".chat-box").click(function() {
            $('#messages_area').scrollTop($('#messages_area')[0].scrollHeight);
        });

		// inisialisai port yang digunakan dalam chat
		var conn = new WebSocket('ws://192.168.18.72:8080');
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
				position = 'text-right'
		    }
		    else
		    {
		    	row_class = 'row justify-content-start';
		    	background_class = 'alert-success';
				position = 'text-left';
		    }

		    var html_data = "<div class='"+row_class+"'><div class='ballon-chat'><div class='shadow-sm alert "+background_class+"'><div class='"+position+"' ><b>"+data.from+"</b><br>"+data.msg+"</div><div class='"+position+"'><small><i>"+data.dt+"</i></small></div></div></div></div>";

		    $('#messages_area').append(html_data);

		    $("#chat_message").val("");
		};

		$('#chat_form').parsley();

		$('#messages_area').scrollTop($('#messages_area').height());

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

		$('.card-body').scrollTop($('.card-body')[0].scrollHeight);

	});
	
</script>

<script>
	chat.scrollTop = chat.scrollHeight;

	const chat = document.querySelector('.card-body');
	const bt = document.querySelector('.chat-box');
	const scroll = function(){
		return chat.scrollTop = chat.scrollHeight;
	} 
	chat.addEventListener('click', function(){
		const scroll = chat.scrollTop = chat.scrollHeight;
		setInterval(scroll(), 1000);
		
	})


</script>

<script>
        $(document).ready(function() {
            $(".card-body").click(function() {
                $('.chat-box').scrollTop($('.chat-box').height());
            });
        });
    </script>


</html>