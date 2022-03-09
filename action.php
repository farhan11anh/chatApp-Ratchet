<?php

//action.php

session_start();

// validasi saat user melakukan submit pada form dan menerima data leave dan juga post yang membawa action.
if(isset($_POST['action']) && $_POST['action'] == 'leave')
{
	require('database/ChatUser.php');

	$user_object = new ChatUser;

	$user_object->setUserId($_POST['user_id']);

	$user_object->setUserLoginStatus('Logout');

	$user_object->setUserToken($_SESSION['user_data'][$_POST['user_id']]['token']);

	unset($_SESSION['user_data']);

	session_destroy();

	echo json_encode(['status'=>1]);

	$user_object->update_user_login_data();

}

// validasi saat user melakukan submit pada form dan menerima data leave dan juga post yang membawa action.
if(isset($_POST["action"]) && $_POST["action"] == 'fetch_chat')
{
	require 'database/PrivateChat.php';

	$private_chat_object = new PrivateChat;

	$private_chat_object->setFromUserId($_POST["to_user_id"]);

	$private_chat_object->setToUserId($_POST["from_user_id"]);

	$private_chat_object->change_chat_status();

	echo json_encode($private_chat_object->get_all_chat_data());
}


?>