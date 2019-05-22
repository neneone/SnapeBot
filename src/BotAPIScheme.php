<?php

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
