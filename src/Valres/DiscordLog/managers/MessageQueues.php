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

use pocketmine\utils\SingletonTrait;
use Valres\DiscordLog\discord\Webhook;
use Valres\DiscordLog\exceptions\QueueAlreadyRegisteredException;
use Valres\DiscordLog\exceptions\QueueNotFoundException;

class MessageQueues
{
    use SingletonTrait;

    /** @var Queue[] */
    private array $queues = [];

    /**
     * Get a queue by name.
     *
     * @param string $queueName Name of the queue.
     * @return Queue|null
     */
    public function getQueue(string $queueName): ?Queue {
        return $this->queues[$queueName] ?? null;
    }

    /**
     * Get all the queues.
     *
     * @return Queue[]
     */
    public function getQueues(): array {
        return $this->queues;
    }

    /**
     * Delete all the queues.
     *
     * @return void
     */
    public function deleteQueues(): void {
        $this->queues = [];
    }

    /**
     * Register a messages queue.
     * @param string  $queueName The queue name.
     * @param Webhook $webhook   The Webhook instance.
     * @param int     $timer     Time between each sending message.
     * @return void
     * @throws QueueAlreadyRegisteredException
     */
    public function registerQueue(string $queueName, Webhook $webhook, int $timer): void {
        if($this->getQueue($queueName) !== null){
            throw new QueueAlreadyRegisteredException("The queue '$queueName' is already registered.");
        }

        $this->queues[$queueName] = new Queue($queueName, $webhook, $timer);
    }

    /**
     * Add a message in the queue.
     * @param string $queueName The queue name.
     * @param string $message   The message to add.
     * @return void
     * @throws QueueNotFoundException
     */
    public function addMessageInQueue(string $queueName, string $message): void {
        $queue = $this->getQueue($queueName);
        if($queue === null){
            throw new QueueNotFoundException("The queue '$queueName' is not registered.");
        }

        $queue->addMessageInQueue($message);
    }
}
