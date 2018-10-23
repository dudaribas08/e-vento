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

$atividades = $banco->selectSql('SELECT * FROM Atividade ORDER BY nome_atividade');

if (isset($_GET['id_atividade'])) {
  $id_atividade = $_GET['id_atividade'];

  $presentes = $banco->selectWhereSql("SELECT a.nome_atividade, p.nome_participante FROM Presenca pr INNER JOIN Participante p ON (p.id_participante = pr.id_participante) INNER JOIN Atividade a ON (a.id_atividade = pr.id_atividade) WHERE a.id_atividade = ? ORDER BY a.nome_atividade, p.nome_participante"
    , [
      $id_atividade
    ]);
} else {

  $presentes = $banco->selectSql("SELECT a.nome_atividade, p.nome_participante FROM Presenca pr INNER JOIN Participante p ON (p.id_participante = pr.id_participante) INNER JOIN Atividade a ON (a.id_atividade = pr.id_atividade) ORDER BY a.nome_atividade, p.nome_participante");

}
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
    <p><a href="index.php">Página Inicial</a></p>
    <h2>Atividades</h2>
    <p><a href="presentes.php">TODAS</a></p>
    <?php
    foreach ($atividades as $a) {
      ?>
      <p>
        <a href="presentes.php?id_atividade=<?= $a['id_atividade'] ?>"><?= $a['nome_atividade'] ?></a>
      </p>
    <?php
    }
    ?>

    <h2>Presentes</h2>
    <table border="1">
      <thead>
        <tr>
          <th>Atividade</th>
          <th>Participante</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($presentes as $p) {
          ?>
        <tr>
          <td><?= $p['nome_atividade'] ?></td>
          <td><?= $p['nome_participante'] ?></td>
        </tr>
        <?php
      }
      ?>
      </tbody>
  </div>
</body>
</html>
