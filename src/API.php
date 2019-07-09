<?php

namespace neneone\SnapeBot;

class API {
  public function __construct($botToken, $SnapeBot) {
    $this->botToken = $botToken;
    $this->SnapeBot = $SnapeBot;
  }

  public function BotAPI($method, $args = [])
  {
      $ch = curl_init();
      $ch_options = [
    CURLOPT_URL            => 'https://api.telegram.org/bot'.$this->botToken.'/'.$method,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => http_build_query($args),
    CURLOPT_RETURNTRANSFER => true,
  ];
      curl_setopt_array($ch, $ch_options);
      $result = curl_exec($ch);
      curl_close($ch);

      return json_decode($result, true);
  }

  public function sendMessage($chatID, $text, $rm = false, $keyboardType = 'inline', $disableNotification = false) {
    switch ($keyboardType) {
      case 'inline':
        $keyboard = [
          'inline_keyboard' => $rm
        ];
        break;
      case 'hide':
        $keyboard = [
          'hide_keyboard' => true
        ];
        break;
      default:
        $keyboard = [
          'keyboard' => $rm,
          'resize_keyboard' => true
        ];
    }
    $args = [
      'chat_id' => $chatID,
      'text' => $text,
      'disable_notification' => $disableNotification,
      'parse_mode' => 'HTML'
    ];
    if($rm) $args['reply_markup'] = json_encode($keyboard);

    return $this->BotAPI(__FUNCTION__, $args);
  }

  public function keyboard($alert = '', $text = false, $menu = false, $click = false) {
    $args = [
      'callback_query_id' => $this->SnapeBot->cbID,
      'text' => $alert,
      'show_alert' => $click
    ];
    $this->BotAPI('answerCallbackQuery', $args);
    if(isset($this->SnapeBot->cbMsgID) && $text != '') {
      $args = [
        'chat_id' => $this->SnapeBot->chatID,
        'message_id' => $this->SnapeBot->cbMsgID,
        'text' => $text,
        'parse_mode' => 'HTML'
      ];
      if($menu) {
        $rm = [
          'inline_keyboard' => $menu
        ];
        $args['reply_markup'] = json_encode($rm);
      }
      return $this->BotAPI('editMessageText', $args);
    }
  }
}

 ?>
