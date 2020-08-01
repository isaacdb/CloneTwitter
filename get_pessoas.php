<?php

	session_start();
	
	if(!isset($_SESSION['usuario'])){ //verificacao se a algum usuario logado para continuar o codigo
		header('Location: index.php?erro=1');
	}


	require_once('db.class.php');//utiliza o codigo desse script nessa pagina. usado para conectar ao banco de dados
	$nome_pessoa = $_POST['nome_pessoa'];
	$id_usuario = $_SESSION['id_usuario'];//Recebe o id ususario da variavel grobal SESSION, que foi atribuido na pagina valida.php

	$objDb = new db(); //duas linhas de conexao com o banco de dados
	$link = $objDb->conecta_mysql();
 // Utilizar o coamdno like %var% para buscar nomes parecidos no banco de dados, 
	$sql = " SELECT u.*, us.* ";
	$sql.= "FROM usuarios AS u ";
	$sql.= "LEFT JOIN usuarios_seguidores AS us ";
	$sql.= "ON(us.id_usuario = $id_usuario AND u.id = us.seguindo_id_usuario) ";
	$sql.= "WHERE u.usuario like '%$nome_pessoa%' AND u.id <> $id_usuario"; // busca nos usuarios o $nome_pessoa, que foi recebido via POST, e necessariamente o ID tem que ser diferente do proprio usuario, para evitar buscar por si mesmo.


	$resultado_id = mysqli_query($link, $sql);//comando para aplicar a busca ou insercao no banco de dados

	if($resultado_id){

		while($registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC)){//para cada tweet localizado na busca vai entrar no while e tomar essas decisao
			 echo '<a href="#" class = "list-group-item">';
			 echo '<strong>'.$registro['usuario'].'</strong><small> - '.$registro['email'].'</small>';//exibe o nome e o email dos usuarios que se encaixaram na busca feita no mysql

			 echo '<p class = "list-group-item-text pull-right">';

			 $esta_seguindo_usuario_sn = isset($registro['id_usuario_seguidor']) && !empty($registro['id_usuario_seguidor']) ? 'S' : 'N';

			 $btn_seguir_display = 'block';
			 $btn_deixar_seguir_display = 'block';

			 if($esta_seguindo_usuario_sn == 'N'){
			 	$btn_deixar_seguir_display = 'none';
			 }else{
			 	$btn_seguir_display = 'none';
			 }

			 echo '<button type = "button" style=" display:'.$btn_seguir_display.'" id="btn_seguir_'.$registro['id'].'" class ="btn btn-default btn_seguir" data-id_usuario="'.$registro['id'].'">Seguir</button>';//cria um botao para seguir a pessoa
			 echo '<button type = "button" id="btn_deixar_seguir_'.$registro['id'].'" class ="btn btn-primary btn_deixar_seguir" style="display:'.$btn_deixar_seguir_display.'" data-id_usuario="'.$registro['id'].'">Deixar de Seguir</button>';//cria um botao para deixar de seguir a pessoa
			 echo '</p>';
			 echo '<div class="clearfix"></div>';//div criada para resolver um bug de posicionamento do botao flutuante. deixando ele centralizado.
			 echo'</a>';

		}

	}else{
		echo 'Erro na consulta de tweets no banco de dados!';
	}


?>