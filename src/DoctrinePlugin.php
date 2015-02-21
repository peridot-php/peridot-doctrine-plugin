<?php

namespace Peridot\Plugin\Doctrine;

use Doctrine\Common\Persistence\Mapping\Driver\MappingDriver;
use Doctrine\ORM\Mapping\Driver\SimplifiedYamlDriver;
use Doctrine\ORM\Tools\SchemaTool;
use Evenement\EventEmitterInterface;
use Peridot\Core\Suite;

/**
 * Class DoctrinePlugin
 * @package Peridot\Plugin\Doctrine
 */
class DoctrinePlugin
{
    /**
     * @var EventEmitterInterface
     */
    private $emitter;

    /**
     * @var MappingDriver
     */
    private $driver;

    /**
     * @var array
     */
    private $connectionInfo;

    /**
     * @param EventEmitterInterface $emitter
     * @param MappingDriver $driver
     * @param array $connInfo
     */
    public function __construct(EventEmitterInterface $emitter, MappingDriver $driver, array $connInfo = [])
    {
        $this->emitter = $emitter;
        $this->driver = $driver;
        $this->connectionInfo = $connInfo;

        $this->listen();
    }

    /**
     * @param Suite $suite
     */
    public function onSuiteStart(Suite $suite)
    {
        $suite->getScope()->peridotAddChildScope(
            new DoctrineScope(
                $this,
                new EntityManagerFactory(),
                new SchemaManager()
            )
        );
    }

    /**
     * @return MappingDriver
     */
    public function getMappingDriver()
    {
        return $this->driver;
    }

    /**
     * @return array
     */
    public function getConnectionInfo()
    {
        return $this->connectionInfo;
    }

    private function listen()
    {
        $this->emitter->on('suite.start', [$this, 'onSuiteStart']);
    }
}
