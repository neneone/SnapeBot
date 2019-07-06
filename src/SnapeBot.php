<?php

#TODO mettere buildSettings con il re-build degli array

namespace neneone\SnapeBot;

class SnapeBot
{
    public static $settingsScheme = [
    'getBotInformations' => [
      'type' => 'boolean',
      'default' => false,
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
        'db_name' => [
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
        ]
      ]
    ]
  ];

    public function __construct($botToken, $snapeSettings = [])
    {
        $this->snapeSettings = self::buildSettings($snapeSettings);
        $this->botToken = $botToken;

        if ($this->snapeSettings['getBotInformations']) {
            $getMe = (new \neneone\snapeBot\BotAPI($botToken))->getMe();
            if (isset($getMe['result']['username'])) {
                $this->botInformations = $getMe['result'];
                $this->botInformations['token'] = $botToken;
            } else {
                throw new Exception('Invalid token.');
            }
        }

        $this->BotAPI = new BotAPI($this->botToken);
        $this->db = (new DatabaseManager($this->snapeSettings['database']['host'], $this->snapeSettings['database']['db_name'], $this->snapeSettings['database']['username'], $this->snapeSettings['database']['password']))->db;
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
                $builtSettings[$settings] = $structure['default'];
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
                  $builtSettings[$settings] = $structure['default'];
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
                $builtSettings[$settings] = $structure['default'];
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
                $builtSettings[$settings] = $structure['default'];
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
                $builtSettings[$settings] = $structure['default'];
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
                $builtSettings[$settings] = $structure['default'];
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
                $builtSettings[$settings] = $structure['default'];
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
}
