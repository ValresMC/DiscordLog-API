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

use JsonSerializable;
use Valres\DiscordLog\discord\task\DiscordWebhookSendTask;
use pocketmine\Server;

class Webhook {
    protected string $url;

    public function __construct(string $url) {
        $this->url = $url;
    }

    public function send(JsonSerializable $message): void {
        $url = $this->getURL();

        $separator = str_contains($url, "?") ? "&" : "?";
        if (!str_contains($url, "with_components=")) {
            $url .= $separator . "with_components=true";
        }

        Server::getInstance()->getAsyncPool()->submitTask(
            new DiscordWebhookSendTask(
                $url,
                json_encode($message, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
            )
        );
    }

    public function getURL(): string {
        return $this->url;
    }
}