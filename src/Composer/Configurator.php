<?php
declare(strict_types=1);

namespace ComposerTest\Composer;

use Composer\Config;
use Composer\Script\Event;
use Composer\Installer\PackageEvent;

class Configurator
{
    private int $library;

    const LIBRARIES = [
        1 => 'leaflet',
        2 => 'googlemaps',
        3 => 'mapbox',
        4 => 'openlayer'
    ];

    public static function preInstall(Event $event)
    {
        $composer = $event->getComposer();
        $IO = $event->getIo();
        $library = (int)$IO->ask('Wich map Library do you want to use ? (1 : leaflet, 2 : googlemaps, 3 : mapbox, 4 : openlayer, 0 for all)');
        $config = new Config();
        $source = new Config\JsonConfigSource();
        if($library === 1) {
            $source->addConfigSetting('require', ['symfony/http-kernel' => '^4.4.17|^5.0'] );
        }
        if($library === 2) {
            $source->addConfigSetting('require', ['symfony/dependency-injection' => '^4.4.17|^5.0'] );
        }
        if($library === 3) {
            $source->addConfigSetting('require', ['symfony/config' => '^4.4.17|^5.0'] );
        } else {
            $source->addConfigSetting('require', ['symfony/twig-bundle' => '^4.4.17|^5.0'] );
        }

        $config->setConfigSource($source);
        $composer->setConfig($config);
    }

    public static function postInstall(Event $event)
    {
        $IO = $event->getIo();

        if($IO->askConfirmation('Supprimer les dépendances inutiles ?')) {
            $IO->write('Dépendances supprimées.');
        }
        $IO->write('******* Installation terminée *********');
    }

}
