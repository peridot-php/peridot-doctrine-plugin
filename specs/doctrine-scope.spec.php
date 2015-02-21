<?php

use Peridot\Plugin\Doctrine\DoctrineScope;

require_once __DIR__ . '/entities/Customer.php';

describe('DoctrineScope', function() {
    beforeEach(function() {
        $this->plugin = $this->getProphet()->prophesize('Peridot\Plugin\Doctrine\DoctrinePlugin');
        $this->emFactory = $this->getProphet()->prophesize('Peridot\Plugin\Doctrine\EntityManagerFactory');

        $this->scope = new DoctrineScope(
            $this->plugin->reveal(),
            $this->emFactory->reveal()
        );
    });

    describe('->getEntityManager()', function() {
        beforeEach(function () {
            $em = $this->getProphet()->prophesize('Doctrine\ORM\EntityManager');
            $this->plugin->getMappingDriver()->willReturn(5);
            $this->plugin->getConnectionInfo()->willReturn([]);
            $this->emFactory->create(5, [])->willReturn($em);
        });

        it('should return an EntityManager', function() {
            $entityManager = $this->scope->getEntityManager();
            expect($entityManager)->to->be->instanceof('Doctrine\ORM\EntityManager');
        });

        it('should return the same EntityManager instance', function() {
            $entityManager = $this->scope->getEntityManager();
            $again = $this->scope->getEntityManager();
            expect($entityManager)->to->equal($again);
        });
    });
});
