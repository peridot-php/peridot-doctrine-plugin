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
     * @param DoctrinePlugin $plugin
     * @param EntityManagerFactory $factory
     */
    public function __construct(DoctrinePlugin $plugin, EntityManagerFactory $factory)
    {
        $this->plugin = $plugin;
        $this->factory = $factory;
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

            $this->rebuildSchema();

            $this->plugin->emit('entitymanager.created', [$this->entityManager]);
        }

        return $this->entityManager;
    }

    protected function rebuildSchema()
    {
        $entityManager = $this->getEntityManager();
        $schemaTool = new SchemaTool($entityManager);

        $classMetadataFactory = $entityManager->getMetadataFactory();
        $classMetadata = $classMetadataFactory->getAllMetadata();

        $schemaTool->dropDatabase();
        $schemaTool->createSchema($classMetadata);
    }
}
