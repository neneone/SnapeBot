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

class BotAPI implements BotAPIScheme
{
    public function __construct($token)
    {
        $this->token = $token;
    }

    public function BotAPI($method, $args = [])
    {
        $ch = curl_init();
        $ch_options = [
      CURLOPT_URL => 'https://api.telegram.org/bot'.$this->token.'/'.$method,
      CURLOPT_POST => true,
      CURLOPT_POSTFIELDS => http_build_query($args),
      CURLOPT_RETURNTRANSFER => true,
    ];
        curl_setopt_array($ch, $ch_options);
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }

    public function getUpdates($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function setWebhook($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function deleteWebhook()
    {
        return $this->BotAPI(__FUNCTION__);
    }

    public function getWebhookInfo()
    {
        return $this->BotAPI(__FUNCTION__);
    }

    public function getMe()
    {
        return $this->BotAPI(__FUNCTION__);
    }

    public function sendMessage($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function forwardMessage($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function sendPhoto($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function sendAudio($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function sendDocument($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function sendVideo($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function sendAnimation($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function sendVoice($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function sendVideoNote($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function sendMediaGroup($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function sendLocation($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function editMessageLiveLocation($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function stopMessageLiveLocation($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function sendVenue($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function sendContact($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function sendPoll($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function sendChatAction($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function getUserProfilePhotos($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function getFile($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function kickChatMember($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function unbanChatMember($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function restrictChatMember($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function promoteChatMember($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function exportChatInviteLink($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function setChatPhoto($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function deleteChatPhoto($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function setChatTitle($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function setChatDescription($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function pinChatMessage($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function unpinChatMessage($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function leaveChat($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function getChat($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function getChatAdministrators($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function getChatMembersCount($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function getChatMember($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function setChatStickerSet($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function deleteChatStickerSet($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function answerCallbackQuery($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function editMessageText($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function editMessageCaption($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function editMessageMedia($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function editMessageReplyMarkup($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function stopPoll($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function deleteMessage($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function sendSticker($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function getStickerSet($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function uploadStickerFile($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function createNewStickerSet($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function addStickerToSet($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function setStickerPositionInSet($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function deleteStickerFromSet($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function answerInlineQuery($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function sendInvoice($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function answerShippingQuery($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function answerPreCheckoutQuery($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function setPassportDataErrors($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function sendGame($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function setGameScore($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }

    public function getGameHighScores($args)
    {
        return $this->BotAPI(__FUNCTION__, $args);
    }
}
