# EasyBan
> A simple way to ban users with NovaGram.

EasyBan is a simple library extension for [NovaGram](https://github.com/skrtdev/NovaGram) ([See novagram docs](https://docs.novagram.ga/prototypes.html)) that allows you to ban the users of your bot.


## Installation

Composer:

```sh
composer require code-a1/EasyBan
```

## Usage example

Here a simple example that show how EasyBan work:

```php
    
        $chat = $message->chat;
        $text = $message->text;
        
        if(explode(" ", $text)[0] === "/ban"){ //to ban a user you must only send /ban [user_id]
        
            $Bot->banUser(explode(" ", $text)[1]);
            $chat->sendMessage("User Banned!");
            
        }
        
        if(explode(" ", $text)[0] === "/unban"){ //to unban a user you must only send /unban [user_id]
        
            $Bot->unbanUser(explode(" ", $text)[1]);
            $chat->sendMessage("User unBanned!");
            
        }

```

## Methods

- checkBan() : You can use this method to check if a user is banned
- banUser() : You can use this method to ban a user
- unbanUser() : You can use this method to unBan a user

