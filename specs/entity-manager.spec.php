<?php

use Doctrine\ORM\Mapping\Driver\SimplifiedYamlDriver;
use Peridot\Plugin\Doctrine\EntityManagerFactory;

describe('EntityManagerFactory', function () {
    beforeEach(function () {
        $this->factory = new EntityManagerFactory();
    });

    describe('->create()', function () {
        beforeEach(function () {
            $this->mappingDriver = new SimplifiedYamlDriver(sys_get_temp_dir());
            $this->entityManager = $this->factory->create($this->mappingDriver);
        });

        it('should return an instance of EntityManager', function () {
            expect($this->entityManager)->to->be->instanceof('Doctrine\ORM\EntityManager');
        });

        it('should connect the EntityManager to a sqlite database', function () {
            expect($this->entityManager->getConnection()->getDriver()->getName())->to->equal('pdo_sqlite');
        });

        it('should configure the mapping files', function () {
            expect($this->entityManager->getConfiguration()->getMetadataDriverImpl())->to->equal($this->mappingDriver);
        });
    });
});
