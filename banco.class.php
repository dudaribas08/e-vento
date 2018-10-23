<?php
class Banco {

  private $nomeBanco = 'checkin';
  private $usuarioBanco = 'checkin';
  private $senhaBanco = '123';

  private $pdo;

  function __construct() {
    $this->pdo = new PDO("mysql:dbname={$this->nomeBanco};host=localhost", $this->usuarioBanco, $this->senhaBanco);
  }

  function selectSql($sql) {
    $comando = $this->pdo->query($sql);
    return $comando->fetchAll();
  }

  function select($tabela) {
    $sql = "SELECT * FROM $tabela";
    return $this->selectSql($sql);
  }

  function selectWhereSql($sql, $valores) {
    $comando = $this->pdo->prepare($sql);
    $comando->execute($valores);
    return $comando->fetchAll();
  }

  function selectWhere($tabela, $parametros) {
    $sql = "SELECT * FROM $tabela WHERE ";
    foreach (array_keys($parametros) as $parametro) {
      $sql = $sql . $parametro . '=? AND ';
    }
    $sql = $sql . '1=1';
    return $this->selectWhereSql($sql, array_values($parametros));
  }

  function insertInto($tabela, $valores) {
    $sql = "INSERT INTO $tabela (";
    $colunas = array_keys($valores);
    $sql .= join(', ', $colunas);
    $sql .= ") VALUES (";
    $sql .= join(', ', array_fill(0, count($valores), '?'));
    $sql .= ")";

    $comando = $this->pdo->prepare($sql);
    $comando->execute(array_values($valores));
    return $comando->rowCount();
  }

}
