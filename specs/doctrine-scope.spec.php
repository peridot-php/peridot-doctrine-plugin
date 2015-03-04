<?php

use Doctrine\ORM\Mapping\Driver\SimplifiedYamlDriver;
use Evenement\EventEmitter;
use Peridot\Plugin\Doctrine\DoctrineScope;
use Peridot\Plugin\Doctrine\EntityManager\EntityManagerService;

describe('Peridot\Plugin\Doctrine\DoctrineScope', function () {
    beforeEach(function () {
        $entityManagerService = (new EntityManagerService())->setEventEmitter(new EventEmitter())
            ->setMappingDriver(new SimplifiedYamlDriver([]));
        $this->doctrineScope = new DoctrineScope($entityManagerService);
    });

    describe('->createEntityManager()', function () {
        it('should return a doctrine entity manager', function() {
            $entityManager = $this->doctrineScope->createEntityManager();
            expect($entityManager)->to->be->instanceof('Doctrine\ORM\EntityManager');
        });
    });
});
