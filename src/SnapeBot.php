<?php

namespace neneone\SnapeBot;

class SnapeBot
{
    use \neneone\SnapeBot\DatabaseManager;

    public static $settingsScheme = [
    'getBotInformations' => [
      'type' => 'boolean',
      'default' => false,
      'required' => false
    ],
    'botUsername' => [
      'type' => 'string',
      'default' => false,
      'required' => false
    ],
    'firstRun' => [
      'type' => 'boolean',
      'default' => true,
      'required' => false
    ],
    'autoSaveUsers' => [
      'type' => 'boolean',
      'default' => true,
      'required' => false
    ],
    'database' => [
      'type' => 'array',
      'required' => true,
      'structure' => [
        'host' => [
          'type' => 'string',
          'default' => 'localhost',
          'required' => false
        ],
        'dbName' => [
          'type' => 'string',
          'required' => true
        ],
        'username' => [
          'type' => 'string',
          'required' => true
        ],
        'password' => [
          'type' => 'string',
          'default' => '',
          'required' => false
        ],
        'tableName' => [
          'type' => 'string',
          'default' => 'SnapeBot',
          'required' => false
        ]
      ]
    ]
  ];

    public function __construct($botToken, $update, $snapeSettings = [])
    {
        $this->snapeSettings = self::buildSettings($snapeSettings);
        $this->botToken = $botToken;
        $this->tName = $this->snapeSettings['database']['tableName'];

        if ($this->snapeSettings['getBotInformations'] || !isset($this->snapeSettings['botUsername'])) {
            $getMe = (new \neneone\snapeBot\BotAPI($botToken))->getMe();
            if (isset($getMe['result']['username'])) {
                $this->botInformations = $getMe['result'];
                $this->snapeSettings['botUsername'] = $this->botInformations['username'];
            } else {
                throw new Exception('Invalid token.');
            }
        }

        $this->BotAPI = new BotAPI($this->botToken);
        $this->API = new API($this->botToken, $this);
        $this->connectToDatabase($this->snapeSettings['database']['host'], $this->snapeSettings['database']['dbName'], $this->snapeSettings['database']['username'], $this->snapeSettings['database']['password']);

        file_put_contents('settings.json', json_encode($this->snapeSettings, JSON_PRETTY_PRINT));
        if($this->snapeSettings['firstRun'] == true) {
          $this->firstRun();
        }
        foreach(get_object_vars(new VariablesMaker($update)) as $var => $value) {
          $this->$var = $value;
        }
        if(isset($this->userID) && $this->userID) $this->checkUserInDatabase($this->userID, $this->fullName, (isset($this->username) ? $this->username : ''));
    }

    public static function buildSettings($settings, $settingsScheme = false)
    {
        if($settingsScheme == false) $settingsScheme = self::$settingsScheme;
        foreach ($settingsScheme as $setting => $structure) {
            if (!isset($settings[$setting]) && $structure['required'] == true) {
                throw new Exception('Missing required setting: ' . $setting . '.');
                $missingSetting = true;
            } elseif (!isset($settings[$setting])) {
              if(isset($structure['default'])) {
                $builtSettings[$setting] = $structure['default'];
              } else {
                throw new \neneone\SnapeBot\Exception('Missing setting "' . $setting . '" that has no default value.');
              }
            } else {
                switch ($structure['type']) {
          case 'boolean':
          case 'bool':
            if (is_bool($settings[$setting])) {
                $builtSettings[$setting] = $settings[$setting];
            } else {
                if(isset($structure['default'])) {
                  $builtSettings[$setting] = $structure['default'];
                } else {
                  throw new \neneone\SnapeBot\Exception('Missing setting "' . $setting . '" that has no default value.');
                }
            }
            break;
          case 'string':
          case 'str':
            if (is_string($settings[$setting])) {
                $builtSettings[$setting] = $settings[$setting];
            } else {
              if(isset($structure['default'])) {
                $builtSettings[$setting] = $structure['default'];
              } else {
                throw new \neneone\SnapeBot\Exception('Missing setting "' . $setting . '" that has no default value.');
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
              if(isset($structure['default'])) {
                $builtSettings[$setting] = $structure['default'];
              } else {
                throw new \neneone\SnapeBot\Exception('Missing setting "' . $setting . '" that has no default value.');
              }
            }
            break;
          case 'array':
            if (is_array($settings[$setting])) {
                $builtSettings[$setting] = self::buildSettings($settings[$setting], $structure['structure']);
            } else {
              if(isset($structure['default'])) {
                $builtSettings[$setting] = $structure['default'];
              } else {
                throw new \neneone\SnapeBot\Exception('Missing setting "' . $setting . '" that has no default value.');
              }
            }
            break;
          case 'object':
          case 'obj':
            if (is_object($settings[$setting])) {
                $builtSettings[$setting] = $settings[$setting];
            } else {
              if(isset($structure['default'])) {
                $builtSettings[$setting] = $structure['default'];
              } else {
                throw new \neneone\SnapeBot\Exception('Missing setting "' . $setting . '" that has no default value.');
              }
            }
            break;
          case 'NULL':
            if (is_null($settings[$setting])) {
                $builtSettings[$setting] = $settings[$setting];
            } else {
              if(isset($structure['default'])) {
                $builtSettings[$setting] = $structure['default'];
              } else {
                throw new \neneone\SnapeBot\Exception('Missing setting "' . $setting . '" that has no default value.');
              }
            }
            break;
          default:
              $builtSettings[$setting] = $settings[$setting];
            break;
        }
            }
        }
        if (isset($missingSetting) && $missingSetting == true) {
            die;
        }
        return $builtSettings;
    }

    private function firstRun() {
      $createTable = $this->db->query('CREATE TABLE IF NOT EXISTS ' . $this->tName . ' (
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
