<?php

use skrtdev\NovaGram\Bot;
use skrtdev\Telegram\User;

// check if the user is banned (if is banned it returns true, else false)
User::addMethod("isBanned", fn() => $this->conversation("ban") === "banned");

User::addMethod("ban", function (string $reason = null) { // ban the user

    $chat = $this->update->message->chat;
    $db = $this->conversation("ban", "banned"); // set the converstation
    $banmessage = isset($reason) ? "🚫 You were banned for $reason" : "🚫 You were banned";
    $this->sendMessage($banmessage); // send the ban message to the user

});

User::addMethod("unban", function () { //unban the user

    $chat = $this->update->message->chat;

    if($this->conversation("ban") === "banned"){ // check if the user is banned

        $this->clearConversation("ban"); //remove the conversation
        $this->sendMessage("😇 You were unBanned"); // send the unBan message to the user

    } else return false;

});

Bot::addMethod("isBanned", function () { //check if the user is banned (if is banned it returns true, else false)

    $user = $this->update->message->from;
    return $user->conversation("ban") === "banned";

});

Bot::addMethod("banUser", function (int $id, string $reason = null) { // ban the user

    $chat = $this->update->message->chat;
    $db = $this->getDatabase();

    if($db->existQuery($db->queries['selectUser'], [':user_id' => $id])){ // check if the user has ever started the bot

        $db->setConversation($id, "ban", "banned"); // set the converstation
        $banmessage = isset($reason) ? "🚫 You were banned for $reason" : "🚫 You were banned";
        $this->sendMessage($id, $banmessage); // send the ban message to the user

    } else $chat->sendMessage("😅 Ops! The user has never started the bot");

});

Bot::addMethod("unbanUser", function (int $id) { //unban the user

    $chat = $this->update->message->chat;
    $db = $this->getDatabase();

    if($db->getConversation($id, "ban") === "banned"){ // check if the user is banned

        $db->deleteConversation($id, "ban"); //remove the conversation
        $this->sendMessage($id, "😇 You were unBanned"); // send the unBan message to the user

    } else $chat->sendMessage("😅 Ops! The user is not banned");

});

?>
