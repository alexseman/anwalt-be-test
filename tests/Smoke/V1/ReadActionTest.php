<?php

declare(strict_types=1);

namespace App\Tests\Smoke\V1;

use App\Http\V1\Action\Post\Read\ReadAction;
use App\Tests\Smoke\AbstractActionTest;
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
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->action = $kernel->getContainer()->get(ReadAction::class);

        $this->entityManager->getConnection()->ensureConnectedToPrimary();
        $this->entityManager->beginTransaction();
        $this->entityManager->getConnection()->setAutoCommit(false);
    }

    public function testSuccess()
    {
        $userId = 25;
        $user   = $this->createUser($userId);
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
