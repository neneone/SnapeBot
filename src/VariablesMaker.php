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

trait VariablesMaker
{
    public function makeVariables()
    {
        if (isset($this->update['message'])) {
            $this->isMessage = true;
            $this->isEdited = false;
            $this->isPost = false;
            $this->setMainMessageData($this->update['message']);
        } elseif (isset($this->update['edited_message'])) {
            $this->isMessage = true;
            $this->isEdited = true;
            $this->isPost = false;
            $this->setMainMessageData($this->update['edited_message']);
        } elseif (isset($this->update['channel_post'])) {
            $this->isMessage = true;
            $this->isEdited = false;
            $this->isPost = true;
            $this->setMainMessageData($this->update['channel_post']);
        } elseif (isset($this->update['edited_channel_post'])) {
            $this->isMessage = true;
            $this->isEdited = true;
            $this->isPost = true;
            $this->setMainMessageData($this->update['edited_channel_post']);
        } elseif (isset($this->update['inline_query'])) {
            $this->isInlineQuery = true;
            $this->setMainInlineQueryData($this->update['inline_query']);
        } elseif (isset($this->update['chosen_inline_result'])) {
            $this->isChosenInlineResult = true;
            $this->setMainChosenInlineResultData($this->update['chosen_inline_result']);
        } elseif (isset($this->update['callback_query'])) {
            $this->isCallbackQuery = true;
            $this->setMainCallbackQueryData($this->update['callback_query']);
        } elseif (isset($this->update['shipping_query'])) {
            $this->isShippingQuery = true;
            $this->setMainShippingQueryData($this->update['shipping_query']);
        } elseif (isset($this->update['pre_checkout_query'])) {
            $this->isPreCheckoutQuery = true;
            $this->setMainPreCheckoutQueryData($this->update['pre_checkout_query']);
        }
    }

    private function setMainMessageData($message)
    {
        foreach ($this->parseMessage($message) as $k => $v) {
            $this->{$k} = $v;
        }
        if (isset($this->from)) {
            foreach ($this->from as $k => $v) {
                $this->{$k} = $v;
            }
        }
        if (isset($this->chat)) {
            foreach ($this->chat as $k => $v) {
                $this->{$k} = $v;
            }
        }
    }

    private function setMainInlineQueryData($inlineQuery)
    {
        foreach ($this->parseInlineQuery($inlineQuery) as $k => $v) {
            $this->{$k} = $v;
        }
        if (isset($this->from)) {
            foreach ($this->from as $k => $v) {
                $this->{$k} = $v;
            }
        }
    }

    private function setMainChosenInlineResultData($chosenResult)
    {
        foreach ($this->parseChosenInlineResult($chosenResult) as $k => $v) {
            $this->{$k} = $v;
        }
        if (isset($this->from)) {
            foreach ($this->from as $k => $v) {
                $this->{$k} = $v;
            }
        }
    }

    private function setMainCallbackQueryData($callbackQuery)
    {
        foreach ($this->parseCallbackQuery($callbackQuery) as $k => $v) {
            $this->{$k} = $v;
        }
        if (isset($this->from)) {
            foreach ($this->from as $k => $v) {
                $this->{$k} = $v;
            }
        }
        if (isset($this->cbMsg['chat'])) {
            foreach ($this->cbMsg['chat'] as $k => $v) {
                $this->{$k} = $v;
            }
        }
    }

    private function setMainShippingQueryData($shippingQuery)
    {
        foreach ($this->parseShippingQuery($shippingQuery) as $k => $v) {
            $this->{$k} = $v;
        }
        if (isset($this->from)) {
            foreach ($this->from as $k => $v) {
                $this->{$k} = $v;
            }
        }
    }

    private function setMainPreCheckoutQueryData($preCheckoutQuery)
    {
        foreach ($this->parsePreCheckoutQuery($preCheckoutQuery) as $k => $v) {
            $this->{$k} = $v;
        }
        if (isset($this->from)) {
            foreach ($this->from as $k => $v) {
                $this->{$k} = $v;
            }
        }
    }

    public function parseMessage($message)
    {
        $r['msgID'] = $message['message_id'];
        $r['msgDate'] = $message['date'];
        $r['chat'] = $this->parseChat($message['chat']);
        if (isset($message['from'])) {
            $r['from'] = $this->parseUser($message['from']);
        }
        if (isset($message['forward_from'])) {
            $r['isForward'] = true;
            $r['forwardFrom'] = $this->parseUser($message['forward_from']);
        }
        if (isset($message['forward_from_chat'])) {
            $r['isForward'] = true;
            $r['forwardChat'] = $this->parseChat($message['forward_from_chat']);
            $r['forwardMsgID'] = $message['forward_from_message_id'];
            if (isset($message['forward_from_signature'])) {
                $r['forwardSignature'] = $message['forward_from_signature'];
            }
        }
        if (isset($message['forward_sender_name'])) {
            $r['forwardName'] = htmlspecialchars($message['forward_sender_name']);
        }
        if (isset($message['forward_date'])) {
            $r['forwardDate'] = $message['forward_date'];
        }
        if (isset($message['reply_to_message'])) {
            $r['replyMsg'] = $this->parseMessage($message['reply_to_message']);
        }
        if (isset($message['edit_date'])) {
            $r['editDate'] = $message['edit_date'];
        }
        if (isset($message['media_group_id'])) {
            $r['mediaGroupID'] = $message['media_group_id'];
        }
        if (isset($message['author_signature'])) {
            $r['authorSignature'] = $message['author_signature'];
        }
        if (isset($message['text'])) {
            $r['msg'] = $message['text'];
        }
        if (isset($message['entities'])) {
            $r['msgEntities'] = $message['entities'];
        }
        if (isset($message['caption_entities'])) {
            $r['captionEntities'] = $message['caption_entities'];
        }
        if (isset($message['audio'])) {
            $r['audio'] = $this->parseAudio($message['audio']);
        }
        if (isset($message['document'])) {
            $r['document'] = $this->parseDocument($message['document']);
        }
        if (isset($message['animation'])) {
            $r['animation'] = $this->parseAnimation($message['animation']);
        }
        if (isset($message['game'])) {
            $r['game'] = $this->parseGame($message['game']);
        }
        if (isset($message['photo'])) {
            $r['photo'] = $message['photo'];
        }
        if (isset($message['sticker'])) {
            $r['sticker'] = $this->parseSticker($message['sticker']);
        }
        if (isset($message['video'])) {
            $r['video'] = $this->parseVideo($message['video']);
        }
        if (isset($message['voice'])) {
            $r['voice'] = $this->parseVoice($message['voice']);
        }
        if (isset($message['video_note'])) {
            $r['videoNote'] = $this->parseVideoNote($message['video_note']);
        }
        if (isset($message['contact'])) {
            $r['contact'] = $this->parseContact($message['contact']);
        }
        if (isset($message['location'])) {
            $r['location'] = $message['location'];
        }
        if (isset($message['venue'])) {
            $r['venue'] = $this->parseVenue($message['venue']);
        }
        if (isset($message['poll'])) {
            $r['poll'] = $this->parsePoll($message['poll']);
        }
        if (isset($message['new_chat_members'])) {
            foreach ($message['new_chat_members'] as $member) {
                $r['newChatMembers'][] = $this->parseUser($member);
            }
        }
        if (isset($message['left_chat_member'])) {
            $r['leftChatMember'] = $message['left_chat_member'];
        }
        if (isset($message['new_chat_title'])) {
            $r['newChatTitle'] = htmlspecialchars($message['new_chat_title']);
        }
        if (isset($message['new_chat_photo'])) {
            $r['newChatPhoto'] = $message['new_chat_photo'];
        }
        if (isset($message['delete_chat_photo'])) {
            $r['deleteChatPhoto'] = true;
        }
        if (isset($message['group_chat_created'])) {
            $r['groupCreated'] = true;
        }
        if (isset($message['supergroup_chat_created'])) {
            $r['supergroupCreated'] = true;
        }
        if (isset($message['channel_chat_created'])) {
            $r['channelCreated'] = true;
        }
        if (isset($message['migrate_to_chat_id'])) {
            $r['newChatID'] = $message['migrate_to_chat_id'];
        }
        if (isset($message['migrate_from_chat_id'])) {
            $r['oldChatID'] = $message['migrate_from_chat_id'];
        }
        if (isset($message['pinned_message'])) {
            $r['pinnedMessage'] = $this->parseMessage($message['pinned_message']);
        }
        if (isset($message['invoice'])) {
            $r['invoice'] = $this->parseInvoice($message['invoice']);
        }
        if (isset($message['successful_payment'])) {
            $r['successfulPayment'] = $this->parseSuccessfulPayment($message['successful_payment']);
        }
        if (isset($message['connected_website'])) {
            $r['connectedWebsite'] = $message['connected_website'];
        }
        if (isset($message['passport_data'])) {
            $r['passportData'] = $this->parsePassport($message['passport_data']);
        }
        if (isset($message['reply_markup'])) {
            $r['replyMarkup'] = $message['reply_markup'];
        }
        if (isset($message['caption'])) {
            $r['caption'] = $message['caption'];
        }

        return $r;
    }

    public function parseInlineQuery($inlineQuery)
    {
        $r['queryID'] = $inlineQuery['id'];
        $r['from'] = $this->parseUser($inlineQuery['from']);
        $r['query'] = $inlineQuery['query'];
        $r['offset'] = $inlineQuery['offset'];
        if (isset($inlineQuery['location'])) {
            $r['location'] = $inlineQuery['location'];
        }

        return $r;
    }

    public function parseChosenInlineResult($chosenResult)
    {
        $r['resultID'] = $chosenResult['result_id'];
        $r['from'] = $this->parseUser($chosenResult['from']);
        $r['query'] = $chosenResult['query'];
        if (isset($chosenResult['location'])) {
            $r['location'] = $chosenResult['location'];
        }
        if (isset($chosenResult['inline_message_id'])) {
            $r['msgID'] = $chosenResult['inline_message_id'];
        }

        return $r;
    }

    public function parseCallbackQuery($callbackQuery)
    {
        $r['cbID'] = $callbackQuery['id'];
        $r['chatInstance'] = $callbackQuery['chat_instance'];
        $r['from'] = $this->parseUser($callbackQuery['from']);
        if (isset($callbackQuery['message'])) {
            $r['cbMsg'] = $this->parseMessage($callbackQuery['message']);
        }
        if (isset($callbackQuery['inline_message_id'])) {
            $r['inlineMsgID'] = $callbackQuery['inline_message_id'];
        }
        if (isset($callbackQuery['data'])) {
            if (false == $this->settings['cbDataEncryption']) {
                $r['data'] = $callbackQuery['data'];
            } else {
                $r['data'] = $this->specialDecrypt($callbackQuery['data']);
            }
        }
        if (isset($callbackQuery['game_short_name'])) {
            $r['gameName'] = $callbackQuery['game_short_name'];
        }

        return $r;
    }

    public function parseShippingQuery($shippingQuery)
    {
        $r['queryID'] = $shippingQuery['id'];
        $r['from'] = $this->parseUser($shippingQuery['from']);
        $r['invoicePayload'] = $shippingQuery['invoice_payload'];
        $r['shippingAddress'] = $this->parseShippingAddress($shippingQuery['shipping_address']);

        return $r;
    }

    public function parsePreCheckoutQuery($preCheckoutQuery)
    {
        $r['queryID'] = $preCheckoutQuery['id'];
        $r['from'] = $this->parseUser($preCheckoutQuery['from']);
        $r['currency'] = $preCheckoutQuery['currency'];
        $r['totalAmount'] = $preCheckoutQuery['total_amount'];
        $r['invoicePayload'] = $preCheckoutQuery['invoice_payload'];
        if (isset($preCheckoutQuery['shipping_option_id'])) {
            $r['shippingOptionID'] = $preCheckoutQuery['shipping_option_id'];
        }
        if (isset($preCheckoutQuery['order_info'])) {
            $r['orderInfo'] = $this->parseOrderInfo($preCheckoutQuery['order_info']);
        }

        return $r;
    }

    public function parseChat($chat)
    {
        $r['chatID'] = $chat['id'];
        $r['chatType'] = $chat['type'];
        if (isset($chat['title'])) {
            $r['chatTitle'] = htmlspecialchars($chat['title']);
        }
        if (isset($chat['username'])) {
            $r['chatUsername'] = $chat['username'];
        } else {
            $r['chatUsername'] = '';
        }
        if (isset($chat['all_members_are_administrators'])) {
            $r['chatAllMembersAreAdministrators'] = $chat['all_members_are_administrators'];
        }
        if (isset($chat['photo'])) {
            $r['chatPhoto'] = $this->parseChatPhoto($chat['photo']);
        }
        if (isset($chat['description'])) {
            $r['chatDescription'] = $chat['description'];
        }
        if (isset($chat['invite_link'])) {
            $r['chatInviteLink'] = $chat['invite_link'];
        }
        if (isset($chat['pinned_message'])) {
            $r['chatPinnedMsg'] = $this->parseMessage($chat['pinned_message']);
        }
        if (isset($chat['sticker_set_name'])) {
            $r['chatStickerSetName'] = $chat['sticker_set_name'];
        }
        if (isset($chat['can_set_sticker_set'])) {
            $r['chatCanSetStickerSet'] = $chat['can_set_sticker_set'];
        }

        return $r;
    }

    public function parseUser($user)
    {
        $r['userID'] = $user['id'];
        $r['isBot'] = $user['is_bot'];
        $r['firstName'] = htmlspecialchars($user['first_name']);
        if (isset($user['last_name'])) {
            $r['lastName'] = htmlspecialchars($user['last_name']);
        }
        if (isset($user['username'])) {
            $r['username'] = $user['username'];
        } else {
            $r['username'] = '';
        }
        if (isset($user['language_code'])) {
            $r['languageCode'] = $user['language_code'];
        }
        if (isset($r['lastName'])) {
            $r['fullName'] = $r['firstName'].' '.$r['lastName'];
        } else {
            $r['fullName'] = $r['firstName'];
        }

        return $r;
    }

    public function parseAudio($audio)
    {
        $r['fileID'] = $audio['file_id'];
        $r['duration'] = $audio['duration'];
        if (isset($audio['performer'])) {
            $r['performer'] = $audio['performer'];
        }
        if (isset($audio['title'])) {
            $r['title'] = $audio['title'];
        }
        if (isset($audio['mime_type'])) {
            $r['mimeType'] = $audio['mime_type'];
        }
        if (isset($audio['file_size'])) {
            $r['fileSize'] = $audio['file_size'];
        }
        if (isset($audio['thumb'])) {
            $r['thumb'] = $audio['thumb'];
        }

        return $r;
    }

    public function parseDocument($document)
    {
        $r['fileID'] = $document['file_id'];
        if (isset($document['mime_type'])) {
            $r['mimeType'] = $document['mime_type'];
        }
        if (isset($document['file_size'])) {
            $r['fileSize'] = $document['file_size'];
        }
        if (isset($document['thumb'])) {
            $r['thumb'] = $document['thumb'];
        }
        if (isset($document['file_name'])) {
            $r['fileName'] = $document['file_name'];
        }

        return $r;
    }

    public function parseAnimation($animation)
    {
        $r['fileID'] = $animation['file_id'];
        $r['width'] = $animation['width'];
        $r['height'] = $animation['height'];
        $r['duration'] = $animation['duration'];
        if (isset($animation['mime_type'])) {
            $r['mimeType'] = $animation['mime_type'];
        }
        if (isset($animation['file_size'])) {
            $r['fileSize'] = $animation['file_size'];
        }
        if (isset($animation['thumb'])) {
            $r['thumb'] = $animation['thumb'];
        }
        if (isset($animation['file_name'])) {
            $r['fileName'] = $animation['file_name'];
        }

        return $r;
    }

    public function parseGame($game)
    {
        $r['title'] = $game['title'];
        $r['description'] = $game['description'];
        $r['photo'] = $game['photo'];
        if (isset($game['text'])) {
            $r['text'] = $game['text'];
        }
        if (isset($game['text_entities'])) {
            $r['textEntities'] = $game['text_entities'];
        }
        if (isset($game['animation'])) {
            $r['animation'] = $this->parseAnimation($game['animation']);
        }

        return $r;
    }

    public function parseSticker($sticker)
    {
        $r['fileID'] = $sticker['file_id'];
        $r['width'] = $sticker['width'];
        $r['height'] = $sticker['height'];
        if (isset($sticker['file_size'])) {
            $r['fileSize'] = $sticker['file_size'];
        }
        if (isset($sticker['thumb'])) {
            $r['thumb'] = $sticker['thumb'];
        }
        if (isset($sticker['emoji'])) {
            $r['emoji'] = $sticker['emoji'];
        }
        if (isset($sticker['set_name'])) {
            $r['setName'] = $sticker['set_name'];
        }
        if (isset($sticker['mask_position'])) {
            $r['maskPosition'] = $sticker['mask_position'];
        }

        return $r;
    }

    public function parseVideo($video)
    {
        $r['fileID'] = $video['file_id'];
        $r['width'] = $video['width'];
        $r['height'] = $video['height'];
        $r['duration'] = $video['duration'];
        if (isset($video['mime_type'])) {
            $r['mimeType'] = $video['mime_type'];
        }
        if (isset($video['file_size'])) {
            $r['fileSize'] = $video['file_size'];
        }
        if (isset($video['thumb'])) {
            $r['thumb'] = $video['thumb'];
        }

        return $r;
    }

    public function parseVoice($voice)
    {
        $r['fileID'] = $voice['file_id'];
        $r['duration'] = $voice['duration'];
        if (isset($voice['mime_type'])) {
            $r['mimeType'] = $voice['mime_type'];
        }
        if (isset($voice['file_size'])) {
            $r['fileSize'] = $voice['file_size'];
        }

        return $r;
    }

    public function parseVideoNote($videoNote)
    {
        $r['fileID'] = $videoNote['file_id'];
        $r['length'] = $videoNote['length'];
        $r['duration'] = $videoNote['duration'];
        if (isset($videoNote['file_size'])) {
            $r['fileSize'] = $videoNote['file_size'];
        }
        if (isset($videoNote['thumb'])) {
            $r['thumb'] = $videoNote['thumb'];
        }

        return $r;
    }

    public function parseContact($contact)
    {
        $r['phoneNumber'] = $contact['phone_number'];
        $r['firstName'] = htmlspecialchars($contact['first_name']);
        if (isset($contact['last_name'])) {
            $r['lastName'] = htmlspecialchars($contact['last_name']);
        }
        if (isset($contact['user_id'])) {
            $r['userID'] = $contact['user_id'];
        }
        if (isset($contact['vcard'])) {
            $r['vCard'] = $contact['vcard'];
        }

        return $r;
    }

    public function parseVenue($venue)
    {
        $r['location'] = $venue['location'];
        $r['title'] = $venue['title'];
        $r['address'] = $venue['address'];
        if (isset($venue['foursquare_id'])) {
            $r['foursquareID'] = $venue['foursquare_id'];
        }
        if (isset($venue['foursquare_type'])) {
            $r['foursquareType'] = $venue['foursquare_type'];
        }

        return $r;
    }

    public function parsePoll($poll)
    {
        $r['pollID'] = $poll['id'];
        $r['question'] = $poll['question'];
        $r['options'] = $poll['options'];
        $r['isClosed'] = $poll['is_closed'];

        return $r;
    }

    public function parseInvoice($invoice)
    {
        $r['title'] = $invoice['title'];
        $r['description'] = $invoice['description'];
        $r['startParameter'] = $invoice['start_parameter'];
        $r['currency'] = $invoice['currency'];
        $r['totalAmount'] = $invoice['total_amount'];

        return $r;
    }

    public function parseSuccessfulPayment($successfulPayment)
    {
        $r['currency'] = $successfulPayment['currency'];
        $r['totalAmount'] = $successfulPayment['total_amount'];
        $r['invoicePayload'] = $successfulPayment['invoice_payload'];
        if (isset($successfulPayment['shipping_option_id'])) {
            $r['shippingOptionID'] = $successfulPayment['shipping_option_id'];
        }
        if (isset($successfulPayment['order_info'])) {
            $r['orderInfo'] = $this->parseOrderInfo($successfulPayment['order_info']);
        }
        $r['telegramPaymentID'] = $successfulPayment['telegram_payment_charge_id'];
        $r['providerPaymentID'] = $successfulPayment['provider_payment_charge_id'];

        return $r;
    }

    public function parsePassportData($passportData)
    {
        $r['data'] = $passportData['data'];
        $r['credentials'] = $passportData['credentials'];

        return $r;
    }

    public function parseShippingAddress($shippingAddress)
    {
        $r['countryCode'] = $shippingAddress['country_code'];
        $r['state'] = $shippingAddress['state'];
        $r['city'] = $shippingAddress['city'];
        $r['streetLine1'] = $shippingAddress['street_line1'];
        $r['streetLine2'] = $shippingAddress['street_line2'];
        $r['postCode'] = $shippingAddress['post_code'];

        return $r;
    }

    public function parseOrderInfo($orderInfo)
    {
        if (isset($orderInfo['name'])) {
            $r['name'] = $orderInfo['name'];
        }
        if (isset($orderInfo['phone_number'])) {
            $r['phoneNumber'] = $orderInfo['phone_number'];
        }
        if (isset($orderInfo['email'])) {
            $r['email'] = $orderInfo['email'];
        }
        if (isset($orderInfo['shipping_address'])) {
            $r['shippingAddress'] = $this->parseShippingAddress($orderInfo['shipping_address']);
        }

        return $r;
    }

    public function parseChatPhoto($chatPhoto)
    {
        $r['smallID'] = $chatPhoto['small_file_id'];
        $r['bigID'] = $chatPhoto['big_file_id'];

        return $r;
    }
}
