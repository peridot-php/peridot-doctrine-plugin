<?php

namespace Peridot\Plugin\Doctrine;

use Doctrine\Common\Persistence\Mapping\Driver\MappingDriver;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

/**
 * Class EntityManagerFactory
 * @package Peridot\Plugin\Doctrine
 */
class EntityManagerFactory
{
    public function create(MappingDriver $mappingDriver)
    {
        $dbParams = [
            'driver' => 'pdo_sqlite',
            'memory' => true,
        ];

        $configuration =  Setup::createConfiguration(true, sys_get_temp_dir() . '/' . uniqid());
        $configuration->setMetadataDriverImpl($mappingDriver);
        $em = EntityManager::create($dbParams, $configuration, null);

        return $em;
    }
}
