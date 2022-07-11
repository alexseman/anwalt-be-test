<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use App\Shared\Traits\ValidatorTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="todos", uniqueConstraints={
  *      @ORM\UniqueConstraint(
  *          name="title_user_idx",
  *          columns={"title", "user_id"}
  *      )
  * })
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class Todo
{
    use ValidatorTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length="255")
     */
    private string $title;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="datetime", name="due_on")
     */
    private DateTime $dueOn;

    /**
     * @Assert\Choice(callback={"App\Shared\Enum\TodoStatus", "choices"})
     * @ORM\Column(name="status")
     */
    private string $status;

    /**
     * @Assert\NotBlank()
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="todos")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private User $user;

    public function __construct(string $title, DateTime $dueOn, string $status, User $user)
    {
        $this->title  = $title;
        $this->dueOn  = $dueOn;
        $this->status = $status;
        $this->user   = $user;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return DateTime
     */
    public function getDueOn(): DateTime
    {
        return $this->dueOn;
    }

    /**
     * @param DateTime $dueOn
     */
    public function setDueOn(DateTime $dueOn): void
    {
        $this->dueOn = $dueOn;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

}
