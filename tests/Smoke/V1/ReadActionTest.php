<?php

declare(strict_types=1);

namespace App\Tests\Smoke\V1;

use App\Http\V1\Action\AbstractAction;
use App\Http\V1\Action\Post\Read\ReadAction;
//use App\Tests\Smoke\AbstractActionTest;
use App\Tests\Smoke\Traits\PostCreatorTrait;
use App\Tests\Smoke\Traits\UserCreatorTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;

//class ReadActionTest extends AbstractActionTest
class ReadActionTest extends KernelTestCase
{
    use UserCreatorTrait;
    use PostCreatorTrait;

    private ReadAction $action;
    private EntityManager $entityManager;

    protected function setUp(): void
    {
//        $kernel = self::bootKernel();
//
//        $this->entityManager = $kernel->getContainer()
//            ->get('doctrine')
//            ->getManager();
//
//        $this->action = $kernel->getContainer()->get(ReadAction::class);
//
//        $this->entityManager->getConnection()->ensureConnectedToPrimary();
//        $this->entityManager->beginTransaction();
//        $this->entityManager->getConnection()->setAutoCommit(false);


//        $this->init(ReadAction::class);

        static::bootKernel();

//        $action   = static::$kernel->getContainer()->get(ReadAction::class);

//        if (empty($action)) {
//            throw new \Exception(sprintf('Container failed to resolve class: %s', ReadAction::class));
//        }

//        $this->action        = $action;
        $this->entityManager = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');


//        $this->action = static::$kernel->getContainer()->get(ReadAction::class);
        $this->action = static::$kernel->getContainer()->get(ReadAction::class);
//        $this->entityManager = static::$kernel
//            ->getContainer()
//            ->get('doctrine')
//            ->getManager();


//        var_dump(get_class($this->entityManager));
//        var_dump(get_class($this->action));
//        die();

        $this->entityManager->getConnection()->ensureConnectedToPrimary();
        $this->entityManager->beginTransaction();
        $this->entityManager->getConnection()->setAutoCommit(false);
    }


//    protected static function bootKernel(array $options = [])
//    {
//        static::ensureKernelShutdown();
//
//        static::$kernel = static::createKernel($options);
//        static::$kernel->boot();
//        static::$booted = true;
//
//        $container = static::$kernel->getContainer();
//
//        var_dump(get_class($container));
//        static::$container = $container->has('test.service_container') ? $container->get('test.service_container') : $container;
//
//        return static::$kernel;
//    }

    public function testSuccess()
    {
        $userId = 25;
        $user = $this->createUser($userId);
        $this->entityManager->persist($user);
        $post = $this->createPost('Post title', 'Post body', $user);
        $this->entityManager->persist($post);

        $this->entityManager->flush();

        $request = new Request(['id'    => (string) $post->getId()]);

        /** @var JsonResponse */
        $apiResponse = $this->action->__invoke($request);

        $content = json_decode($apiResponse->getContent(), true);

        $this->assertEquals(200, $apiResponse->getStatusCode());
        $this->assertEquals(true, $content['success']);
        $this->assertArrayHasKey('items', $content['data']);
        $this->assertNotEmpty($content['data']['post']['id']);
        $this->assertNotEmpty($content['data']['post']['userId']);
        $this->assertNotEmpty($content['data']['post']['title']);
        $this->assertNotEmpty($content['data']['post']['body']);
    }
}
