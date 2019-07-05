<?php

namespace neneone\SnapeBot;

class API {
  public function __construct($botToken) {
    $this->botToken = $botToken;
  }

  public function BotAPI($method, $args = [])
  {
      $ch = curl_init();
      $ch_options = [
    CURLOPT_URL            => 'https://api.telegram.org/bot'.$this->token.'/'.$method,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => http_build_query($args),
    CURLOPT_RETURNTRANSFER => true,
  ];
      curl_setopt_array($ch, $ch_options);
      $result = curl_exec($ch);
      curl_close($ch);

      return json_decode($result, true);
  }

  public function sendMessage($chatID, $text, $rmf = false, $inline = 'pred', $dis = false) {
      if ($inline == 'pred') {
          $inline = true;
      }
      $dal = false;
      if (!$inline) {
          if ($rmf == 'hide') {
              $rm = array(
                  'hide_keyboard' => true
              );
          } else {
              $rm = array(
                  'keyboard' => $rmf,
                  'resize_keyboard' => true
              );
          }
      } else {
          $rm = array(
              'inline_keyboard' => $rmf
          );
      }
      $rm   = json_encode($rm);
      $args = array(
          'chat_id' => $chatID,
          'text' => $text,
          'disable_notification' => $dis,
          'parse_mode' => 'HTML'
      );
      if ($dal) {
          $args['disable_web_page_preview'] = $dal;
      }
      if ($replyto) {
          $args['reply_to_message_id'] = $replyto;
      }
      if ($rmf) {
          $args['reply_markup'] = $rm;
      }
        return $this->BotAPI(__FUNCTION__, $args);
  }

  function keyboard($text, $ntext = false, $nmenu = false, $alert = false) {
      global $cbid;
      global $cbmid;
      global $chatID;
      global $update;
      $args = array(
          'callback_query_id' => $cbid,
          'text' => $text,
          'show_alert' => $alert
      );
      $r    = $this->BotAPI('answerCallbackQuery', $args);
      if ($cbmid) {
          if ($nmenu) {
              $rm = array(
                  'inline_keyboard' => $nmenu
              );
              $rm = json_encode($rm);
          }
          $args = array(
              'chat_id' => $chatID,
              'message_id' => $cbmid,
              'text' => $ntext,
              'parse_mode' => 'HTML'
          );
          if ($nmenu) {
              $args['reply_markup'] = $rm;
          }
          $r = $this->BotAPI('editMessageText', $args);
          return $r;
      }
  }
}

 ?>
