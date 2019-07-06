<?php

namespace neneone\SnapeBot;

class DatabaseManager {
  public function __construct($host, $databaseName, $username, $password) {
    try {
      $this->db = new \PDO('mysql:host=' . $host . ';dbname=' . $databaseName, $username, $password);
    } catch (\PDOException $e) {
      file_put_contents('pdo.log', $e->getMessage . PHP_EOL, FILE_APPEND);
      die($e->getMessage());
    }
  }
}

 ?>
