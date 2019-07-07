<?php

namespace neneone\SnapeBot;

class VariablesMaker {
  public function __construct($update) {
    $this->updateID = $update['id'];
    if(isset($update['message'])) {
      $this->isMsg = true;
      $this->msgID = $update['message']['id'];
      $this->date = $update['message']['date'];
      if(isset($update['message']['from'])) {
        $this->from = $update['message']['from'];
        $this->userID = $this->from['id'];
        $this->isBot = $this->from['is_bot'];
        $this->firstName = $this->from['first_name'];
        if(isset($this->from['last_name'])) {
          $this->lastName = $this->from['last_name'];
          $this->fullName = $this->firstName . ' ' . $this->lastName;
        } else {
          $this->fullName = $this->firstName;
        }
        if(isset($this->from['username'])) $this->username = $this->from['username'];
        if(isset($this->from['language_code'])) $this->languageCode = $this->from['language_code'];
      }
      $this->chat = $update['message']['chat'];
      $this->chatID = $this->chat['id'];
      $this->chatType = $this->chat['type'];
      $this->chatTitle = $this->chat['title'];
      if(isset($this->chat['username'])) $this->chatUsername = $this->chat['username'];
      if(isset($this->chat['all_members_are_administrators'])) $this->chatAllAdmins = $this->chat['all_members_are_administrators'];
      if(isset($update['message']['forward_from'])) {
        $this->forwardFrom = $update['message']['forward_from'];
        $this->forwardFromID = $this->forwardFrom['id'];
        $this->forwardFromIsBot = $this->forwardFrom['is_bot'];
        $this->forwardFromFirstName = $this->forwardFrom['first_name'];
        if(isset($this->forwardFrom['last_name'])) {
          $this->forwardFromLastName = $this->forwardFrom['last_name'];
          $this->forwardFromFullName = $this->firstName . ' ' . $this->lastName;
        } else {
          $this->forwardFromFullName = $this->firstName;
        }
        if(isset($this->forwardFrom['username'])) $this->forwardFromUsername = $this->forwardFrom['username'];
        if(isset($this->forwardFrom['language_code'])) $this->forwardFromLanguageCode = $this->forwardFrom['language_code'];
      } elseif(isset($update['message']['forward_from_chat'])) {
        $this->forwardFrom = $update['message']['forward_from_chat'];
        $this->forwardFromID = $this->forwardFrom['id'];
        $this->forwardChatType = $this->forwardFrom['type'];
        $this->forwardChatTitle = $this->forwardFrom['title'];
        if(isset($this->forwardFrom['username'])) $this->forwardChatUsername = $this->forwardFrom['username'];
        if(isset($this->forwardFrom['all_members_are_administrators'])) $this->forwardChatAllAdmins = $this->forwardFrom['all_members_are_administrators'];
      }
      if(isset($update['message']['forward_from_message_id'])) $this->forwardFromMsgID = $update['message']['forward_from_message_id'];
      if(isset($update['message']['forward_signature'])) $this->forwardSignature = $update['message']['forward_signature'];
      if(isset($update['message']['forward_sender_name'])) $this->forwardSenderName = $update['message']['forward_sender_name'];
      if(isset($update['message']['forward_date'])) $this->forwardDate = $update['message']['forward_date'];
      if(isset($update['message']['reply_to_message'])) $this->replyMsg = $update['message']['reply_to_message'];
      if(isset($update['message']['edit_date'])) $this->editDate = $update['message']['edit_date'];
      if(isset($update['message']['media_group_id'])) $this->mediaGroupID = $update['message']['media_group_id'];
      if(isset($update['message']['author_signature'])) $this->authorSignature = $update['message']['author_signature'];
      if(isset($update['message']['entities'])) $this->msgEntities = $update['message']['entities'];
      if(isset($update['message']['caption_entities'])) $this->captionEntities = $update['message']['caption_entities'];
      if(isset($update['message']['text'])) {
        $this->isText = true;
        $this->msg = $update['message']['text'];
      } elseif(isset($update['message']['audio'])) {
        $this->isAudio = true;
        $this->audio = $update['message']['audio'];
        $this->fileID = $this->audio['file_id'];
        $this->audioDuration = $this->audio['duration'];
        if(isset($this->audio['performer'])) $this->audioPerformer = $this->audio['performer'];
        if(isset($this->audio['title'])) $this->audioTitle = $this->audio['title'];
        if(isset($this->audio['mime_type'])) $this->audioMimeType = $this->audio['mime_type'];
        if(isset($this->audio['file_size'])) $this->fileSize = $this->audio['file_size'];
        if(isset($this->audio['thumb'])) {
          $this->audioThumb = $this->audio['thumb'];
          $this->audioThumbFileID = $this->audioThumb['file_id'];
          $this->audioThumbWidth = $this->audioThumb['width'];
          $this->audioThumbHeight = $this->audioThumb['height'];
          if(isset($this->audioThumb['file_size'])) $this->audioThumbFileSize = $this->audioThumb['file_size'];
        }
      } elseif(isset($update['message']['document'])) {
        $this->isDocument = true;
        $this->document = $update['message']['document'];
        $this->fileID = $this->document['file_id'];
        if(isset($this->document['thumb'])) $this->fileThumb = $this->document['thumb'];
        if(isset($this->document['file_name'])) $this->fileName = $this->document['file_name'];
        if(isset($this->document['mime_type'])) $this->fileMimeType = $this->document['mime_type'];
        if(isset($this->document['file_size'])) $this->fileSize = $this->document['file_size'];
        if(isset($update['message']['animation'])) {
          $this->isAnimation = true;
          $this->animation = $update['message']['animation'];
          $this->videoWidth = $this->animation['width'];
          $this->videoHeight = $this->animation['height'];
          $this->videoDuration = $this->animation['duration'];
          if(isset($this->animation['thumb'])) {
            $this->videoThumb = $this->animation['thumb'];
            $this->videoThumbFileID = $this->videoThumb['file_id'];
            $this->videoThumbWidth = $this->videoThumb['width'];
            $this->videoThumbHeight = $this->videoThumb['height'];
            if(isset($this->videoThumb['file_size'])) $this->videoThumbFileSize = $this->videoThumb['file_size'];
          }
        }
      } elseif(isset($update['message']['game'])) {
        $isGame = true;
        $this->game = $update['message']['game'];
        $this->gameTitle = $this->game['title'];
        $this->gameDescription = $this->game['description'];
        $this->gamePhoto = $this->game['photo'];
        if(isset($this->game['text'])) $this->gameText = $this->game['text'];
        if(isset($this->game['text_entities'])) $this->gameTextEntities = $this->game['text_entities'];
        if(isset($this->game['animation'])) $this->gameAnimation = $this->game['animation'];
        $this->gameAnimation = $this->game['animation'];
        $this->gameVideoWidth = $this->gameAnimation['width'];
        $this->gameVideoHeight = $this->gameAnimation['height'];
        $this->gameVideoDuration = $this->gameAnimation['duration'];
        if(isset($this->gameAnimation['thumb'])) {
          $this->gameVideoThumb = $this->gameAnimation['thumb'];
          $this->gameVideoThumbFileID = $this->gameVideoThumb['file_id'];
          $this->gameVideoThumbWidth = $this->gameVideoThumb['width'];
          $this->gameVideoThumbHeight = $this->gameVideoThumb['height'];
          if(isset($this->gameVideoThumb['file_size'])) $this->gameVideoThumbFileSize = $this->gameVideoThumb['file_size'];
        }
      } elseif(isset($update['message']['photo'])) {
        $isPhoto = true;
        $this->photo = $update['message']['photo'];
      } elseif(isset($update['message']['sticker'])) {
        $isSticker = true;
        $this->sticker = $update['message']['sticker'];
        $this->fileID = $this->sticker['file_id'];
        $this->stickerWidth = $this->sticker['width'];
        $this->stickerHeight = $this->sticker['height'];
        if(isset($this->sticker['thumb'])) $this->stickerThumb = $this->sticker['thumb'];
        if(isset($this->sticker['emoji'])) $this->stickerEmoji = $this->sticker['emoji'];
        if(isset($this->sticker['mask_position'])) $this->stickerMaskPosition = $this->sticker['mask_position'];
        if(isset($this->sticker['file_size'])) $this->fileSize = $this->sticker['file_size'];
      } elseif(isset($update['message']['video'])) {
        $this->isVideo = true;
        $this->video = $update['message']['video'];
        $this->fileID = $this->video['file_id'];
        $this->videoWidth = $this->video['width'];
        $this->videoHeight = $this->video['height'];
        $this->videoDuration = $this->video['duration'];
        if(isset($this->video['thumb'])) {
          $this->videoThumb = $this->video['thumb'];
          $this->videoThumbFileID = $this->videoThumb['file_id'];
          $this->videoThumbWidth = $this->videoThumb['width'];
          $this->videoThumbHeight = $this->videoThumb['height'];
          if(isset($this->videoThumb['file_size'])) $this->videoThumbFileSize = $this->videoThumb['file_size'];
        }
        if(isset($this->video['mime_type'])) $this->videoMymeType = $this->video['mime_type'];
        if(isset($this->video['file_size'])) $this->fileSize = $this->video['file_size'];
      }
    } elseif(isset($update['edited_message'])) {
      $this->isEdited = true;
      $this->isMsg = true;
      $this->msgID = $update['edited_message']['id'];
      $this->date = $update['edited_message']['date'];
      if(isset($update['edited_message']['from'])) {
        $this->from = $update['edited_message']['from'];
        $this->userID = $this->from['id'];
        $this->isBot = $this->from['is_bot'];
        $this->firstName = $this->from['first_name'];
        if(isset($this->from['last_name'])) {
          $this->lastName = $this->from['last_name'];
          $this->fullName = $this->firstName . ' ' . $this->lastName;
        } else {
          $this->fullName = $this->firstName;
        }
        if(isset($this->from['username'])) $this->username = $this->from['username'];
        if(isset($this->from['language_code'])) $this->languageCode = $this->from['language_code'];
      }
      $this->chat = $update['edited_message']['chat'];
      $this->chatID = $this->chat['id'];
      $this->chatType = $this->chat['type'];
      $this->chatTitle = $this->chat['title'];
      if(isset($this->chat['username'])) $this->chatUsername = $this->chat['username'];
      if(isset($this->chat['all_members_are_administrators'])) $this->chatAllAdmins = $this->chat['all_members_are_administrators'];
      if(isset($update['edited_message']['forward_from'])) {
        $this->forwardFrom = $update['edited_message']['forward_from'];
        $this->forwardFromID = $this->forwardFrom['id'];
        $this->forwardFromIsBot = $this->forwardFrom['is_bot'];
        $this->forwardFromFirstName = $this->forwardFrom['first_name'];
        if(isset($this->forwardFrom['last_name'])) {
          $this->forwardFromLastName = $this->forwardFrom['last_name'];
          $this->forwardFromFullName = $this->firstName . ' ' . $this->lastName;
        } else {
          $this->forwardFromFullName = $this->firstName;
        }
        if(isset($this->forwardFrom['username'])) $this->forwardFromUsername = $this->forwardFrom['username'];
        if(isset($this->forwardFrom['language_code'])) $this->forwardFromLanguageCode = $this->forwardFrom['language_code'];
      } elseif(isset($update['edited_message']['forward_from_chat'])) {
        $this->forwardFrom = $update['edited_message']['forward_from_chat'];
        $this->forwardFromID = $this->forwardFrom['id'];
        $this->forwardChatType = $this->forwardFrom['type'];
        $this->forwardChatTitle = $this->forwardFrom['title'];
        if(isset($this->forwardFrom['username'])) $this->forwardChatUsername = $this->forwardFrom['username'];
        if(isset($this->forwardFrom['all_members_are_administrators'])) $this->forwardChatAllAdmins = $this->forwardFrom['all_members_are_administrators'];
      }
      if(isset($update['edited_message']['forward_from_message_id'])) $this->forwardFromMsgID = $update['edited_message']['forward_from_message_id'];
      if(isset($update['edited_message']['forward_signature'])) $this->forwardSignature = $update['edited_message']['forward_signature'];
      if(isset($update['edited_message']['forward_sender_name'])) $this->forwardSenderName = $update['edited_message']['forward_sender_name'];
      if(isset($update['edited_message']['forward_date'])) $this->forwardDate = $update['edited_message']['forward_date'];
      if(isset($update['edited_message']['reply_to_message'])) $this->replyMsg = $update['edited_message']['reply_to_message'];
      if(isset($update['edited_message']['edit_date'])) $this->editDate = $update['edited_message']['edit_date'];
      if(isset($update['edited_message']['media_group_id'])) $this->mediaGroupID = $update['edited_message']['media_group_id'];
      if(isset($update['edited_message']['author_signature'])) $this->authorSignature = $update['edited_message']['author_signature'];
      if(isset($update['edited_message']['entities'])) $this->msgEntities = $update['edited_message']['entities'];
      if(isset($update['edited_message']['caption_entities'])) $this->captionEntities = $update['edited_message']['caption_entities'];
      if(isset($update['edited_message']['text'])) {
        $this->isText = true;
        $this->msg = $update['edited_message']['text'];
      } elseif(isset($update['edited_message']['audio'])) {
        $this->isAudio = true;
        $this->audio = $update['edited_message']['audio'];
        $this->fileID = $this->audio['file_id'];
        $this->audioDuration = $this->audio['duration'];
        if(isset($this->audio['performer'])) $this->audioPerformer = $this->audio['performer'];
        if(isset($this->audio['title'])) $this->audioTitle = $this->audio['title'];
        if(isset($this->audio['mime_type'])) $this->audioMimeType = $this->audio['mime_type'];
        if(isset($this->audio['file_size'])) $this->fileSize = $this->audio['file_size'];
        if(isset($this->audio['thumb'])) {
          $this->audioThumb = $this->audio['thumb'];
          $this->audioThumbFileID = $this->audioThumb['file_id'];
          $this->audioThumbWidth = $this->audioThumb['width'];
          $this->audioThumbHeight = $this->audioThumb['height'];
          if(isset($this->audioThumb['file_size'])) $this->audioThumbFileSize = $this->audioThumb['file_size'];
        }
      } elseif(isset($update['edited_message']['document'])) {
        $this->isDocument = true;
        $this->document = $update['edited_message']['document'];
        $this->fileID = $this->document['file_id'];
        if(isset($this->document['thumb'])) $this->fileThumb = $this->document['thumb'];
        if(isset($this->document['file_name'])) $this->fileName = $this->document['file_name'];
        if(isset($this->document['mime_type'])) $this->fileMimeType = $this->document['mime_type'];
        if(isset($this->document['file_size'])) $this->fileSize = $this->document['file_size'];
        if(isset($update['edited_message']['animation'])) {
          $this->isAnimation = true;
          $this->animation = $update['edited_message']['animation'];
          $this->videoWidth = $this->animation['width'];
          $this->videoHeight = $this->animation['height'];
          $this->videoDuration = $this->animation['duration'];
          if(isset($this->animation['thumb'])) {
            $this->videoThumb = $this->animation['thumb'];
            $this->videoThumbFileID = $this->videoThumb['file_id'];
            $this->videoThumbWidth = $this->videoThumb['width'];
            $this->videoThumbHeight = $this->videoThumb['height'];
            if(isset($this->videoThumb['file_size'])) $this->videoThumbFileSize = $this->videoThumb['file_size'];
          }
        }
      } elseif(isset($update['edited_message']['game'])) {
        $isGame = true;
        $this->game = $update['edited_message']['game'];
        $this->gameTitle = $this->game['title'];
        $this->gameDescription = $this->game['description'];
        $this->gamePhoto = $this->game['photo'];
        if(isset($this->game['text'])) $this->gameText = $this->game['text'];
        if(isset($this->game['text_entities'])) $this->gameTextEntities = $this->game['text_entities'];
        if(isset($this->game['animation'])) $this->gameAnimation = $this->game['animation'];
        $this->gameAnimation = $this->game['animation'];
        $this->gameVideoWidth = $this->gameAnimation['width'];
        $this->gameVideoHeight = $this->gameAnimation['height'];
        $this->gameVideoDuration = $this->gameAnimation['duration'];
        if(isset($this->gameAnimation['thumb'])) {
          $this->gameVideoThumb = $this->gameAnimation['thumb'];
          $this->gameVideoThumbFileID = $this->gameVideoThumb['file_id'];
          $this->gameVideoThumbWidth = $this->gameVideoThumb['width'];
          $this->gameVideoThumbHeight = $this->gameVideoThumb['height'];
          if(isset($this->gameVideoThumb['file_size'])) $this->gameVideoThumbFileSize = $this->gameVideoThumb['file_size'];
        }
      } elseif(isset($update['edited_message']['photo'])) {
        $isPhoto = true;
        $this->photo = $update['edited_message']['photo'];
      } elseif(isset($update['edited_message']['sticker'])) {
        $isSticker = true;
        $this->sticker = $update['edited_message']['sticker'];
        $this->fileID = $this->sticker['file_id'];
        $this->stickerWidth = $this->sticker['width'];
        $this->stickerHeight = $this->sticker['height'];
        if(isset($this->sticker['thumb'])) $this->stickerThumb = $this->sticker['thumb'];
        if(isset($this->sticker['emoji'])) $this->stickerEmoji = $this->sticker['emoji'];
        if(isset($this->sticker['mask_position'])) $this->stickerMaskPosition = $this->sticker['mask_position'];
        if(isset($this->sticker['file_size'])) $this->fileSize = $this->sticker['file_size'];
      } elseif(isset($update['edited_message']['video'])) {
        $this->isVideo = true;
        $this->video = $update['edited_message']['video'];
        $this->fileID = $this->video['file_id'];
        $this->videoWidth = $this->video['width'];
        $this->videoHeight = $this->video['height'];
        $this->videoDuration = $this->video['duration'];
        if(isset($this->video['thumb'])) {
          $this->videoThumb = $this->video['thumb'];
          $this->videoThumbFileID = $this->videoThumb['file_id'];
          $this->videoThumbWidth = $this->videoThumb['width'];
          $this->videoThumbHeight = $this->videoThumb['height'];
          if(isset($this->videoThumb['file_size'])) $this->videoThumbFileSize = $this->videoThumb['file_size'];
        }
        if(isset($this->video['mime_type'])) $this->videoMymeType = $this->video['mime_type'];
        if(isset($this->video['file_size'])) $this->fileSize = $this->video['file_size'];
      }
    } elseif(isset($update['channel_post'])) {
      $this->isPost = true;
      $this->isMsg = true;
      $this->msgID = $update['channel_post']['id'];
      $this->date = $update['channel_post']['date'];
      if(isset($update['channel_post']['from'])) {
        $this->from = $update['channel_post']['from'];
        $this->userID = $this->from['id'];
        $this->isBot = $this->from['is_bot'];
        $this->firstName = $this->from['first_name'];
        if(isset($this->from['last_name'])) {
          $this->lastName = $this->from['last_name'];
          $this->fullName = $this->firstName . ' ' . $this->lastName;
        } else {
          $this->fullName = $this->firstName;
        }
        if(isset($this->from['username'])) $this->username = $this->from['username'];
        if(isset($this->from['language_code'])) $this->languageCode = $this->from['language_code'];
      }
      $this->chat = $update['channel_post']['chat'];
      $this->chatID = $this->chat['id'];
      $this->chatType = $this->chat['type'];
      $this->chatTitle = $this->chat['title'];
      if(isset($this->chat['username'])) $this->chatUsername = $this->chat['username'];
      if(isset($this->chat['all_members_are_administrators'])) $this->chatAllAdmins = $this->chat['all_members_are_administrators'];
      if(isset($update['channel_post']['forward_from'])) {
        $this->forwardFrom = $update['channel_post']['forward_from'];
        $this->forwardFromID = $this->forwardFrom['id'];
        $this->forwardFromIsBot = $this->forwardFrom['is_bot'];
        $this->forwardFromFirstName = $this->forwardFrom['first_name'];
        if(isset($this->forwardFrom['last_name'])) {
          $this->forwardFromLastName = $this->forwardFrom['last_name'];
          $this->forwardFromFullName = $this->firstName . ' ' . $this->lastName;
        } else {
          $this->forwardFromFullName = $this->firstName;
        }
        if(isset($this->forwardFrom['username'])) $this->forwardFromUsername = $this->forwardFrom['username'];
        if(isset($this->forwardFrom['language_code'])) $this->forwardFromLanguageCode = $this->forwardFrom['language_code'];
      } elseif(isset($update['channel_post']['forward_from_chat'])) {
        $this->forwardFrom = $update['channel_post']['forward_from_chat'];
        $this->forwardFromID = $this->forwardFrom['id'];
        $this->forwardChatType = $this->forwardFrom['type'];
        $this->forwardChatTitle = $this->forwardFrom['title'];
        if(isset($this->forwardFrom['username'])) $this->forwardChatUsername = $this->forwardFrom['username'];
        if(isset($this->forwardFrom['all_members_are_administrators'])) $this->forwardChatAllAdmins = $this->forwardFrom['all_members_are_administrators'];
      }
      if(isset($update['channel_post']['forward_from_message_id'])) $this->forwardFromMsgID = $update['channel_post']['forward_from_message_id'];
      if(isset($update['channel_post']['forward_signature'])) $this->forwardSignature = $update['channel_post']['forward_signature'];
      if(isset($update['channel_post']['forward_sender_name'])) $this->forwardSenderName = $update['channel_post']['forward_sender_name'];
      if(isset($update['channel_post']['forward_date'])) $this->forwardDate = $update['channel_post']['forward_date'];
      if(isset($update['channel_post']['reply_to_message'])) $this->replyMsg = $update['channel_post']['reply_to_message'];
      if(isset($update['channel_post']['edit_date'])) $this->editDate = $update['channel_post']['edit_date'];
      if(isset($update['channel_post']['media_group_id'])) $this->mediaGroupID = $update['channel_post']['media_group_id'];
      if(isset($update['channel_post']['author_signature'])) $this->authorSignature = $update['channel_post']['author_signature'];
      if(isset($update['channel_post']['entities'])) $this->msgEntities = $update['channel_post']['entities'];
      if(isset($update['channel_post']['caption_entities'])) $this->captionEntities = $update['channel_post']['caption_entities'];
      if(isset($update['channel_post']['text'])) {
        $this->isText = true;
        $this->msg = $update['channel_post']['text'];
      } elseif(isset($update['channel_post']['audio'])) {
        $this->isAudio = true;
        $this->audio = $update['channel_post']['audio'];
        $this->fileID = $this->audio['file_id'];
        $this->audioDuration = $this->audio['duration'];
        if(isset($this->audio['performer'])) $this->audioPerformer = $this->audio['performer'];
        if(isset($this->audio['title'])) $this->audioTitle = $this->audio['title'];
        if(isset($this->audio['mime_type'])) $this->audioMimeType = $this->audio['mime_type'];
        if(isset($this->audio['file_size'])) $this->fileSize = $this->audio['file_size'];
        if(isset($this->audio['thumb'])) {
          $this->audioThumb = $this->audio['thumb'];
          $this->audioThumbFileID = $this->audioThumb['file_id'];
          $this->audioThumbWidth = $this->audioThumb['width'];
          $this->audioThumbHeight = $this->audioThumb['height'];
          if(isset($this->audioThumb['file_size'])) $this->audioThumbFileSize = $this->audioThumb['file_size'];
        }
      } elseif(isset($update['channel_post']['document'])) {
        $this->isDocument = true;
        $this->document = $update['channel_post']['document'];
        $this->fileID = $this->document['file_id'];
        if(isset($this->document['thumb'])) $this->fileThumb = $this->document['thumb'];
        if(isset($this->document['file_name'])) $this->fileName = $this->document['file_name'];
        if(isset($this->document['mime_type'])) $this->fileMimeType = $this->document['mime_type'];
        if(isset($this->document['file_size'])) $this->fileSize = $this->document['file_size'];
        if(isset($update['channel_post']['animation'])) {
          $this->isAnimation = true;
          $this->animation = $update['channel_post']['animation'];
          $this->videoWidth = $this->animation['width'];
          $this->videoHeight = $this->animation['height'];
          $this->videoDuration = $this->animation['duration'];
          if(isset($this->animation['thumb'])) {
            $this->videoThumb = $this->animation['thumb'];
            $this->videoThumbFileID = $this->videoThumb['file_id'];
            $this->videoThumbWidth = $this->videoThumb['width'];
            $this->videoThumbHeight = $this->videoThumb['height'];
            if(isset($this->videoThumb['file_size'])) $this->videoThumbFileSize = $this->videoThumb['file_size'];
          }
        }
      } elseif(isset($update['channel_post']['game'])) {
        $isGame = true;
        $this->game = $update['channel_post']['game'];
        $this->gameTitle = $this->game['title'];
        $this->gameDescription = $this->game['description'];
        $this->gamePhoto = $this->game['photo'];
        if(isset($this->game['text'])) $this->gameText = $this->game['text'];
        if(isset($this->game['text_entities'])) $this->gameTextEntities = $this->game['text_entities'];
        if(isset($this->game['animation'])) $this->gameAnimation = $this->game['animation'];
        $this->gameAnimation = $this->game['animation'];
        $this->gameVideoWidth = $this->gameAnimation['width'];
        $this->gameVideoHeight = $this->gameAnimation['height'];
        $this->gameVideoDuration = $this->gameAnimation['duration'];
        if(isset($this->gameAnimation['thumb'])) {
          $this->gameVideoThumb = $this->gameAnimation['thumb'];
          $this->gameVideoThumbFileID = $this->gameVideoThumb['file_id'];
          $this->gameVideoThumbWidth = $this->gameVideoThumb['width'];
          $this->gameVideoThumbHeight = $this->gameVideoThumb['height'];
          if(isset($this->gameVideoThumb['file_size'])) $this->gameVideoThumbFileSize = $this->gameVideoThumb['file_size'];
        }
      } elseif(isset($update['channel_post']['photo'])) {
        $isPhoto = true;
        $this->photo = $update['channel_post']['photo'];
      } elseif(isset($update['channel_post']['sticker'])) {
        $isSticker = true;
        $this->sticker = $update['channel_post']['sticker'];
        $this->fileID = $this->sticker['file_id'];
        $this->stickerWidth = $this->sticker['width'];
        $this->stickerHeight = $this->sticker['height'];
        if(isset($this->sticker['thumb'])) $this->stickerThumb = $this->sticker['thumb'];
        if(isset($this->sticker['emoji'])) $this->stickerEmoji = $this->sticker['emoji'];
        if(isset($this->sticker['mask_position'])) $this->stickerMaskPosition = $this->sticker['mask_position'];
        if(isset($this->sticker['file_size'])) $this->fileSize = $this->sticker['file_size'];
      } elseif(isset($update['channel_post']['video'])) {
        $this->isVideo = true;
        $this->video = $update['channel_post']['video'];
        $this->fileID = $this->video['file_id'];
        $this->videoWidth = $this->video['width'];
        $this->videoHeight = $this->video['height'];
        $this->videoDuration = $this->video['duration'];
        if(isset($this->video['thumb'])) {
          $this->videoThumb = $this->video['thumb'];
          $this->videoThumbFileID = $this->videoThumb['file_id'];
          $this->videoThumbWidth = $this->videoThumb['width'];
          $this->videoThumbHeight = $this->videoThumb['height'];
          if(isset($this->videoThumb['file_size'])) $this->videoThumbFileSize = $this->videoThumb['file_size'];
        }
        if(isset($this->video['mime_type'])) $this->videoMymeType = $this->video['mime_type'];
        if(isset($this->video['file_size'])) $this->fileSize = $this->video['file_size'];
      }
    } elseif(isset($update['edited_channel_post'])) {
      $this->isPost = true;
      $this->isEdited = true;
      $this->isMsg = true;
      $this->msgID = $update['edited_channel_post']['id'];
      $this->date = $update['edited_channel_post']['date'];
      if(isset($update['edited_channel_post']['from'])) {
        $this->from = $update['edited_channel_post']['from'];
        $this->userID = $this->from['id'];
        $this->isBot = $this->from['is_bot'];
        $this->firstName = $this->from['first_name'];
        if(isset($this->from['last_name'])) {
          $this->lastName = $this->from['last_name'];
          $this->fullName = $this->firstName . ' ' . $this->lastName;
        } else {
          $this->fullName = $this->firstName;
        }
        if(isset($this->from['username'])) $this->username = $this->from['username'];
        if(isset($this->from['language_code'])) $this->languageCode = $this->from['language_code'];
      }
      $this->chat = $update['edited_channel_post']['chat'];
      $this->chatID = $this->chat['id'];
      $this->chatType = $this->chat['type'];
      $this->chatTitle = $this->chat['title'];
      if(isset($this->chat['username'])) $this->chatUsername = $this->chat['username'];
      if(isset($this->chat['all_members_are_administrators'])) $this->chatAllAdmins = $this->chat['all_members_are_administrators'];
      if(isset($update['edited_channel_post']['forward_from'])) {
        $this->forwardFrom = $update['edited_channel_post']['forward_from'];
        $this->forwardFromID = $this->forwardFrom['id'];
        $this->forwardFromIsBot = $this->forwardFrom['is_bot'];
        $this->forwardFromFirstName = $this->forwardFrom['first_name'];
        if(isset($this->forwardFrom['last_name'])) {
          $this->forwardFromLastName = $this->forwardFrom['last_name'];
          $this->forwardFromFullName = $this->firstName . ' ' . $this->lastName;
        } else {
          $this->forwardFromFullName = $this->firstName;
        }
        if(isset($this->forwardFrom['username'])) $this->forwardFromUsername = $this->forwardFrom['username'];
        if(isset($this->forwardFrom['language_code'])) $this->forwardFromLanguageCode = $this->forwardFrom['language_code'];
      } elseif(isset($update['edited_channel_post']['forward_from_chat'])) {
        $this->forwardFrom = $update['edited_channel_post']['forward_from_chat'];
        $this->forwardFromID = $this->forwardFrom['id'];
        $this->forwardChatType = $this->forwardFrom['type'];
        $this->forwardChatTitle = $this->forwardFrom['title'];
        if(isset($this->forwardFrom['username'])) $this->forwardChatUsername = $this->forwardFrom['username'];
        if(isset($this->forwardFrom['all_members_are_administrators'])) $this->forwardChatAllAdmins = $this->forwardFrom['all_members_are_administrators'];
      }
      if(isset($update['edited_channel_post']['forward_from_message_id'])) $this->forwardFromMsgID = $update['edited_channel_post']['forward_from_message_id'];
      if(isset($update['edited_channel_post']['forward_signature'])) $this->forwardSignature = $update['edited_channel_post']['forward_signature'];
      if(isset($update['edited_channel_post']['forward_sender_name'])) $this->forwardSenderName = $update['edited_channel_post']['forward_sender_name'];
      if(isset($update['edited_channel_post']['forward_date'])) $this->forwardDate = $update['edited_channel_post']['forward_date'];
      if(isset($update['edited_channel_post']['reply_to_message'])) $this->replyMsg = $update['edited_channel_post']['reply_to_message'];
      if(isset($update['edited_channel_post']['edit_date'])) $this->editDate = $update['edited_channel_post']['edit_date'];
      if(isset($update['edited_channel_post']['media_group_id'])) $this->mediaGroupID = $update['edited_channel_post']['media_group_id'];
      if(isset($update['edited_channel_post']['author_signature'])) $this->authorSignature = $update['edited_channel_post']['author_signature'];
      if(isset($update['edited_channel_post']['entities'])) $this->msgEntities = $update['edited_channel_post']['entities'];
      if(isset($update['edited_channel_post']['caption_entities'])) $this->captionEntities = $update['edited_channel_post']['caption_entities'];
      if(isset($update['edited_channel_post']['text'])) {
        $this->isText = true;
        $this->msg = $update['edited_channel_post']['text'];
      } elseif(isset($update['edited_channel_post']['audio'])) {
        $this->isAudio = true;
        $this->audio = $update['edited_channel_post']['audio'];
        $this->fileID = $this->audio['file_id'];
        $this->audioDuration = $this->audio['duration'];
        if(isset($this->audio['performer'])) $this->audioPerformer = $this->audio['performer'];
        if(isset($this->audio['title'])) $this->audioTitle = $this->audio['title'];
        if(isset($this->audio['mime_type'])) $this->audioMimeType = $this->audio['mime_type'];
        if(isset($this->audio['file_size'])) $this->fileSize = $this->audio['file_size'];
        if(isset($this->audio['thumb'])) {
          $this->audioThumb = $this->audio['thumb'];
          $this->audioThumbFileID = $this->audioThumb['file_id'];
          $this->audioThumbWidth = $this->audioThumb['width'];
          $this->audioThumbHeight = $this->audioThumb['height'];
          if(isset($this->audioThumb['file_size'])) $this->audioThumbFileSize = $this->audioThumb['file_size'];
        }
      } elseif(isset($update['edited_channel_post']['document'])) {
        $this->isDocument = true;
        $this->document = $update['edited_channel_post']['document'];
        $this->fileID = $this->document['file_id'];
        if(isset($this->document['thumb'])) $this->fileThumb = $this->document['thumb'];
        if(isset($this->document['file_name'])) $this->fileName = $this->document['file_name'];
        if(isset($this->document['mime_type'])) $this->fileMimeType = $this->document['mime_type'];
        if(isset($this->document['file_size'])) $this->fileSize = $this->document['file_size'];
        if(isset($update['edited_channel_post']['animation'])) {
          $this->isAnimation = true;
          $this->animation = $update['edited_channel_post']['animation'];
          $this->videoWidth = $this->animation['width'];
          $this->videoHeight = $this->animation['height'];
          $this->videoDuration = $this->animation['duration'];
          if(isset($this->animation['thumb'])) {
            $this->videoThumb = $this->animation['thumb'];
            $this->videoThumbFileID = $this->videoThumb['file_id'];
            $this->videoThumbWidth = $this->videoThumb['width'];
            $this->videoThumbHeight = $this->videoThumb['height'];
            if(isset($this->videoThumb['file_size'])) $this->videoThumbFileSize = $this->videoThumb['file_size'];
          }
        }
      } elseif(isset($update['edited_channel_post']['game'])) {
        $isGame = true;
        $this->game = $update['edited_channel_post']['game'];
        $this->gameTitle = $this->game['title'];
        $this->gameDescription = $this->game['description'];
        $this->gamePhoto = $this->game['photo'];
        if(isset($this->game['text'])) $this->gameText = $this->game['text'];
        if(isset($this->game['text_entities'])) $this->gameTextEntities = $this->game['text_entities'];
        if(isset($this->game['animation'])) $this->gameAnimation = $this->game['animation'];
        $this->gameAnimation = $this->game['animation'];
        $this->gameVideoWidth = $this->gameAnimation['width'];
        $this->gameVideoHeight = $this->gameAnimation['height'];
        $this->gameVideoDuration = $this->gameAnimation['duration'];
        if(isset($this->gameAnimation['thumb'])) {
          $this->gameVideoThumb = $this->gameAnimation['thumb'];
          $this->gameVideoThumbFileID = $this->gameVideoThumb['file_id'];
          $this->gameVideoThumbWidth = $this->gameVideoThumb['width'];
          $this->gameVideoThumbHeight = $this->gameVideoThumb['height'];
          if(isset($this->gameVideoThumb['file_size'])) $this->gameVideoThumbFileSize = $this->gameVideoThumb['file_size'];
        }
      } elseif(isset($update['edited_channel_post']['photo'])) {
        $isPhoto = true;
        $this->photo = $update['edited_channel_post']['photo'];
      } elseif(isset($update['edited_channel_post']['sticker'])) {
        $isSticker = true;
        $this->sticker = $update['edited_channel_post']['sticker'];
        $this->fileID = $this->sticker['file_id'];
        $this->stickerWidth = $this->sticker['width'];
        $this->stickerHeight = $this->sticker['height'];
        if(isset($this->sticker['thumb'])) $this->stickerThumb = $this->sticker['thumb'];
        if(isset($this->sticker['emoji'])) $this->stickerEmoji = $this->sticker['emoji'];
        if(isset($this->sticker['mask_position'])) $this->stickerMaskPosition = $this->sticker['mask_position'];
        if(isset($this->sticker['file_size'])) $this->fileSize = $this->sticker['file_size'];
      } elseif(isset($update['edited_channel_post']['video'])) {
        $this->isVideo = true;
        $this->video = $update['edited_channel_post']['video'];
        $this->fileID = $this->video['file_id'];
        $this->videoWidth = $this->video['width'];
        $this->videoHeight = $this->video['height'];
        $this->videoDuration = $this->video['duration'];
        if(isset($this->video['thumb'])) {
          $this->videoThumb = $this->video['thumb'];
          $this->videoThumbFileID = $this->videoThumb['file_id'];
          $this->videoThumbWidth = $this->videoThumb['width'];
          $this->videoThumbHeight = $this->videoThumb['height'];
          if(isset($this->videoThumb['file_size'])) $this->videoThumbFileSize = $this->videoThumb['file_size'];
        }
        if(isset($this->video['mime_type'])) $this->videoMymeType = $this->video['mime_type'];
        if(isset($this->video['file_size'])) $this->fileSize = $this->video['file_size'];
      }
    } elseif(isset($update['callback_query'])) {
      $isCQ = true;
      $this->callbackQueryID = $update['callback_query']['id'];
      $this->from = $update['callback_query']['from'];
      $this->userID = $this->from['id'];
      $this->isBot = $this->from['is_bot'];
      $this->firstName = $this->from['first_name'];
      if(isset($this->from['last_name'])) {
        $this->lastName = $this->from['last_name'];
        $this->fullName = $this->firstName . ' ' . $this->lastName;
      } else {
        $this->fullName = $this->firstName;
      }
      if(isset($this->from['username'])) $this->username = $this->from['username'];
      if(isset($this->from['language_code'])) $this->languageCode = $this->from['language_code'];
      if(isset($update['callback_query']['inline_message_id'])) $this->inlineMsgID = $update['callback_query']['inline_message_id'];
      if(isset($update['callback_query']['data'])) $this->cbData = $update['callback_query']['data'];
    }
  }
}

 ?>
