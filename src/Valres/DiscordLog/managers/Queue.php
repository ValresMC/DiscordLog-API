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

namespace Valres\DiscordLog\managers;

use InvalidArgumentException;
use Valres\DiscordLog\discord\Embed;
use Valres\DiscordLog\discord\Message;
use Valres\DiscordLog\discord\Webhook;

class Queue
{
    public int $timer;

    public function __construct(
        protected string  $name,
        protected Webhook $webhook,
        protected int     $sendTimer,
        protected array   $messages = [],
        protected array   $embeds = []
    ) {
        $this->timer = $this->sendTimer;
    }

    /**
     * Get the name of the queue.
     *
     * @return string The name of the queue.
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * Get the Webhook of thr queue.
     *
     * @return Webhook
     */
    public function getWebhook(): Webhook {
        return $this->webhook;
    }

    /**
     * Get the time between each sending of messages.
     *
     * @return int The send timer interval.
     */
    public function getSendTimer(): int {
        return $this->sendTimer;
    }

    /**
     * Get all pending messages in queue.
     *
     * @return array The list of pending messages.
     */
    public function getMessages(): array {
        return $this->messages;
    }

    /**
     * Get all pending Embed in queue.
     *
     * @return Embed[] The list of the pending Embeds.
     */
    public function getEmbeds(): array {
        return $this->embeds;
    }

    /**
     * Add a message to the queue.
     *
     * @param string $message The message to add.
     * @return void
     * @throws InvalidArgumentException if the message is empty.
     */
    public function addMessage(string $message): void {
        if(empty($message)){
            throw new InvalidArgumentException("Message in queue '" . $this->name . "' cannot be empty.");
        }
        $this->messages[] = $message;
    }

    /**
     * Add an Embed to the queue.
     *
     * @param Embed $embed The message to add.
     * @return void
     * @throws InvalidArgumentException if the message is empty.
     */
    public function addEmbed(Embed $embed): void {
        $this->embeds[] = $embed;
    }

    /**
     * Delete messages in the queue.
     *
     * @return void
     */
    public function deleteMessages(): void {
        $this->messages = [];
    }

    /**
     * Delete Embeds in the queue.
     *
     * @return void
     */
    public function deleteEmbeds(): void {
        $this->embeds = [];
    }

    /**
     * Update the queue, decrementing the timer and resetting if necessary.
     *
     * @return void
     */
    public function update(): void {
        if(--$this->timer <= 0){
            if(empty($this->messages) and empty($this->embeds)) return;

            $message = (new Message())->setContent(join("\n", $this->messages));
            foreach($this->embeds as $embed) $message->addEmbed($embed);
            $this->getWebhook()->send($message);

            $this->deleteMessages();
            $this->deleteEmbeds();

            $this->timer = $this->getSendTimer();
        }
    }
}
