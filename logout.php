<?php
	session_start();
	session_destroy();
	setcookie('token', "", (-1),"/",null, null, true);
	header("location:Index");
?>