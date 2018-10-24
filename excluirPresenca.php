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

header('Content-type: text/plain');

if (isset($_POST['id_atividade']) && isset($_POST['id_participante'])) {

  $id_atividade = $_POST['id_atividade'];
  $id_participante = $_POST['id_participante'];

  $linhasAfetadas = $banco->deleteFromWhere('Presenca', [
    'id_atividade' => $id_atividade,
    'id_participante' => $id_participante
  ]);

  echo $linhasAfetadas;

} else {
  echo 0;
}
?>
