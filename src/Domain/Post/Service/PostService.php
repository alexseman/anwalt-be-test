<?php

declare(strict_types=1);

namespace App\Domain\Post\Service;

use App\Domain\Post\Service\Dto\ByUserPost;
use App\Domain\Post\Service\Dto\ByUserTodo;
use App\Domain\Post\Service\Dto\ByUserResponse;
use App\Domain\Post\Service\Dto\CreatePost;
use App\Domain\Post\Service\Dto\CreateUpdateResponse;
use App\Domain\Post\Service\Dto\DeletePost;
use App\Domain\Post\Service\Dto\DeleteResponse;
use App\Domain\Post\Service\Dto\ReadPost;
use App\Domain\Post\Service\Dto\ReadResponse;
use App\Domain\Post\Service\Dto\UpdatePost;
use App\Entity\Post;
use App\Shared\Exception\ValidationException;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Post\Repository\PostRepository;
use App\Domain\User\Repository\UserRepository;
use Elastica\Query\BoolQuery;
use Elastica\Query\MatchQuery;
use FOS\ElasticaBundle\Finder\TransformedFinder;

class PostService
{

    private EntityManagerInterface $entityManager;
    private UserRepository $userRepository;
    private PostRepository $postRepository;
    private TransformedFinder $postFinder;

    /**
     * @param EntityManagerInterface   $entityManager
     * @param UserRepository           $userRepository
     * @param PostRepository           $postRepository
     * @param TransformedFinder $postFinder
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        UserRepository $userRepository,
        PostRepository $postRepository,
        TransformedFinder $postFinder
    ) {
        $this->entityManager  = $entityManager;
        $this->userRepository = $userRepository;
        $this->postRepository = $postRepository;
        $this->postFinder     = $postFinder;
    }

    /**
     * @param CreatePost $createPost
     *
     * @return CreateUpdateResponse
     * @throws ValidationException
     */
    public function create(CreatePost $createPost): CreateUpdateResponse
    {
        $this->checkUniqueUserPostTitle($createPost);
        $user = $this->userRepository->findOrCreateUser($createPost->getUserId());

        $post = new Post(
            $createPost->getTitle(),
            $createPost->getBody(),
            $user
        );

        $this->entityManager->persist($post);
        $this->entityManager->flush();

        return new CreateUpdateResponse($post->getId());
    }

    /**
     * @param UpdatePost $updatePost
     *
     * @return CreateUpdateResponse
     * @throws ValidationException
     */
    public function update(UpdatePost $updatePost): CreateUpdateResponse
    {
        $post = $this->findPostOrFailWithMessage($updatePost->getId(), 'Nonexistent post with given id');

        $post->setBody($updatePost->getBody());
        $post->setTitle($updatePost->getTitle());

        $this->entityManager->persist($post);
        $this->entityManager->flush();

        return new CreateUpdateResponse($post->getId());
    }

    /**
     * @param DeletePost $deletePost
     *
     * @return DeleteResponse
     * @throws ValidationException
     */
    public function delete(DeletePost $deletePost): DeleteResponse
    {
        $this->findPostOrFailWithMessage($deletePost->getId(), 'Nonexistent post marked for deletion');
        return new DeleteResponse($this->postRepository->deleteById($deletePost->getId()));
    }

    /**
     * @param ReadPost $readPost
     *
     * @return ReadResponse
     * @throws ValidationException
     */
    public function read(ReadPost $readPost): ReadResponse
    {
        $post = $this->findPostOrFailWithMessage($readPost->getId());
        return new ReadResponse($post);
    }

    /**
     * @param ByUserPost $byUserPost
     *
     * @return ByUserResponse
     */
    public function byUser(ByUserPost $byUserPost): ByUserResponse
    {
        $boolQuery = new BoolQuery();

        $userQuery = new MatchQuery();
        $userQuery->setFieldQuery('user.id', $byUserPost->getUserId());
        $boolQuery->addFilter($userQuery);

        if (null !== $byUserPost->getTitle()) {
            $titleQuery = new MatchQuery();
            $titleQuery->setFieldQuery('title', $byUserPost->getTitle());
            $boolQuery->addShould($titleQuery);
        }

        if (null !== $byUserPost->getBody()) {
            $bodyQuery = new MatchQuery();
            $bodyQuery->setFieldQuery('body', $byUserPost->getBody());
            $boolQuery->addShould($bodyQuery);
        }

        $posts = $this->postFinder->findPaginated($boolQuery);
        $posts->setMaxPerPage($byUserPost->getPerPage());
        $posts->setCurrentPage($byUserPost->getCurrentPage());

        return new ByUserResponse($posts);
    }

    /**
     * @throws ValidationException
     */
    private function checkUniqueUserPostTitle(CreatePost $createPost): void
    {
        $post = $this->postRepository->findOneByUserAndTitle(
            $createPost->getTitle(),
            $createPost->getUserId()
        );

        if ($post) {
            throw new ValidationException('User already has a post with the given title');
        }
    }

    /**
     * @param int         $id
     * @param string|null $message
     *
     * @return Post
     * @throws ValidationException
     */
    private function findPostOrFailWithMessage(int $id, string $message = null): Post
    {
        $post = $this->findPost($id);

        if (! $post) {
            if (! $message) {
                $message = sprintf('Failed to find post with id %d', $id);
            }

            throw new ValidationException($message);
        }

        return $post;
    }

    /**
     * @param int $postId
     *
     * @return Post|null
     */
    private function findPost(int $postId): ?Post
    {
        return $this->postRepository->findOneBy(['id' => $postId]);
    }
}
