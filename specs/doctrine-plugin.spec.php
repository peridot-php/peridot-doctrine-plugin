<?php

use Doctrine\ORM\Mapping\Driver\SimplifiedYamlDriver;
use Evenement\EventEmitter;
use Peridot\Core\Suite;
use Peridot\Plugin\Doctrine\DoctrinePlugin;
use Peridot\Plugin\Doctrine\EntityManager\EntityManagerService;

describe('Peridot\Plugin\Doctrine\DoctrinePlugin', function () {
    beforeEach(function () {
        $this->entityManagerService = (new EntityManagerService())->setMappingDriver(new SimplifiedYamlDriver([]));
        $this->eventEmitter = new EventEmitter();
        $this->plugin = new DoctrinePlugin($this->eventEmitter, $this->entityManagerService);
    });

    describe('->onSuiteStart()', function () {
        it('should add the doctrine scope to the child scope', function() {
            $suite = new Suite('my suite', ['foo', 'bar']);
            $this->eventEmitter->emit('suite.start', [$suite]);
            $entityManager = $suite->getScope()->createEntityManager();

            expect($entityManager)->to->be->instanceof('Doctrine\ORM\EntityManager');
        });
    });
});
