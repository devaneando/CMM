<?php

namespace App\Entity;

use App\Entity\Traits\CreatedTrait;
use App\Entity\Traits\SlugTrait;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as FosUser;

/**
 * @ORM\Entity(repositoryClass="App\Entity\Repository\UserRepository")
 * @ORM\Table(name="users")
 * @ORM\HasLifecycleCallbacks()
 */
class User extends FosUser
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Group", mappedBy="users", cascade="all")
     * @ORM\JoinTable(name="users_groups",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;

    use SlugTrait;
    use CreatedTrait;

    public function __construct()
    {
        parent::__construct();
        $this
            ->setEnabled(true)
            ->setSlug();
    }
}
