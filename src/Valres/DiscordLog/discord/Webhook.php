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
 * ENG: This file is part of a public API.
 * It contains code intended for public use and distribution.
 * Contributions and usage are encouraged under the terms of the applicable license.
 * Unauthorized modifications or improper use may result in legal consequences.
 *
 * FRA: Ce fichier fait partie d'une API publique.
 * Il contient du code destiné à être utilisé et distribué publiquement.
 * Les contributions et l'utilisation sont encouragées selon les termes de la licence applicable.
 * Toute modification non autorisée ou utilisation incorrecte peut entraîner des conséquences légales.
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
