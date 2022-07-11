<?php

namespace App\Tests\Smoke;

use App\Http\V1\Action\AbstractAction;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class AbstractActionTest extends KernelTestCase
{

    protected AbstractAction $action;
    protected ?EntityManager $entityManager;

    protected function init(string $classFQN): void
    {
        static::bootKernel();

        $action   = static::$kernel->getContainer()->get($classFQN);

        if (empty($action)) {
            throw new \Exception(sprintf('Container failed to resolve class: %s', $classFQN));
        }

        $this->action        = $action;
        $this->entityManager = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');

        $this->entityManager->getConnection()->ensureConnectedToPrimary();
        $this->entityManager->beginTransaction();
        $this->entityManager->getConnection()->setAutoCommit(false);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->actoion = null;
    }
}
