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
  public function checkUserInDatabase($userID, $name, $username = '') {
    $q = $this->db->prepare('SELECT ID, lastUpdate FROM ' . $this->snapeSettings['database']['tableName'] . ' WHERE userID = :userID');
    $q->bindParam(':userID', $userID);
    $q->execute();
    if($q->rowCount() == 0) {
      $this->addUserToDatabase($userID, $name, $username);
    } elseif($q->fetchAll(\PDO::FETCH_ASSOC)[0]['lastUpdate'] < date('Y-m-d')) {
      $this->updateUserInDatabase($userID, $name, $username);
    }
  }
  public function addUserToDatabase($userID, $name, $username) {
    $q = $this->db->prepare('INSERT INTO ' . $this->snapeSettings['database']['tableName'] . ' (userID, name, username, page, lastUpdate) VALUES (:userID, :name, :username, "", "' . date('Y-m-d') . '")');
    $q->bindParam(':userID', $userID);
    $q->bindParam(':name', $name);
    $q->bindParam(':username', $username);
    $q->execute();
  }
  public function updateUserInDatabase($userID, $name, $username) {
    $q = $this->db->prepare('UPDATE ' . $this->snapeSettings['database']['tableName'] . ' SET name = :name, username = :username, lastUpdate = "' . date('Y-m-d') . '" WHERE userID = :userID');
    $q->bindParam(':name', $name);
    $q->bindParam(':username', $username);
    $q->bindParam(':userID', $userID);
    $q->execute();
  }
}

 ?>
