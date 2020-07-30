<?php


		require_once('db.class.php');


	$sql = " SELECT * FROM usuarios";

	//update true/false
	//insert true/false
	//select retorna false caso aja algum erro na consulta. casa nao aja erro, retorna um resource
	//delete true/false

	$objDb = new db();
	$link = $objDb->conecta_mysql();

	$resultado_id = mysqli_query($link, $sql);

	if($resultado_id){
		$dados_usuario = array();
		//MYSQLI_ASSOC para receber de voltar o array com index addociativos, MYSQLI_NUM retorna os indexs numeros, e MYSQLI_BOTH ambos
		while($linha = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC)){
			$dados_usuario[] = $linha;

		}

		foreach($dados_usuario as $usuario){
			var_dump($usuario['email']);
			echo "<br><br>";
		}
	}
	else{
		echo "Erro na execucao da consulta!";
	}

?>