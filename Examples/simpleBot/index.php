<?php

require_once __DIR__ . '/vendor/autoload.php';

$settings = [
  'database' => [
    'host' => 'localhost',
    'dbName' => 'myAwesomeDatabase',
    'username' => 'root',
    'password' => 'MyAwesomePassword',
    'tableName' => 'MyAwesomeBot'
  ],
  'botUsername' => 'myAwesomeBot',
  'firstRun' => false,
];

$update = json_decode(file_get_contents('php://input'), true);

$bot = new \neneone\SnapeBot\SnapeBot('Bot Token', $update, $settings);

require __DIR__ . '/botCommands.php';

 ?>
