<?php

namespace Peridot\Plugin\Doctrine;

use Doctrine\ORM\Tools\SchemaTool;

/**
 * Class SchemaManager
 * @package Peridot\Plugin\Doctrine
 */
class SchemaManager
{
    /**
     * @var SchemaTool
     */
    private $schemaTool;

    /**
     * @param SchemaTool $schemaTool
     */
    public function __construct(SchemaTool $schemaTool)
    {
        $this->schemaTool = $schemaTool;
    }

    /**
     * Create the schema.
     */
    public function createSchema()
    {
        $classMetadataFactory = $this->schemaTool->getMetadataFactory();
        $classMetadata = $classMetadataFactory->getAllMetadata();

        $this->dropSchema();
        $this->schemaTool->createSchema($classMetadata);
    }

    /**
     * Drop the schema.
     */
    public function dropSchema()
    {
        $this->schemaTool->dropDatabase();
    }
}
