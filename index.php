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
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>E-vento</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="css.css">
</head>
<body>
	<h1>E-VENTO IFMG</h1>
	<nav id="menu">
		<ul>
			<li><a href="cadAtividade.php">Cadastro de Atividades</a></li><br>
			<li><a href="cadParticipante.php">Cadastro de Participantes</a></li><br>
			<li><a href="registro.php">Registro de Presença</a></li><br>
			<li><a href="presentes.php">Lista de Presentes</a></li>
		</ul>
	</nav>
</body>
</html>
