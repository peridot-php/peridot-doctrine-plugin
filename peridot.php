<?php

use Evenement\EventEmitterInterface;
use Peridot\Console\Environment;
use Peridot\Plugin\Prophecy\ProphecyPlugin;

return function (EventEmitterInterface $eventEmitter) {
    $eventEmitter->on('peridot.start', function (Environment $environment) {
        $environment->getDefinition()->getArgument('path')->setDefault('specs');
    });

    new ProphecyPlugin($eventEmitter);
};
