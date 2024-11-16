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

namespace Valres\DiscordLog\discord\task;

use InvalidArgumentException;
use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;

class DiscordWebhookSendTask extends AsyncTask
{
    private string $url;

    private string $message;

    /**
     * Constructor for the DiscordWebhookSendTask class.
     *
     * @param string $url     The URL of the Discord webhook.
     * @param string $message The message to send.
     */
    public function __construct(string $url, string $message) {
        if(filter_var($url, FILTER_VALIDATE_URL) === false){
            throw new InvalidArgumentException("Invalid URL provided.");
        }
        $this->url = $url;
        $this->message = $message;
    }

    /**
     * Executes the task. This method is run asynchronously.
     *
     * @return void
     */
    public function onRun(): void {
        $ch = curl_init($this->url);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->message);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);

        $this->setResult([curl_exec($ch), curl_getinfo($ch, CURLINFO_RESPONSE_CODE)]);
        curl_close($ch);
    }


    /**
     * Handles the completion of the asynchronous task.
     *
     * @return void
     */
    public function onCompletion(): void {
        $response = $this->getResult();
        if(!in_array($response[1], [200, 204])){
            Server::getInstance()->getLogger()->error("[DiscordLog] Got error ({$response[1]}): " . $response[0]);
        }
    }
}


