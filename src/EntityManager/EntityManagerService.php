<?php

namespace Peridot\Plugin\Doctrine\EntityManager;

use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Persistence\Mapping\Driver\MappingDriver;
use Doctrine\ORM\EntityManager as DoctrineEntityManager;
use Doctrine\ORM\Tools\Setup;
use Evenement\EventEmitterInterface;

/**
 * Class EntityManagerService
 * @package Peridot\Plugin\Doctrine\EntityManager
 */
class EntityManagerService
{
    /**
     * @var \Doctrine\Common\Cache\Cache|null
     */
    protected $cache = null;

    /**
     * @var array
     */
    protected $dbParams = ['driver' => 'pdo_sqlite', 'memory' => true];

    /**
     * @var callable
     */
    protected $entityManagerFactory;

    /**
     * @var \Evenement\EventEmitterInterface
     */
    protected $eventEmitter;

    /**
     * @var boolean
     */
    protected $isDevMode = true;

    /**
     * @var \Doctrine\Common\Persistence\Mapping\Driver\MappingDriver
     */
    protected $mappingDriver;

    /**
     * @var string|null
     */
    protected $proxyDir = null;

    /**
     * @return DoctrineEntityManager
     * @throws \Doctrine\ORM\ORMException
     */
    public function createEntityManager()
    {
        $this->eventEmitter->emit('doctrine.entityManager.preCreate', []);
        $entityManager = $this->buildEntityManager();
        $this->eventEmitter->emit('doctrine.entityManager.postCreate', [$entityManager]);

        return $entityManager;
    }

    /**
     * @param Cache|null $cache
     * @return $this
     */
    public function setCache(Cache $cache = null)
    {
        $this->cache = $cache;
        return $this;
    }

    /**
     * @param array $dbParams
     * @return $this
     */
    public function setDbParams(array $dbParams)
    {
        $this->dbParams = $dbParams;
        return $this;
    }

    /**
     * @param EventEmitterInterface $eventEmitter
     * @return $this
     */
    public function setEventEmitter(EventEmitterInterface $eventEmitter)
    {
        $this->eventEmitter = $eventEmitter;
        return $this;
    }

    /**
     * @param callable $entityManagerFactory
     * @return $this
     */
    public function setEntityManagerFactory(callable $entityManagerFactory)
    {
        $this->entityManagerFactory = $entityManagerFactory;
        return $this;
    }

    /**
     * @param boolean $isDevMode
     * @return $this
     */
    public function setIsDevMode($isDevMode)
    {
        $this->isDevMode = (bool) $isDevMode;
        return $this;
    }

    /**
     * @param MappingDriver $mappingDriver
     * @return $this
     */
    public function setMappingDriver(MappingDriver $mappingDriver)
    {
        $this->mappingDriver = $mappingDriver;
        return $this;
    }

    /**
     * @param string|null $proxyDir
     * @return $this
     */
    public function setProxyDir($proxyDir)
    {
        $this->proxyDir = $proxyDir;
        return $this;
    }



    /**
     * @return DoctrineEntityManager
     * @throws \Doctrine\ORM\ORMException
     */
    protected function buildEntityManager()
    {
        if ($this->entityManagerFactory) {
            return call_user_func($this->entityManagerFactory);
        }

        $configuration = Setup::createConfiguration($this->isDevMode, $this->proxyDir, $this->cache);
        $configuration->setMetadataDriverImpl($this->mappingDriver);
        return DoctrineEntityManager::create($this->dbParams, $configuration);
    }
}
