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
