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

namespace Valres\DiscordLog;

use pocketmine\plugin\Plugin;
use pocketmine\scheduler\ClosureTask;
use Valres\DiscordLog\exceptions\HookAlreadyRegistered;
use Valres\DiscordLog\managers\MessageQueues;

final class DiscordLogHandler
{
    private static ?Plugin $registrant = null;

    /**
     * Register the Discord log handler with the specified plugin.
     *
     * @param  Plugin $plugin The plugin to register with.
     * @return void
     * @throws HookAlreadyRegistered
     */
    public static function register(Plugin $plugin): void {
        if(self::isRegistered()){
            throw new HookAlreadyRegistered("DiscordLog is already registered.");
        }

        self::$registrant = $plugin;
        $plugin->getScheduler()->scheduleRepeatingTask(new ClosureTask(function(): void {
            $queuesInstance = MessageQueues::getInstance();
            foreach($queuesInstance->getQueues() as $queue) $queue->update();
        }), 20);
    }

    /**
     * Check if the Discord log handler is already registered.
     *
     * @return bool True if registered, false otherwise.
     */
    public static function isRegistered(): bool {
        return self::$registrant !== null;
    }

    /**
     * Unregister the Discord log handler.
     *
     * @return void
     */
    public static function unregister(): void {
        self::$registrant = null;
        MessageQueues::getInstance()->deleteQueues();
    }
}
