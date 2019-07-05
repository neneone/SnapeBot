<?php

namespace neneone\SnapeBot;

class SnapeBot
{
    public static $settingsScheme = [
    'getBotInformations' => [
      'type' => 'boolean',
      'default' => false,
      'required' => false
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
    }

    public static function buildSettings($settings)
    {
        foreach (self::$settingsScheme as $setting => $structure) {
            if (!isset($settings[$setting]) && $structure['required'] == true) {
                throw new Exception('Missing required setting: ' . $setting . '.');
                $missingSetting = true;
            } elseif (!isset($settings[$setting])) {
                $builtSettings[$setting] = $structure['default'];
            } else {
                switch ($structure['type']) {
          case 'boolean':
          case 'bool':
            if (is_bool($settings[$setting])) {
                $builtSettings[$setting] = $settings[$setting];
            } else {
                $builtSettings[$setting] = $structure['default'];
            }
            break;
          case 'string':
          case 'str':
            if (is_string($settings[$setting])) {
                $builtSettings[$setting] = $settings[$setting];
            } else {
                $builtSettings[$setting] = $structure['default'];
            }
            break;
          case 'integer':
          case 'int':
          case 'float':
          case 'double':
            if (is_int($settings[$setting]) || is_float($settings[$setting])) {
                $builtSettings[$setting] = $settings[$setting];
            } else {
                $builtSettings[$setting] = $structure['default'];
            }
            break;
          case 'array':
            if (is_array($settings[$setting])) {
                $builtSettings[$setting] = $settings[$setting];
            } else {
                $builtSettings[$setting] = $structure['default'];
            }
            break;
          case 'object':
          case 'obj':
            if (is_object($settings[$setting])) {
                $builtSettings[$setting] = $settings[$setting];
            } else {
                $builtSettings[$setting] = $structure['default'];
            }
            break;
          case 'NULL':
            if (is_null($settings[$setting])) {
                $builtSettings[$setting] = $settings[$setting];
            } else {
                $builtSettings[$setting] = $structure['default'];
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
