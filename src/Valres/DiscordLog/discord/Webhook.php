<?php

/**
 *  ▄▀▀▄ ▄▀▀▄  ▄▀▀█▄   ▄▀▀▀▀▄      ▄▀▀▄▀▀▀▄  ▄▀▀█▄▄▄▄  ▄▀▀▀▀▄
 * █   █    █ ▐ ▄▀ ▀▄ █    █      █   █   █ ▐  ▄▀   ▐ █ █   ▐
 * ▐  █    █    █▄▄▄█ ▐    █      ▐  █▀▀█▀    █▄▄▄▄▄     ▀▄
 *    █   ▄▀   ▄▀   █     █        ▄▀    █    █    ▌  ▀▄   █
 *     ▀▄▀    █   ▄▀    ▄▀▄▄▄▄▄▄▀ █     █    ▄▀▄▄▄▄    █▀▀▀
 *      ▐   ▐     █         ▐     ▐    █    ▐    ▐
 *                          ▐                    ▐
 *
 * ENG: This file is strictly confidential and personal.
 * It contains code developed for private purposes and must not be distributed, shared or used without the explicit permission of the author.
 * Any violation will be subject to legal action.
 * FRA: Ce fichier est strictement confidentiel et personnel.
 * Il contient du code développé à des fins privées et ne doit en aucun cas être distribué, partagé ou utilisé sans autorisation explicite de l'auteur.
 * Toute violation sera passible de poursuites légales.
 *
 * @author  ValresMC
 * @version v0.0.1
 */

declare(strict_types=1);

namespace Valres\DiscordLog\discord;

use Valres\DiscordLog\discord\task\DiscordWebhookSendTask;
use pocketmine\Server;

class Webhook
{
    protected string $url;

    /**
     * Constructor for the Webhook class.
     *
     * @param string $url The URL of the webhook.
     */
    public function __construct(string $url) {
        $this->url = $url;
    }

    /**
     * Sends a message to the webhook.
     *
     * @param Message $message The message to send.
     * @return void
     */
    public function send(Message $message): void {
        Server::getInstance()->getAsyncPool()->submitTask(
            new DiscordWebhookSendTask($this->getURL(), json_encode($message))
        );
    }

    /**
     * Retrieves the URL of the webhook.
     *
     * @return string The URL of the webhook.
     */
    public function getURL(): string {
        return $this->url;
    }
}
