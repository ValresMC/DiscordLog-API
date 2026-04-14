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

use JsonSerializable;
use pocketmine\utils\SingletonTrait;
use Valres\DiscordLog\discord\Embed;
use Valres\DiscordLog\discord\Webhook;
use Valres\DiscordLog\exceptions\QueueAlreadyRegisteredException;
use Valres\DiscordLog\exceptions\QueueNotFoundException;

class MessageQueues
{
    use SingletonTrait;

    /** @var Queue[] */
    private array $queues = [];

    public function getQueue(string $queueName): ?Queue {
        return $this->queues[$queueName] ?? null;
    }

    public function getQueues(): array {
        return $this->queues;
    }

    public function deleteQueues(): void {
        $this->queues = [];
    }

    /**
     * @throws QueueAlreadyRegisteredException
     */
    public function registerQueue(string $queueName, Webhook $webhook, int $timer): void {
        if ($this->getQueue($queueName) !== null) {
            throw new QueueAlreadyRegisteredException("The queue '$queueName' is already registered.");
        }

        $this->queues[$queueName] = new Queue($queueName, $webhook, $timer);
    }

    /**
     * @throws QueueNotFoundException
     */
    public function addPayloadInQueue(string $queueName, JsonSerializable ...$payloads): void {
        $queue = $this->getQueue($queueName);
        if ($queue === null) {
            throw new QueueNotFoundException("The queue '$queueName' is not registered.");
        }

        foreach ($payloads as $payload) {
            $queue->addPayload($payload);
        }
    }
}
