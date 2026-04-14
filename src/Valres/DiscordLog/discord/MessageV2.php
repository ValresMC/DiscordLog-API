<?php

/**
 * .--.  .--.  .--. .---.
 * |   ):    ::    :  |
 * |--' |    ||    |  |
 * |  \ :    ;:    ;  |
 * '   ` `--'  `--'   '
 *       by Valres.
 * FRA:
 * Ce code source est la propriété exclusive de Valres.
 * Toute utilisation, reproduction, modification ou distribution de ce code
 * sans autorisation écrite explicite est strictement interdite.
 * ENG:
 * This source code is the exclusive property of Valres.
 * Any use, reproduction, modification, or distribution of this code
 * without explicit written authorization is strictly prohibited.
 */

declare(strict_types=1);

namespace Valres\DiscordLog\discord;

use JsonSerializable;

class MessageV2 implements JsonSerializable {
    public const FLAG_IS_COMPONENTS_V2 = 1 << 15; // 32768

    public const TYPE_SECTION = 9;
    public const TYPE_TEXT_DISPLAY = 10;
    public const TYPE_THUMBNAIL = 11;
    public const TYPE_MEDIA_GALLERY = 12;
    public const TYPE_FILE = 13;
    public const TYPE_SEPARATOR = 14;
    public const TYPE_CONTAINER = 17;

    protected array $data = [
        'flags' => self::FLAG_IS_COMPONENTS_V2,
        'components' => []
    ];

    public function setUsername(string $username): self {
        $this->data['username'] = $username;
        return $this;
    }

    public function setAvatarURL(string $avatarURL): self {
        $this->data['avatar_url'] = $avatarURL;
        return $this;
    }

    public function addComponent(array $component): self {
        $this->data['components'][] = $component;
        return $this;
    }

    public function setComponents(array $components): self {
        $this->data['components'] = $components;
        return $this;
    }

    public function addContainer(array $components, ?int $accentColor = null): self {
        $container = [
            'type' => self::TYPE_CONTAINER,
            'components' => $components
        ];

        if ($accentColor !== null) {
            $container['accent_color'] = $accentColor;
        }

        $this->data['components'][] = $container;
        return $this;
    }

    public function addTextDisplay(string $content): self {
        $this->data['components'][] = [
            'type' => self::TYPE_TEXT_DISPLAY,
            'content' => $content
        ];

        return $this;
    }

    public function addSeparator(bool $divider = true, int $spacing = 1): self {
        $this->data['components'][] = [
            'type' => self::TYPE_SEPARATOR,
            'divider' => $divider,
            'spacing' => $spacing
        ];

        return $this;
    }

    public function addSection(string $textContent, ?array $accessory = null): self {
        $this->data['components'][] = self::section($textContent, $accessory);
        return $this;
    }

    public function addThumbnail(string $url): self {
        $this->data['components'][] = self::thumbnail($url);
        return $this;
    }

    public function addMediaGallery(array $items): self {
        $this->data['components'][] = [
            'type' => self::TYPE_MEDIA_GALLERY,
            'items' => $items
        ];

        return $this;
    }

    public function addFile(string $attachmentName): self {
        $this->data['components'][] = self::file($attachmentName);
        return $this;
    }

    public static function textDisplay(string $content): array {
        return [
            'type' => self::TYPE_TEXT_DISPLAY,
            'content' => $content
        ];
    }

    public static function separator(bool $divider = true, int $spacing = 1): array {
        return [
            'type' => self::TYPE_SEPARATOR,
            'divider' => $divider,
            'spacing' => $spacing
        ];
    }

    public static function section(string $text, ?array $accessory = null): array {
        $section = [
            'type' => self::TYPE_SECTION,
            'components' => [
                [
                    'type' => self::TYPE_TEXT_DISPLAY,
                    'content' => $text
                ]
            ]
        ];

        if ($accessory !== null) {
            $section['accessory'] = $accessory;
        }

        return $section;
    }

    public static function thumbnail(string $url): array {
        return [
            'type' => self::TYPE_THUMBNAIL,
            'media' => [
                'url' => $url
            ]
        ];
    }

    public static function imageAccessory(string $url): array {
        return [
            'type' => self::TYPE_THUMBNAIL,
            'media' => [
                'url' => $url
            ]
        ];
    }

    public static function mediaGalleryItem(string $url, ?string $description = null): array {
        $item = [
            'media' => [
                'url' => $url
            ]
        ];

        if ($description !== null) {
            $item['description'] = $description;
        }

        return $item;
    }

    public static function mediaGallery(array $items): array {
        return [
            'type' => self::TYPE_MEDIA_GALLERY,
            'items' => $items
        ];
    }

    public static function file(string $attachmentName): array {
        return [
            'type' => self::TYPE_FILE,
            'file' => [
                'url' => 'attachment://' . $attachmentName
            ]
        ];
    }

    public function jsonSerialize(): array {
        return $this->data;
    }
}