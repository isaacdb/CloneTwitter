<?php
	session_start();

	if(!isset($_SESSION['usuario'])){
		header('Location: index.php?erro=1');
	}

	require_once('db.class.php');

		$objDb = new db(); //duas linhas de conexao com o banco de dados
	$link = $objDb->conecta_mysql();
	$id_usuario = $_SESSION['id_usuario'];


	//qntdade de tweets

	$sql = " SELECT COUNT(*) AS qtde_tweets FROM tweet WHERE id_usuario = $id_usuario ";
	$resultado_id = mysqli_query($link, $sql);
	$qtde_tweets = 0;
	if($resultado_id){
		$registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC);
		$qtde_tweets =$registro['qtde_tweets'];
	}else{
	echo'Houve um erro na execucao da query';
	}


	//quantidade de seguidores

	$sql = " SELECT COUNT(*) AS qtde_seguidores FROM usuarios_seguidores WHERE seguindo_id_usuario = $id_usuario ";
	$resultado_id = mysqli_query($link, $sql);
	$qtde_seguidores = 0;
	if($resultado_id){
		$registro = mysqli_fetch_array($resultado_id, MYSQLI_ASSOC);
		$qtde_seguidores =$registro['qtde_seguidores'];
	}else{
	echo'Houve um erro na execucao da query';
	}

?>

<!DOCTYPE HTML>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">

		<title>Twitter clone</title>
		
		<!-- jquery - link cdn -->
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

		<!-- bootstrap - link cdn -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

		<script type="text/javascript">
			
			$(document).ready(function(){
				///associar o evento de click ao botao				
				$('#btn_tweet').click(function(){
					

					if($('#texto_tweet').val().length>0){//checa se o campo de tweet tem alguma mensagem escrita
						
						$.ajax({
							url: 'inclui_tweet.php',
							method: 'post',
							//data: {  texto_tweet: $('#texto_tweet').val() },
							data:$('#form_tweet').serialize(),
							success: function(data){
								$('#texto_tweet').val('');
								atualizaTweets();
							}
						})

					}
				});

				function atualizaTweets(){
					//carregar os tweets. utilizando o sistema ajax
					$.ajax({
						url:'get_tweet.php',//busca um retorno na pagina atribuida ao url
						success: function(data){// caso a busca tenha sucesso, entra nesta funcao que recebe o valor data, que equivale ao retorno da busca
							$('#tweets').html(data);//Busca o local de ID =  tweets, e atribui dentro dele(como filho) o conteudo data em formato de HTML
						}
					});
				}

				atualizaTweets();
			});

		</script>
	
	</head>

	<body>

		<!-- Static navbar -->
	    <nav class="navbar navbar-default navbar-static-top">
	      <div class="container">
	        <div class="navbar-header">
	          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <img src="imagens/icone_twitter.png" />
	        </div>
	        
	        <div id="navbar" class="navbar-collapse collapse">
	          <ul class="nav navbar-nav navbar-right">
	            <li><a href="sair.php">Sair</a></li>
	          </ul>
	        </div><!--/.nav-collapse -->
	      </div>
	    </nav>


	    <div class="container">
	    	<div class="col-md-3">
	    		<div class="panel panel-default">
	    			<div class="panel-body">
	    				<h4><?= $_SESSION['usuario']?></h4>

	    				<hr/>
	    				<div class="col-md-6">
	    					TWEETS <br>
	    				<?= $qtde_tweets ?>
	    				</div>

	    				<div class="col-md-6">
	    					SEGUIDORES<br>
	    					<?= $qtde_seguidores ?>
	    				</div>


	    			</div>
	    		</div>
	    	</div>

	    	<div class="col-md-6">
	    		<div class="panel panel-default">
	    			<div class="panel-body">
	    				<form class="input-group" id="form_tweet">
	    					<input name="texto_tweet" type="text" id="texto_tweet" class="form-group" placeholder="Oque esta acontecendo ?" maxlength="140">
	    					<span class="input-group-btn">
	    						<button class="btn btn-default" id="btn_tweet" type="button">Tweet</button>
	    					</span>	    					
	    				</form>	    				
	    			</div>
	    		</div>

	    		<div id="tweets" class="list-group"></div>


			</div>

			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-body">
						<h4><a href="procurar_pessoas.php">Procurar por pessoas</a></h4>
					</div>
				</div>
			</div>

		</div>


	    </div>
	
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	
	</body>
</html>