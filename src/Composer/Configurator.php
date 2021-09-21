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

    public static function preInstall(PackageEvent $event)
    {
        $installedPackage = $event->getOperation()->getPackage();
        $composer = $event->getComposer();
        $IO = $event->getIo();
        $library = (int)$IO->ask('Wich map Library do you want to use ? (1 : leaflet, 2 : googlemaps, 3 : mapbox, 4 : openlayer, 0 for all)');

        $IO->write('You chose libraby ' . self::LIBRARIES[$library]);
    }

    public static function postInstall(PackageEvent $event)
    {
        $installedPackage = $event->getOperation()->getPackage();
        $IO = $event->getIo();

        if($IO->askConfirmation('Supprimer les dépendances inutiles ?')) {
            $IO->write('Dépendances supprimées.');
        }
        $IO->write('******* Installation terminée *********');
    }

}
