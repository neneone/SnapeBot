<?php

/*
 * SnapeBot, PHP Framework for Telegram Bots
 * Copyright (C) 2019 Enea Dolcini
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace neneone\SnapeBot;

trait DatabaseManager
{
    public function connectToDatabase($host, $databaseName, $username, $password)
    {
        try {
            $db = new \PDO('mysql:host='.$host.';dbname='.$databaseName, $username, $password);
        } catch (\PDOException $e) {
            throw new \neneone\SnapeBot\Exception('PDOException during connection to database', 0, $e);
        }
        return $db;
    }

    public function checkUserInDatabase($userID, $name, $username = '')
    {
        $q = $this->db->prepare('SELECT * FROM '.$this->tName.' WHERE userID = :userID');
        $q->bindParam(':userID', $userID);
        $q->execute();
        if ($q->rowCount() == 0) {
            $this->addUserToDatabase($userID, $name, $username);
            $u = $this->checkUserInDatabase($userID, $name, $username);
            return $u;
        }
        $u = $q->fetchAll(\PDO::FETCH_ASSOC)[0];
        if ($u['lastUpdate'] < date('Y-m-d')) {
            $this->updateUserInDatabase($userID, $name, $username);
        }
        return $u;
    }

    public function addUserToDatabase($userID, $name, $username)
    {
        $q = $this->db->prepare('INSERT INTO '.$this->tName.' (userID, name, username, page, lastUpdate) VALUES (:userID, :name, :username, "", "'.date('Y-m-d').'")');
        $q->bindParam(':userID', $userID);
        $q->bindParam(':name', $name);
        $q->bindParam(':username', $username);
        $q->execute();
    }

    public function updateUserInDatabase($userID, $name, $username)
    {
        $q = $this->db->prepare('UPDATE '.$this->tName.' SET name = :name, username = :username, lastUpdate = "'.date('Y-m-d').'" WHERE userID = :userID');
        $q->bindParam(':name', $name);
        $q->bindParam(':username', $username);
        $q->bindParam(':userID', $userID);
        $q->execute();
    }

    public function setPage($page = '', $userID = false, $field = 'page') {
      if($userID == false) {
        if(isset($this->userID)) $userID = $this->userID; else throw new Exception('Missing userID while required in setPage');
      }
      $q = $this->db->prepare('UPDATE '.$this->tName.' SET ' . $field . ' = :page WHERE userID = :userID');
      $q->bindParam(':page', $page);
      $q->bindParam(':userID', $userID);
      $q->execute();
    }
}
