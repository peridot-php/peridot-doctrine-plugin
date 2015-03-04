<?php

namespace Peridot\Plugin\Doctrine;

use Doctrine\ORM\EntityManager as DoctrineEntityManager;
use Peridot\Plugin\Doctrine\EntityManager\EntityManagerService;
use Peridot\Scope\Scope;

/**
 * Class DoctrineScope
 * @package Peridot\Plugin\Doctrine
 */
class DoctrineScope extends Scope
{
    /**
     * @var \Peridot\Plugin\Doctrine\EntityManager\EntityManagerService
     */
    private $entityManagerService;

    /**
     * Constructor.
     *
     * @param EntityManagerService $entityManagerService
     */
    public function __construct(EntityManagerService $entityManagerService)
    {
        $this->entityManagerService = $entityManagerService;
    }

    /**
     * @return DoctrineEntityManager
     */
    public function createEntityManager()
    {
        return $this->entityManagerService->createEntityManager();
    }
}
