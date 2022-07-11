<?php

declare(strict_types=1);

namespace App\Domain\Todo\Service;

use App\Domain\Todo\Service\Dto\CreateTodo;
use App\Domain\Todo\Service\Dto\CreateUpdateResponse;
use App\Domain\Todo\Service\Dto\DeleteTodo;
use App\Domain\Todo\Service\Dto\DeleteResponse;
use App\Domain\Todo\Service\Dto\ReadTodo;
use App\Domain\Todo\Service\Dto\ReadResponse;
use App\Domain\Todo\Service\Dto\UpdateTodo;
use App\Entity\Todo;
use App\Shared\Exception\ValidationException;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Todo\Repository\TodoRepository;
use App\Domain\User\Repository\UserRepository;

class TodoService
{

    private EntityManagerInterface $entityManager;
    private UserRepository $userRepository;
    private TodoRepository $todoRepository;

    /**
     * @param EntityManagerInterface $entityManager
     * @param UserRepository         $userRepository
     * @param TodoRepository         $todoRepository
     */
    public function __construct(
      EntityManagerInterface $entityManager,
      UserRepository $userRepository,
      TodoRepository $todoRepository
    ) {
        $this->entityManager  = $entityManager;
        $this->userRepository = $userRepository;
        $this->todoRepository = $todoRepository;
    }

    /**
     * @param CreateTodo $createTodo
     *
     * @return CreateUpdateResponse
     * @throws ValidationException
     */
    public function create(CreateTodo $createTodo): CreateUpdateResponse
    {
        $this->checkUniqueUserTodoTitle($createTodo);
        $user = $this->userRepository->findOrCreateUser($createTodo->getUserId());

        $todo = new Todo(
            $createTodo->getTitle(),
            new DateTime($createTodo->getDueOn()),
            $createTodo->getStatus(),
            $user
        );

        $this->entityManager->persist($todo);
        $this->entityManager->flush();

        return new CreateUpdateResponse($todo->getId());
    }

    /**
     * @param UpdateTodo $updateTodo
     *
     * @return CreateUpdateResponse
     * @throws ValidationException
     */
    public function update(UpdateTodo $updateTodo): CreateUpdateResponse
    {
        $todo = $this->findTodoOrFailWithMessage($updateTodo->getId(), 'Nonexistent todo with given id');

        $todo->setTitle($updateTodo->getTitle());
        $todo->setDueOn(new DateTime($updateTodo->getDueOn()));
        $todo->setStatus($updateTodo->getStatus());

        $this->entityManager->persist($todo);
        $this->entityManager->flush();

        return new CreateUpdateResponse($todo->getId());
    }

    /**
     * @param DeleteTodo $deleteTodo
     *
     * @return DeleteResponse
     * @throws ValidationException
     */
    public function delete(DeleteTodo $deleteTodo): DeleteResponse
    {
        $this->findTodoOrFailWithMessage($deleteTodo->getId(), 'Nonexistent todo marked for deletion');
        return new DeleteResponse($this->todoRepository->deleteById($deleteTodo->getId()));
    }

    /**
     * @param ReadTodo $readTodo
     *
     * @return ReadResponse
     * @throws ValidationException
     */
    public function read(ReadTodo $readTodo): ReadResponse
    {
        $todo = $this->findTodoOrFailWithMessage($readTodo->getId());
        return new ReadResponse($todo);
    }

    /**
     * @throws ValidationException
     */
    private function checkUniqueUserTodoTitle(CreateTodo $createTodo): void
    {
        $todo = $this->todoRepository->findOneByUserAndTitle(
            $createTodo->getTitle(),
            $createTodo->getUserId()
        );

        if ($todo) {
            throw new ValidationException('User already has a todo with the given title');
        }
    }

    /**
     * @param int         $id
     * @param string|null $message
     *
     * @return Todo
     * @throws ValidationException
     */
    private function findTodoOrFailWithMessage(int $id, string $message = null): Todo
    {
        $todo = $this->findTodo($id);

        if (! $todo) {
            if (! $message) {
                $message = sprintf('Failed to find todo with id %d', $id);
            }

            throw new ValidationException($message);
        }

        return $todo;
    }

    /**
     * @param int $todoId
     *
     * @return Todo|null
     */
    private function findTodo(int $todoId): ?Todo
    {
        return $this->todoRepository->findOneBy(['id' => $todoId]);
    }
}
