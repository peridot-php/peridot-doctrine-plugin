<?php

namespace Peridot\Plugin\Doctrine;

use Doctrine\Common\Persistence\Mapping\Driver\MappingDriver;
use Doctrine\ORM\Tools\SchemaTool;
use Nelmio\Alice\Fixtures;
use Peridot\Scope\Scope;

/**
 * Class DoctrineScope
 * @package Peridot\Plugin\Doctrine
 */
class DoctrineScope extends Scope
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * @var EntityManagerFactory
     */
    private $factory;

    /**
     * @var DoctrinePlugin
     */
    private $plugin;

    /**
     * @var SchemaManager
     */
    private $schemaManager;

    /**
     * @param DoctrinePlugin $plugin
     * @param EntityManagerFactory $factory
     * @param SchemaManager $schemaManager
     */
    public function __construct(DoctrinePlugin $plugin, EntityManagerFactory $factory/*, SchemaManager $schemaManager*/)
    {
        $this->plugin = $plugin;
        $this->factory = $factory;
        //$this->schemaManager = $schemaManager;
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        if (!$this->entityManager) {
            $this->entityManager = $this->factory->create(
                $this->plugin->getMappingDriver(),
                $this->plugin->getConnectionInfo()
            );

//            $this->schemaManager->createSchema($this->entityManager);
        }

        return $this->entityManager;
    }

//    public function rebuildSchema()
//    {
//        $entityManager = $this->getEntityManager();
//
//        $schemaTool = new SchemaTool($this->entityManager);
//
//        $classMetadataFactory = $entityManager->getMetadataFactory();
//        $classMetadata = $classMetadataFactory->getAllMetadata();
//
//        $schemaTool->dropDatabase();
//        $schemaTool->createSchema($classMetadata);
//    }
}
