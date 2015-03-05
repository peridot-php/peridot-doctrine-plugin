<?php

namespace Peridot\Plugin\Doctrine\EntityManager;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;

/**
 * Class SchemaService
 * @package Peridot\Plugin\Doctrine\EntityManager
 */
class SchemaService
{
    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var \Doctrine\ORM\Tools\SchemaTool
     */
    protected $schemaTool;

    /**
     * Constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->schemaTool = new SchemaTool($this->entityManager);
    }

    /**
     * Create a database for the composed entity manager.
     *
     * @return $this
     * @throws \Doctrine\ORM\Tools\ToolsException
     */
    public function createDatabase()
    {
        $this->schemaTool->createSchema($this->entityManager->getMetadataFactory()->getAllMetadata());
        return $this;
    }

    /**
     * Drop the database for the composed entity manager.
     *
     * @return $this
     */
    public function dropDatabase()
    {
        $this->schemaTool->dropDatabase();
        return $this;
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @return $this
     */
    public function setEntityManager(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    /**
     * @return SchemaTool
     */
    public function getSchemaTool()
    {
        return $this->schemaTool;
    }

    /**
     * @param SchemaTool $schemaTool
     * @return $this
     */
    public function setSchemaTool(SchemaTool $schemaTool)
    {
        $this->schemaTool = $schemaTool;
        return $this;
    }
}
