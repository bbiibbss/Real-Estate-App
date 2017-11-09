<?php

	session_start();
	
	require_once 'userClass.php';
	$session = new USER();

	if(!$session->is_loggedin()) {
		$session->redirect('../../frontend/logOut/login.php');
	}
?>