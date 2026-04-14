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
use JsonSerializable;
use Valres\DiscordLog\discord\Embed;
use Valres\DiscordLog\discord\Message;
use Valres\DiscordLog\discord\Webhook;

class Queue
{
    public int $timer;

    /**
     * @param JsonSerializable[] $payloads
     */
    public function __construct(
        protected string $name,
        protected Webhook $webhook,
        protected int $sendTimer,
        protected array $payloads = []
    ) {
        $this->timer = $this->sendTimer;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getWebhook(): Webhook {
        return $this->webhook;
    }

    public function getSendTimer(): int {
        return $this->sendTimer;
    }

    /**
     * @return JsonSerializable[]
     */
    public function getPayloads(): array {
        return $this->payloads;
    }

    public function addPayload(JsonSerializable $payload): void {
        $this->payloads[] = $payload;
    }

    public function deletePayloads(): void {
        $this->payloads = [];
    }

    public function update(): void {
        if (--$this->timer <= 0) {
            if (empty($this->payloads)) {
                $this->timer = $this->getSendTimer();
                return;
            }

            foreach ($this->payloads as $payload) {
                $this->getWebhook()->send($payload);
            }

            $this->deletePayloads();
            $this->timer = $this->getSendTimer();
        }
    }
}
