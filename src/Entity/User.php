<?php

namespace App\Entity;

use App\Shared\Traits\ValidatorTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="users")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class User
{
    use ValidatorTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Post", mappedBy="user")
     */
    private Collection $posts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Todo", mappedBy="user")
     */
    private Collection $todos;

    public function __construct(int $id)
    {
        $this->id    = $id;
        $this->posts = new ArrayCollection();
        $this->todos = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
