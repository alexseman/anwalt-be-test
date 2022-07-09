<?php

namespace App\Entity;

use App\Shared\Traits\ValidatorTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="posts", uniqueConstraints={
 *      @ORM\UniqueConstraint(
 *          name="title_user_idx",
 *          columns={"title", "user_id"}
 *      )
 * })
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class Post
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
     * @ORM\Column(type="text")
     */
    private string $body;

    /**
     * @Assert\NotBlank()
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="posts")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private User $user;

    public function __construct(string $title, string $body, User $user)
    {
        $this->title = $title;
        $this->body  = $body;
        $this->user  = $user;
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
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
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
