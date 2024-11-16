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

use DateTime;

class Embed
{
    protected array $data = [];

    /**
     * Converts the embed object to an array.
     *
     * @return array The data array representing the embed.
     */
    public function asArray(): array {
        return $this->data;
    }

    /**
     * Sets the author of the embed.
     *
     * @param string      $name    The author's name.
     * @param string|null $url     The URL associated with the author.
     * @param string|null $iconURL The URL of the author's icon.
     * @return self
     */
    public function setAuthor(string $name, string $url = null, string $iconURL = null): self {
        $this->data['author'] = [
            'name' => $name,
            'url' => $url,
            'icon_url' => $iconURL,
        ];
        return $this;
    }

    /**
     * Sets the title of the embed.
     *
     * @param string $title The title of the embed.
     * @return self
     */
    public function setTitle(string $title): self {
        $this->data['title'] = $title;
        return $this;
    }

    /**
     * Sets the description of the embed.
     *
     * @param string $description The description of the embed.
     * @return self
     */
    public function setDescription(string $description): self {
        $this->data['description'] = $description;
        return $this;
    }

    /**
     * Sets the color of the embed.
     *
     * @param int $color The color code of the embed.
     * @return self
     */
    public function setColor(int $color): self {
        $this->data['color'] = $color;
        return $this;
    }

    /**
     * Adds a field to the embed.
     *
     * @param string $name   The name of the field.
     * @param string $value  The value of the field.
     * @param bool   $inline Whether the field is inline.
     * @return self
     */
    public function addField(string $name, string $value, bool $inline = false): self {
        $this->data['fields'][] = [
            'name' => $name,
            'value' => $value,
            'inline' => $inline,
        ];
        return $this;
    }

    /**
     * Sets the thumbnail of the embed.
     *
     * @param string $url The URL of the thumbnail.
     * @return self
     */
    public function setThumbnail(string $url): self {
        $this->data['thumbnail'] = ['url' => $url];
        return $this;
    }

    /**
     * Sets the image of the embed.
     *
     * @param string $url The URL of the image.
     * @return self
     */
    public function setImage(string $url): self {
        $this->data['image'] = ['url' => $url];
        return $this;
    }

    /**
     * Sets the footer of the embed.
     *
     * @param string      $text    The footer text.
     * @param string|null $iconURL The URL of the footer icon.
     * @return self
     */
    public function setFooter(string $text, string $iconURL = null): self {
        $this->data['footer'] = [
            'text' => $text,
            'icon_url' => $iconURL,
        ];
        return $this;
    }

    /**
     * Sets the timestamp of the embed.
     *
     * @param DateTime $timestamp The timestamp.
     * @return self
     */
    public function setTimestamp(\DateTime $timestamp): self {
        $timestamp->setTimezone(new \DateTimeZone('UTC'));
        $this->data['timestamp'] = $timestamp->format('Y-m-d\TH:i:s.v\Z');
        return $this;
    }
}