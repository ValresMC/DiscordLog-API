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

class Message implements JsonSerializable
{
    protected array $data = [];

    /**
     * Sets the content of the message.
     *
     * @param string $content The message content.
     * @return self
     */
    public function setContent(string $content): self {
        $this->data['content'] = $content;
        return $this;
    }

    /**
     * Gets the content of the message.
     *
     * @return string|null The message content or null if not set.
     */
    public function getContent(): ?string {
        return $this->data['content'] ?? null;
    }

    /**
     * Sets the username for the message.
     *
     * @param string $username The username.
     * @return self
     */
    public function setUsername(string $username): self {
        $this->data['username'] = $username;
        return $this;
    }

    /**
     * Gets the username for the message.
     *
     * @return string|null The username or null if not set.
     */
    public function getUsername(): ?string {
        return $this->data['username'] ?? null;
    }

    /**
     * Sets the avatar URL for the message.
     *
     * @param string $avatarURL The avatar URL.
     * @return self
     */
    public function setAvatarURL(string $avatarURL): self {
        $this->data['avatar_url'] = $avatarURL;
        return $this;
    }

    /**
     * Gets the avatar URL for the message.
     *
     * @return string|null The avatar URL or null if not set.
     */
    public function getAvatarURL(): ?string {
        return $this->data['avatar_url'] ?? null;
    }

    /**
     * Adds an embed to the message.
     *
     * @param Embed $embed The embed object.
     * @return self
     */
    public function addEmbed(Embed $embed): self {
        $embedArray = $embed->asArray();
        if(!empty($embedArray)){
            $this->data['embeds'][] = $embedArray;
        }
        return $this;
    }

    /**
     * Serializes the message object to an array for JSON encoding.
     *
     * @return array The data array representing the message.
     */
    public function jsonSerialize(): array {
        return $this->data;
    }
}
