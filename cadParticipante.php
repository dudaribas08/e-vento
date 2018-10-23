<?php 
require_once 'funcoes.php';
require_once 'banco.class.php';
require_once 'login.class.php';

session_start();

$banco = new Banco();
$login = new Login($banco);

if (!$login->usuarioEstaLogado()) {
	redirecionarPara('login.php');
}

$usuario = $login->getUsuario();

$mensagem = '';
if (isset($_POST['cadastrar'])) {
	$nome = $_POST['nome'];
	$email = $_POST['email'];
	$cpf = $_POST['cpf'];

	$banco->insertInto('Participante', [
		'nome_participante' => $nome,
		'email' => $email,
		'cpf' => $cpf,
	]);
	$mensagem = 'Participante cadastrado';
	
	redirecionarPara('index.php');

}



?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Cadastro de Participantes</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="css.css">
</head>
<body>
	<div id="conteiner">
		<h1>Cadastro de Participantes</h1>
		<p> <?=$mensagem?> </p>
		<form action="cadParticipante.php" method="post">
			<div><label for="inome">Nome </label><input name="nome" type="text" id="inome"></div>
			<div><label for="iemail">Email </label><input name="email" type="email" id="iemail"></div>
			<div><label for="icpf">CPF </label><input name="cpf" type="text" id="icpf"></div>
			<div><button name="cadastrar" type="submit">Cadastrar</button></div>
		</form>
	</div>
</body>
</html>