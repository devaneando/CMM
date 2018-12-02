<?php

namespace App\Entity\Repository;

use App\Entity\Group;
use App\Entity\Repository\Traits\NameTrait;
use App\Entity\Repository\Traits\SlugTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Group|null find($id, $lockMode = null, $lockVersion = null)
 * @method Group|null findOneBy(array $criteria, array $orderBy = null)
 * @method Group[]    findAll()
 * @method Group[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupRepository extends ServiceEntityRepository
{
    use NameTrait;
    use SlugTrait;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Group::class);
    }
}
