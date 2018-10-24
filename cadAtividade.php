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
	$local = $_POST['local'];
	$data = $_POST['data'];
	$descricao = $_POST['descricao'];

	$banco->insertInto('Atividade', [
		'nome_atividade' => $nome,
		'local_evento' => $local,
		'data_atividade' => $data,
		'descricao' => $descricao
	]);
	$mensagem = 'atividade cadastrada';
	redirecionarPara('index.php');
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Cadastro de Atividades</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="css.css">
</head>
<body>
	<div id="voltarmenu">
		<a href="index.php">← Menu</a>
	</div>

	<div id="conteiner">
		<h1>Cadastro de Atividades</h1>
		<p> <?=$mensagem?> </p>
		<form action="cadAtividade.php" method="post">
			<div><label for="inome">Nome </label><input name="nome" type="text" id="inome" autofocus required mozactionhint="next"></div>
			<div><label for="ilocal">Local </label><input name="local" type="text" id="ilocal" mozactionhint="next"></div>
			<div><label for="idata">Data</label><input name="data" type="datetime-local" id="idata" required mozactionhint="next"></div>
			<div><label for="idescricao">Descrição</label><input name="descricao" type="text" id="idescricao" mozactionhint="go"></div>
			<div><button name="cadastrar" type="submit">Cadastrar</button></div>
		</form>
	</div>
</body>
</html>
