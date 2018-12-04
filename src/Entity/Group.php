<?php

namespace App\Entity;

use App\Entity\Group;
use App\Entity\Traits\CreatedTrait;
use App\Entity\Traits\SlugTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\Group as FosGroup;

/**
 * @ORM\Entity(repositoryClass="App\Entity\Repository\GroupRepository")
 * @ORM\Table(name="groups")
 * @ORM\HasLifecycleCallbacks()
 */
class Group extends FosGroup
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="groups", cascade="all")
     * @ORM\JoinTable(name="users_groups",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $users;

    use SlugTrait;
    use CreatedTrait;

    /**
     * @param string $name
     * @param array  $roles
     */
    public function __construct($name, $roles = [])
    {
        parent::__construct($name, $roles);
    }
}
