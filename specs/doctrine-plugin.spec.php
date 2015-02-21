<?php

use Doctrine\ORM\Mapping\Driver\SimplifiedYamlDriver;
use Evenement\EventEmitter;
use Peridot\Core\Suite;
use Peridot\Plugin\Doctrine\DoctrinePlugin;
use Prophecy\Prophet;

require_once __DIR__ . '/entities/Customer.php';

describe('DoctrinePlugin', function () {
    beforeEach(function () {
        $this->emitter = new EventEmitter();
        $this->plugin = new DoctrinePlugin(
            $this->emitter,
            new SimplifiedYamlDriver([__DIR__ . '/mapping' => 'Peridot\Plugin\Doctrine\Entity'])
        );
    });

    context('when suite.start event fires', function() {
        it('should set add the doctrine scope to the child scope', function() {
            $suite = new Suite('suite', function() {});
            $this->emitter->emit('suite.start', [$suite]);
            $entityManager = $suite->getScope()->getEntityManager();
            expect($entityManager)->to->be->instanceof('Doctrine\ORM\EntityManager');
        });
    });
});
