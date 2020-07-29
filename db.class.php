<?php

class db {

	//qual host
	private $host = 'localhost';

	//qual usuario
	private $usuario = 'root';

	//qual senha
	private $senha = '';

	//qual banco de dados
	private $database = 'twitter_clone';

	public function conecta_mysql(){
		//criar conexao
		$con = mysqli_connect($this->host, $this->usuario, $this->senha, $this->database);

		//ajustar o charset de comunicacao entre a aplicacao e o banco de dados
		mysqli_set_charset($con, 'utf8');

		//verificar se houve erro de conexão
		if(mysqli_connect_errno()){
			echo 'Erro ao tentar se conectar com o BD MySql : '.mysqli_connect_error();
		}

		return $con;
	}
}

?>