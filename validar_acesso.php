<?php

		require_once('db.class.php');

	$usuario = $_POST['usuario'];
	$senha = $_POST['senha'];

	$sql = " SELECT * FROM usuarios WHERE usuario = '$usuario' AND senha = '$senha'";

	//update true/false
	//insert true/false
	//select retorna false caso aja algum erro na consulta. casa nao aja erro, retorna um resource
	//delete true/false

	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$resultado_id = mysqli_query($link, $sql);

	$dados_usuario = mysqli_fetch_array($resultado_id);

	var_dump($dados_usuario);

?>