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
if (isset($_POST['cpf_participante']) && isset($_POST['id_atividade'])) {
	$id_atividade = $_POST['id_atividade'];
	$cpf_participante = $_POST['cpf_participante'];

	$atividade = $banco->selectWhere('Atividade', [
		'id_atividade' => $id_atividade
	]);

	if (count($atividade) == 0) {
		die("Erro: atividade não encontrada");
	}

	$atividade = $atividade[0];

	$participante = $banco->selectWhere('Participante', [
		'cpf' => $cpf_participante
	]);

	if (count($participante) == 0) {
		$mensagem = "Participante não identificado :( Te redirecionando para o cadastro em 3 segundos...";
		header('Refresh: 3;URL=cadParticipante.php');
	} else {

		$participante = $participante[0];

		$linhasAfetadas = $banco->insertInto('Presenca', [
			'id_participante' => $participante['id_participante'],
			'id_atividade' => $id_atividade
		]);

		if ($linhasAfetadas == 0) {
			$mensagem = 'Presença <i>já está</i> registrada!';
		} else {
			$mensagem = 'Presença registrada!';
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>E-vento - presença</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css.css">
</head>
<body>
	<div id="voltarmenu">
		<a href="index.php">← Menu</a>
	</div>

	<div id="conteiner">
		<h2><?= $mensagem ?></h2>
		<p>Nome: <?= isset($participante) ? $participante['nome_participante'] : '' ?></p>
		<p>Atividade: <?= isset($atividade) ? $atividade['nome_atividade'] : '' ?></p>
		<p><a href="qrcode.php?id=<?= $id_atividade ?>">Registrar Nova Presença</a></p>
	</div>
</body>
</html>
