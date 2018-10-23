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

$mensagem = '';
if (isset($_POST['cadastrar'])) {
	$id_atividade = $_POST['id_participante'];
	$id_participante = $_POST['id_atividade'];


	$banco->insertInto('Presenca', [
		'id_participante' => $id_participante,
		'id_atividade' => $id_atividade,
		
	]);
	$mensagem = 'atividade cadastrada';
}



/* conectar com o banco e fazer um insert no banco */
var_dump($_POST);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>E-vento - presença</title>
	<link rel="stylesheet" href="css.css">
</head>
<body>
	<div id="conteiner">
		<h2>Presença Registrada!</h2>
		<p>Nome: </p>
		<p>Atividade: </p>
	</div>
</body>
</html>
