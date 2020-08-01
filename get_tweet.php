<?php

	session_start();
	
	if(!isset($_SESSION['usuario'])){ //verificacao se a algum usuario logado para continuar o codigo
		header('Location: index.php?erro=1');
	}


	require_once('db.class.php');//utiliza o codigo desse script nessa pagina. usado para conectar ao banco de dados

	$id_usuario = $_SESSION['id_usuario'];//Recebe o id ususario da variavel grobal SESSION, que foi atribuido na pagina valida.php

	$objDb = new db(); //duas linhas de conexao com o banco de dados
	$link = $objDb->conecta_mysql();

	$sql = " SELECT DATE_FORMAT(t.data_inclusao,'%d %b %Y %T') AS data_inclusao_formatada, t.tweet, u.usuario "; // comando para selecionar especificamente esses dados dentro do MySQL
	//    Formata a data que vem por padrao do banco de dados, %d = dias - %b = mes - %Y = ano(Ymaisculo) - %T = Horario(Tmaisculo)
	$sql.= "FROM tweet AS t JOIN usuarios AS u ON(t.id_usuario = u.id) ";//Da aos usuarios apelidos como tweet=t e usuarios=u, e relaciona a coluda id_usuario dos tweet com a colunda id dos usuarios
	$sql.= "WHERE id_usuario = $id_usuario ";
	$sql.= "OR id_usuario IN (SELECT seguindo_id_usuario FROM usuarios_seguidores where id_usuario = $id_usuario) ";
	$sql.= "ORDER BY data_inclusao DESC "; // Faz a busca dos dados no id do usuario, e no de todos que ele segue.


	$resultado_id = mysqli_query($link, $sql);//comando para aplicar a busca ou insercao no banco de dados

	if($resultado_id){

		while($registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC)){//para cada tweet localizado na busca vai entrar no while e tomar essas decisao
			 echo '<a href="#" class = "list-group-item">';
			 echo '<h4 class = "list-group-item-heading">'.$registro['usuario'].'<small> - '.$registro['data_inclusao_formatada'].'</small></h4>';// cria uma linha com o nome em destaque, e a data menor ao lado
			 echo '<p class = "list-group-item-text">'.$registro['tweet'].'</p>';//cria um paragrafo abaixo do nome com o conteudo escrito do tweet
			 echo'</a>';
		}

	}else{
		echo 'Erro na consulta de tweets no banco de dados!';
	}


?>