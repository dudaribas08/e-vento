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

$filtro = "";
if (isset($_GET['id_atividade'])) {
  $id_atividade = $_GET['id_atividade'];

  $presentes = $banco->selectWhereSql("SELECT a.id_atividade, p.id_participante, a.nome_atividade, p.nome_participante FROM Presenca pr INNER JOIN Participante p ON (p.id_participante = pr.id_participante) INNER JOIN Atividade a ON (a.id_atividade = pr.id_atividade) WHERE a.id_atividade = ? ORDER BY a.nome_atividade, p.nome_participante"
    , [
      $id_atividade
    ]);

		$filtro = "Mostrando apenas os presentes na Atividade $id_atividade";
} else {

  $presentes = $banco->selectSql("SELECT a.id_atividade, p.id_participante, a.nome_atividade, p.nome_participante FROM Presenca pr INNER JOIN Participante p ON (p.id_participante = pr.id_participante) INNER JOIN Atividade a ON (a.id_atividade = pr.id_atividade) ORDER BY a.nome_atividade, p.nome_participante");

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
		<p><?= $filtro ?></p>
    <table border="1" class="tabela">
      <thead>
        <tr>
          <th>Atividade</th>
          <th>Participante</th>
					<th>Opções</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($presentes as $p) {
          ?>
        <tr>
          <td><?= $p['nome_atividade'] ?></td>
          <td><?= $p['nome_participante'] ?></td>
					<td><button type="button"
						onclick="excluir(this)" data-idatividade="<?= $p['id_atividade'] ?>"
						data-idparticipante="<?= $p['id_participante'] ?>">❎ Excluir</button></td>
        </tr>
        <?php
      }
      ?>
      </tbody>
  </div>
	<script>
	function excluir(botao) {
		botao.disabled = true;

		var form = new FormData();
		form.append('id_atividade', botao.dataset.idatividade);
		form.append('id_participante', botao.dataset.idparticipante);

		var xhr = new XMLHttpRequest();

		xhr.addEventListener('load', function(e) {
			if (xhr.responseText == '0') {
				alert('Não consegui excluir :(');
			} else {
				botao.parentElement.parentElement.remove(); /* retira a linha */
			}
		});

		xhr.addEventListener('loadend', function() {
			botao.disabled = false;
		});

		xhr.open('POST', 'excluirPresenca.php');
		xhr.send(form);

	}
	</script>
</body>
</html>
