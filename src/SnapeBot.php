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

class SnapeBot
{
    use \neneone\SnapeBot\DatabaseManager;
    use \neneone\SnapeBot\VariablesMaker;

    public static $settingsScheme = [
    'getBotInformations' => [
      'type' => 'boolean',
      'default' => false,
      'required' => false,
    ],
    'botUsername' => [
      'type' => 'string',
      'default' => false,
      'required' => false,
    ],
    'endPoint' => [
      'type' => 'string',
      'default' => 'https://api.telegram.org/',
      'required' => false,
    ],
    'firstRun' => [
      'type' => 'boolean',
      'default' => true,
      'required' => false,
    ],
    'autoSaveUsers' => [
      'type' => 'boolean',
      'default' => true,
      'required' => false,
    ],
    'cbDataEncryption' => [
      'type' => 'boolean',
      'default' => false,
      'required' => false,
    ],
    'encryptionData' => [
      'type' => 'array',
      'default' => [
        'key' => 'SnapeBotKey2019',
        'iv' => 'SnapeBotAwesomeIV2019',
      ],
      'required' => false,
      'structure' => [
        'key' => [
          'type' => 'string',
          'default' => 'SnapeBotKey2019',
          'required' => false,
        ],
        'iv' => [
          'type' => 'string',
          'default' => 'SnapeBotAwesomeIV2019',
          'required' => false,
        ],
      ],
    ],
    'database' => [
      'type' => 'array',
      'default' => false,
      'required' => false,
      'structure' => [
        'host' => [
          'type' => 'string',
          'default' => 'localhost',
          'required' => false,
        ],
        'dbName' => [
          'type' => 'string',
          'required' => true,
        ],
        'username' => [
          'type' => 'string',
          'required' => true,
        ],
        'password' => [
          'type' => 'string',
          'default' => '',
          'required' => false,
        ],
        'tableName' => [
          'type' => 'string',
          'default' => 'SnapeBot',
          'required' => false,
        ],
      ],
    ],
  ];

    public function __construct($botToken, $update, $settings = [])
    {
        $this->settings = self::buildSettings($settings);
        $this->botToken = $botToken;
        $this->botUsername = $this->settings['botUsername'];
        $this->tName = is_array($this->settings['database']) ? ($this->settings['database']['tableName'] ?? 'SnapeBot') : 'SnapeBot';

        if ($this->settings['getBotInformations'] || !isset($this->settings['botUsername'])) {
            $getMe = (new \neneone\snapeBot\BotAPI($botToken))->getMe();
            if (isset($getMe['result']['username'])) {
                $this->botInformations = $getMe['result'];
                $this->settings['botUsername'] = $this->botInformations['username'];
            } else {
                throw new Exception('Invalid token.');
            }
        }

        $this->BotAPI = new BotAPI($this->botToken);
        $this->API = new API($this->botToken, $this);
        if ($this->settings['database']) {
            $this->db = $this->connectToDatabase($this->settings['database']['host'], $this->settings['database']['dbName'], $this->settings['database']['username'], $this->settings['database']['password']);
        }
        if ($this->settings['firstRun'] == true) {
            $this->firstRun();
        }
        $this->update = $update;
        $this->makeVariables();
        if (isset($this->userID) && $this->userID && $this->settings['database']) {
            $this->u = $this->checkUserInDatabase($this->userID, $this->fullName, (isset($this->username) ? $this->username : ''));
        }
    }

    public static function buildSettings($settings, $settingsScheme = false)
    {
        if ($settingsScheme == false) {
            $settingsScheme = self::$settingsScheme;
        }
        foreach ($settingsScheme as $setting => $structure) {
            if (!isset($settings[$setting]) && true == $structure['required']) {
                throw new Exception('Missing required setting: '.$setting.'.');
            } elseif (!isset($settings[$setting])) {
                if (isset($structure['default'])) {
                    $builtSettings[$setting] = $structure['default'];
                } else {
                    throw new \neneone\SnapeBot\Exception('Missing setting "'.$setting.'" that has no default value.');
                }
            } else {
                switch ($structure['type']) {
          case 'boolean':
          case 'bool':
            if (is_bool($settings[$setting])) {
                $builtSettings[$setting] = $settings[$setting];
            } else {
                if (isset($structure['default'])) {
                    $builtSettings[$setting] = $structure['default'];
                } else {
                    throw new \neneone\SnapeBot\Exception('Missing setting "'.$setting.'" that has no default value.');
                }
            }

            break;
          case 'string':
          case 'str':
            if (is_string($settings[$setting])) {
                $builtSettings[$setting] = $settings[$setting];
            } else {
                if (isset($structure['default'])) {
                    $builtSettings[$setting] = $structure['default'];
                } else {
                    throw new \neneone\SnapeBot\Exception('Missing setting "'.$setting.'" that has no default value.');
                }
            }

            break;
          case 'integer':
          case 'int':
          case 'float':
          case 'double':
            if (is_int($settings[$setting]) || is_float($settings[$setting])) {
                $builtSettings[$setting] = $settings[$setting];
            } else {
                if (isset($structure['default'])) {
                    $builtSettings[$setting] = $structure['default'];
                } else {
                    throw new \neneone\SnapeBot\Exception('Missing setting "'.$setting.'" that has no default value.');
                }
            }

            break;
          case 'array':
            if (is_array($settings[$setting])) {
                $builtSettings[$setting] = self::buildSettings($settings[$setting], $structure['structure']);
            } else {
                if (isset($structure['default'])) {
                    $builtSettings[$setting] = $structure['default'];
                } else {
                    throw new \neneone\SnapeBot\Exception('Missing setting "'.$setting.'" that has no default value.');
                }
            }

            break;
          case 'object':
          case 'obj':
            if (is_object($settings[$setting])) {
                $builtSettings[$setting] = $settings[$setting];
            } else {
                if (isset($structure['default'])) {
                    $builtSettings[$setting] = $structure['default'];
                } else {
                    throw new \neneone\SnapeBot\Exception('Missing setting "'.$setting.'" that has no default value.');
                }
            }

            break;
          case 'NULL':
            if (is_null($settings[$setting])) {
                $builtSettings[$setting] = $settings[$setting];
            } else {
                if (isset($structure['default'])) {
                    $builtSettings[$setting] = $structure['default'];
                } else {
                    throw new \neneone\SnapeBot\Exception('Missing setting "'.$setting.'" that has no default value.');
                }
            }

            break;
          default:
              $builtSettings[$setting] = $settings[$setting];

            break;
        }
            }
        }

        return $builtSettings;
    }

    private function firstRun()
    {
        if ($this->settings['database']) {
            $this->db->query('CREATE TABLE IF NOT EXISTS '.$this->tName.' (
            ID int NOT NULL AUTO_INCREMENT,
            userID bigint(255),
            name varchar(255),
            username varchar(32),
            page varchar(255),
            lastUpdate date,
            PRIMARY KEY (ID)
          )');
        }
    }

    public function specialEncrypt($string)
    {
        $key = hash('sha256', $this->settings['encryptionData']['key']);
        $iv = substr(hash('sha256', $this->settings['encryptionData']['iv']), 0, 16);

        return base64_encode(openssl_encrypt($string, 'AES-256-CBC', $key, 0, $iv));
    }

    public function specialDecrypt($string)
    {
        $key = hash('sha256', $this->settings['encryptionData']['key']);
        $iv = substr(hash('sha256', $this->settings['encryptionData']['iv']), 0, 16);

        return openssl_decrypt(base64_decode($string), 'AES-256-CBC', $key, 0, $iv);
    }
}
