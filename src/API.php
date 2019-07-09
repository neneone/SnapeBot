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

class API
{
    public function __construct($botToken, $SnapeBot)
    {
        $this->botToken = $botToken;
        $this->SnapeBot = $SnapeBot;
    }

    public function BotAPI($method, $args = [])
    {
        $ch = curl_init();
        $ch_options = [
    CURLOPT_URL => 'https://api.telegram.org/bot'.$this->botToken.'/'.$method,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query($args),
    CURLOPT_RETURNTRANSFER => true,
  ];
        curl_setopt_array($ch, $ch_options);
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }

    public function sendMessage($chatID, $text, $rm = false, $keyboardType = 'inline', $disableNotification = false)
    {
        switch ($keyboardType) {
      case 'inline':
        $keyboard = [
          'inline_keyboard' => $rm,
        ];
        if (true == $this->SnapeBot->snapeSettings['cbDataEncryption']) {
            $keyboard = $this->encryptKeyboard($keyboard);
        }

        break;
      case 'hide':
        $keyboard = [
          'hide_keyboard' => true,
        ];

        break;
      default:
        $keyboard = [
          'keyboard' => $rm,
          'resize_keyboard' => true,
        ];
    }
        $args = [
      'chat_id' => $chatID,
      'text' => $text,
      'disable_notification' => $disableNotification,
      'parse_mode' => 'HTML',
    ];
        if ($rm) {
            $args['reply_markup'] = json_encode($keyboard);
        }

        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function keyboard($alert = '', $text = false, $menu = false, $click = false)
    {
        $args = [
      'callback_query_id' => $this->SnapeBot->cbID,
      'text' => $alert,
      'show_alert' => $click,
    ];
        $this->BotAPI('answerCallbackQuery', $args);
        if (isset($this->SnapeBot->cbMsgID) && '' != $text) {
            $args = [
        'chat_id' => $this->SnapeBot->chatID,
        'message_id' => $this->SnapeBot->cbMsgID,
        'text' => $text,
        'parse_mode' => 'HTML',
      ];
            if ($menu) {
                $rm = [
          'inline_keyboard' => $menu,
        ];
                $args['reply_markup'] = json_encode($rm);
            }

            return $this->BotAPI('editMessageText', $args);
        }
    }

    public function encryptKeyboard($keyboard)
    {
        foreach ($keyboard['inline_keyboard'] as $pos => $line) {
            foreach ($line as $pp => $kk) {
                foreach ($kk as $type => $data) {
                    if ('callback_data' == $type) {
                        $keyboard['inline_keyboard'][$pos][$pp][$type] = $this->SnapeBot->specialEncrypt($data);
                    }
                }
            }
        }

        return $keyboard;
    }
}
