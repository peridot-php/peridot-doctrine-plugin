<?php

namespace Peridot\Plugin\Doctrine;

use Evenement\EventEmitterInterface;
use Peridot\Core\Suite;
use Peridot\Plugin\Doctrine\EntityManager\EntityManagerService;

/**
 * Class DoctrinePlugin
 * @package Peridot\Plugin\Doctrine
 */
class DoctrinePlugin
{
    /**
     * @var \Evenement\EventEmitterInterface
     */
    protected $eventEmitter;

    /**
     * @var \Peridot\Plugin\Doctrine\DoctrineScope
     */
    protected $scope;

    /**
     * Constructor.
     *
     * @param EventEmitterInterface $eventEmitter
     * @param EntityManagerService $entityManagerService
     */
    public function __construct(EventEmitterInterface $eventEmitter, EntityManagerService $entityManagerService)
    {
        $this->eventEmitter = $eventEmitter;
        $this->scope = new DoctrineScope($entityManagerService->setEventEmitter($this->eventEmitter));
        $this->listen();
    }

    /**
     * @param Suite $suite
     */
    public function onSuiteStart(Suite $suite)
    {
        $suite->getScope()->peridotAddChildScope($this->scope);
    }

    /**
     * Listen for Peridot events.
     */
    private function listen()
    {
        $this->eventEmitter->on('suite.start', [$this, 'onSuiteStart']);
    }
}
