<h1>DiscordLog-API<img src="logo.png" height="40" width="40" align="left"></h1>

A robust and efficient PocketMine-MP virion for managing webhook integrations and message queues, tailored for seamless asynchronous communication.

***
## Basic usage :

### Register the `DiscordLogHandler` :
```php
use Valres\DiscordLog\DiscordLogHandler;

# onEnable() :
if(!DiscordLogHandler::isRegistered()){
    DiscordLogHandler::register($this);
}
```

### Register a queue :
```php
use Valres\DiscordLog\managers\MessageQueues;
use Valres\DiscordLog\discord\Webhook;

# Preferably in onEnable() :
MessageQueues::getInstance()->registerQueue(
    "your_queue_name",
    new Webhook("url_of_your_webhook"),
    5 # seconds between sending pending messages.
);
```

### Add a message to a queue :
```php
use Valres\DiscordLog\managers\MessageQueues;

# Wherever you need :
MessageQueues::getInstance()->addMessage(
    "your_queue_name", # The queue will be registered !!
    "your_message"
);
```

### Add an embed to a queue :
```php
use Valres\DiscordLog\managers\MessageQueues;

# Wherever you need :
MessageQueues::getInstance()->addMessage(
    "your_queue_name", # The queue will be registered !!
    (new Embed())->setTitle("Your title")->setDescription("Your description")
);
```

***

#### Hopefully is helping you ! By Valres :)
