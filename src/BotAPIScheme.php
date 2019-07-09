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

interface BotAPIScheme
{
    public function getUpdates($args);

    public function setWebhook($args);

    public function deleteWebhook();

    public function getWebhookInfo();

    public function getMe();

    public function sendMessage($args);

    public function forwardMessage($args);

    public function sendPhoto($args);

    public function sendAudio($args);

    public function sendDocument($args);

    public function sendVideo($args);

    public function sendAnimation($args);

    public function sendVoice($args);

    public function sendVideoNote($args);

    public function sendMediaGroup($args);

    public function sendLocation($args);

    public function editMessageLiveLocation($args);

    public function stopMessageLiveLocation($args);

    public function sendVenue($args);

    public function sendContact($args);

    public function sendPoll($args);

    public function sendChatAction($args);

    public function getUserProfilePhotos($args);

    public function getFile($args);

    public function kickChatMember($args);

    public function unbanChatMember($args);

    public function restrictChatMember($args);

    public function promoteChatMember($args);

    public function exportChatInviteLink($args);

    public function setChatPhoto($args);

    public function deleteChatPhoto($args);

    public function setChatTitle($args);

    public function setChatDescription($args);

    public function pinChatMessage($args);

    public function unpinChatMessage($args);

    public function leaveChat($args);

    public function getChat($args);

    public function getChatAdministrators($args);

    public function getChatMembersCount($args);

    public function getChatMember($args);

    public function setChatStickerSet($args);

    public function deleteChatStickerSet($args);

    public function answerCallbackQuery($args);

    public function editMessageText($args);

    public function editMessageCaption($args);

    public function editMessageMedia($args);

    public function editMessageReplyMarkup($args);

    public function stopPoll($args);

    public function deleteMessage($args);

    public function sendSticker($args);

    public function getStickerSet($args);

    public function uploadStickerFile($args);

    public function createNewStickerSet($args);

    public function addStickerToSet($args);

    public function setStickerPositionInSet($args);

    public function deleteStickerFromSet($args);

    public function answerInlineQuery($args);

    public function sendInvoice($args);

    public function answerShippingQuery($args);

    public function answerPreCheckoutQuery($args);

    public function setPassportDataErrors($args);

    public function sendGame($args);

    public function setGameScore($args);

    public function getGameHighScores($args);
}
