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

require_once __DIR__.'/vendor/autoload.php';

$settings = [
  'database' => [
    'host' => 'localhost',
    'dbName' => 'myAwesomeDatabase',
    'username' => 'root',
    'password' => 'MyAwesomePassword',
    'tableName' => 'MyAwesomeBot',
  ],
  'botUsername' => 'myAwesomeBot',
  'firstRun' => false,
];

$update = json_decode(file_get_contents('php://input'), true);

$bot = new \neneone\SnapeBot\SnapeBot('Bot Token', $update, $settings);

require __DIR__.'/botCommands.php';
