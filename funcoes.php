<?php
function redirecionarPara($endereco) {
	header("Location: $endereco");
}


/* esta funcao cadastra se o post contiver
   os dados necessarios, senao nao faz nada.
	 Retorna 0 se nao conseguiu inserir ou
	 o numero de linhas inseridas (esperado: 1) */
function cadastrarParticipante($banco, $post) {

	if (!isset($post['nome']) || !isset($post['email']) || !isset($post['cpf'])) {
		return 0;
	}

	$nome = $post['nome'];
	$email = $post['email'];
	$cpf = $post['cpf'];
	if (isset($post['id'])) {

		return $banco->insertInto('Participante', [
			'id_participante' => $post['id'],
			'nome_participante' => $nome,
			'email' => $email,
			'cpf' => $cpf
		]);

	} else {

		return $banco->insertInto('Participante', [
			'nome_participante' => $nome,
			'email' => $email,
			'cpf' => $cpf
		]);
	}
}
