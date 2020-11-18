<?php

use skrtdev\NovaGram\Bot;
use skrtdev\Telegram\User;

User::addMethod("checkBan", function () { //check if the user is banned (if is banned it returns true, else false)

    $result = $this->conversation("ban") === "banned" ? true : false;
    return $result;

});

Bot::addMethod("checkBan", function () { //check if the user is banned (if is banned it returns true, else false)
    
    $user = $this->update->message->from;
    $result = $this->conversation("ban") === "banned" ? true : false;
    return $result;

});

Bot::addMethod("banUser", function (int $id, string $reason = null) { // ban the user

    $user = $this->update->message->from;
    $chat = $this->update->message->chat;
    $db = $this->getDatabase();

    if($db->existQuery($db->queries['selectUser'], [':user_id' => $id])){ // check if the user has ever started the bot

        $db->setConversation($id, "ban", "banned"); // set the converstation
        $banmessage = isset($reason) ? "🚫 You were banned for $reason" : "🚫 You were banned";
        $this->sendMessage($id, $banmessage); // send the ban message to the user

    } else $chat->sendMessage("😅 Ops! The user has never started the bot");

});

Bot::addMethod("unbanUser", function (int $id) { //unban the user

    $user = $this->update->message->from;
    $chat = $this->update->message->chat;
    $db = $this->getDatabase();

    if($db->getConversation($id, "ban") === "banned"){ // check if the user is banned

        $db->deleteConversation($id, "ban"); //remove the conversation
        $this->sendMessage($id, "😇 You were unBanned"); // send the unBan message to the user

    } else $chat->sendMessage("😅 Ops! The user is not banned");

});

?>
