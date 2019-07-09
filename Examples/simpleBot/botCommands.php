<?php

if(isset($bot->msg) && $bot->msg == '/start') {
  $bot->API->sendMessage($bot->chatID, 'Hello World!' . PHP_EOL . 'Type /help to see my commands.');
  die;
}

if(isset($bot->msg) && $bot->msg == '/help') {
  $bot->API->sendMessage($bot->chatID, '<b>Bot Commands</b>' . PHP_EOL . '- /start: show the start message' . PHP_EOL . '- /help: show this message' . PHP_EOL . '- /inline: show an inline keyboard' . PHP_EOL . '- /keyboard: show a normal keyboard' . PHP_EOL . '- /hide: hide the normal keyboard');
  die;
}

if(isset($bot->msg) && $bot->msg == '/inline') {
  $inlineKeyboard[] = [
    [
      'text' => 'Edit this message',
      'callback_data' => 'edit'
    ],
    [
      'text' => 'Show an alert',
      'callback_data' => 'alert'
    ]
  ];
  $inlineKeyboard[] = [
    [
      'text' => 'Edit and alert',
      'callback_data' => 'edit_alert'
    ],
    [
      'text' => 'Notification without alert',
      'callback_data' => 'notification'
    ]
  ];
  $bot->API->sendMessage($bot->chatID, 'Inline Keyboard', $inlineKeyboard);
  die;
}

if(isset($bot->data) && $bot->data == 'edit') {
  $bot->API->keyboard('', 'New message');
  die;
}

if(isset($bot->data) && $bot->data == 'alert') {
  $bot->API->keyboard('Hey! This is an alert!', false, false, true);
  die;
}

if(isset($bot->data) && $bot->data == 'edit_alert') {
  $bot->API->keyboard('Hey! This is an alert!', 'New message', false, true);
  die;
}

if(isset($bot->data) && $bot->data == 'notification') {
  $bot->API->keyboard('Hey! This is a notification');
  die;
}

if(isset($bot->msg) && $bot->msg == '/keyboard') {
  $keyboard[] = [
    'Button 1',
    'Button 2'
  ];
  $keyboard[] = [
    'Button 3',
    'Button 4'
  ];
  $bot->API->sendMessage($bot->chatID, 'Normal keyboard', $keyboard, false, 'normal');
  die;
}

if(isset($bot->msg) && $bot->msg == '/hide') {
  $bot->API->sendMessage($bot->chatID, 'Keyboard removed', true, 'hide', false);
  die;
}

 ?>
