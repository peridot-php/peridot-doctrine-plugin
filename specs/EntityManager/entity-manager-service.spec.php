<?php

use Doctrine\ORM\Mapping\Driver\SimplifiedYamlDriver;
use Evenement\EventEmitter;
use Peridot\Plugin\Doctrine\EntityManager\EntityManagerService;

describe('Peridot\Plugin\Doctrine\EntityManager\EntityManagerService', function () {
    beforeEach(function () {
        $this->entityManagerService = (new EntityManagerService())->setEventEmitter(new EventEmitter())
            ->setMappingDriver(new SimplifiedYamlDriver([]));
    });

    describe('->createEntityManager()', function () {
        it('should return a doctrine entity manager', function() {
            $entityManager = $this->entityManagerService->createEntityManager();
            expect($entityManager)->to->be->instanceof('Doctrine\ORM\EntityManager');
        });
    });
});
