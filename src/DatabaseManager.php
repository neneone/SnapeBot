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
            $this->db = new \PDO('mysql:host='.$host.';dbname='.$databaseName, $username, $password);
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function checkUserInDatabase($userID, $name, $username = '')
    {
        $q = $this->db->prepare('SELECT * FROM '.$this->snapeSettings['database']['tableName'].' WHERE userID = :userID');
        $q->bindParam(':userID', $userID);
        $q->execute();
        if (0 == $q->rowCount()) {
            $this->addUserToDatabase($userID, $name, $username);
        } else {
            $this->u = $q->fetchAll(\PDO::FETCH_ASSOC)[0];
            if ($this->u['lastUpdate'] < date('Y-m-d')) {
                $this->updateUserInDatabase($userID, $name, $username);
            }
        }
    }

    public function addUserToDatabase($userID, $name, $username)
    {
        $q = $this->db->prepare('INSERT INTO '.$this->snapeSettings['database']['tableName'].' (userID, name, username, page, lastUpdate) VALUES (:userID, :name, :username, "", "'.date('Y-m-d').'")');
        $q->bindParam(':userID', $userID);
        $q->bindParam(':name', $name);
        $q->bindParam(':username', $username);
        $q->execute();
    }

    public function updateUserInDatabase($userID, $name, $username)
    {
        $q = $this->db->prepare('UPDATE '.$this->snapeSettings['database']['tableName'].' SET name = :name, username = :username, lastUpdate = "'.date('Y-m-d').'" WHERE userID = :userID');
        $q->bindParam(':name', $name);
        $q->bindParam(':username', $username);
        $q->bindParam(':userID', $userID);
        $q->execute();
    }
}
