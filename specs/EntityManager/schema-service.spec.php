<?php

use Peridot\Plugin\Doctrine\EntityManager\SchemaService;

describe('Peridot\Plugin\Doctrine\EntityManager\SchemaService', function () {
    beforeEach(function () {
        $this->prophet = $this->getProphet();

        $platform = $this->prophet->prophesize('Doctrine\DBAL\Platforms\AbstractPlatform');
        $connection = $this->prophet->prophesize('Doctrine\DBAL\Connection');
        $connection->getDatabasePlatform()->willReturn($platform->reveal());

        $quoteStrategy = $this->prophet->prophesize('Doctrine\ORM\Mapping\QuoteStrategy');
        $configuration = $this->prophet->prophesize('Doctrine\ORM\Configuration');
        $configuration->getQuoteStrategy()->willReturn($quoteStrategy->reveal());

        $this->entityManager = $this->prophet->prophesize('Doctrine\ORM\EntityManagerInterface');
        $this->entityManager->getConnection()->willReturn($connection->reveal());
        $this->entityManager->getConfiguration()->willReturn($configuration->reveal());

        $this->schemaService = new SchemaService($this->entityManager->reveal());
    });

    describe('property accessors', function () {
        it('should provide accessors for the entity manager', function () {
            $entityManager = $this->prophet->prophesize('Doctrine\ORM\EntityManagerInterface')->reveal();
            $this->schemaService->setEntityManager($entityManager);
            expect($this->schemaService->getEntityManager())->to->equal($entityManager);
        });

        it('should provide accessors for the schema tool', function () {
            $schemaTool = $this->prophet->prophesize('Doctrine\ORM\Tools\SchemaTool')->reveal();
            $this->schemaService->setSchemaTool($schemaTool);
            expect($this->schemaService->getSchemaTool())->to->equal($schemaTool);
        });
    });

    describe('->createDatabase()', function () {
        it('should delegate to the schema tool to create the entity manager\'s database', function () {
            $metaDataFactory = $this->prophet->prophesize('Doctrine\Common\Persistence\Mapping\ClassMetadataFactory');
            $metaDataFactory->getAllMetadata()->willReturn([]);
            $this->entityManager->getMetadataFactory()->willReturn($metaDataFactory->reveal());

            $schemaTool = $this->prophet->prophesize('Doctrine\ORM\Tools\SchemaTool');
            $this->schemaService->setSchemaTool($schemaTool->reveal())->createDatabase();

            $schemaTool->createSchema([])->shouldHaveBeenCalled();
        });
    });

    describe('->dropDatabase()', function () {
        it('should delegate to the schema tool to drop the database', function () {
            $schemaTool = $this->prophet->prophesize('Doctrine\ORM\Tools\SchemaTool');
            $this->schemaService->setSchemaTool($schemaTool->reveal())->dropDatabase();
            $schemaTool->dropDatabase()->shouldHaveBeenCalled();
        });
    });
});
