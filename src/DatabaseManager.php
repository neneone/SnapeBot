<?php

namespace neneone\SnapeBot;

trait DatabaseManager {
  public function connectToDatabase($host, $databaseName, $username, $password) {
    try {
      $this->db = new \PDO('mysql:host=' . $host . ';dbname=' . $databaseName, $username, $password);
    } catch (\PDOException $e) {
      die($e->getMessage());
    }
  }
}

 ?>
