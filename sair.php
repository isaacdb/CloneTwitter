<?php 

	session_start();

	unset($_SESSION['usuario']);
	unset($_SESSION['email']);

	echo 'Voce foi deslogado!';
	

?>