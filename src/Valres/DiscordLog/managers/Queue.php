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

namespace Valres\DiscordLog\managers;

use InvalidArgumentException;
use Valres\DiscordLog\discord\Message;
use Valres\DiscordLog\discord\Webhook;

class Queue
{
    public int $timer;

    public function __construct(
        protected string $name,
        protected Webhook $webhook,
        protected int $sendTimer,
        protected array $messages = []
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
     * Add a message to the queue.
     *
     * @param string $message The message to add.
     * @return void
     * @throws InvalidArgumentException if the message is empty.
     */
    public function addMessageInQueue(string $message): void {
        if(empty($message)){
            throw new InvalidArgumentException("Message in queue '" . $this->name . "' cannot be empty.");
        }
        $this->messages[] = $message;
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
     * Update the queue, decrementing the timer and resetting if necessary.
     *
     * @return void
     */
    public function update(): void {
        if(--$this->timer <= 0){
            $message = (new Message())->setContent(join("\n", $this->messages));
            $this->getWebhook()->send($message);
            $this->deleteMessages();
            $this->timer = $this->getSendTimer();
        }
    }
}
