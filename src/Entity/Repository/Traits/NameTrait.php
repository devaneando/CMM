<?php

namespace App\Entity\Repository\Traits;

use Doctrine\Common\Collections\ArrayCollection;

trait NameTrait
{
    /**
     * Find all enabled objects.
     *
     * @return ArrayCollection|null
     */
    public function findAllEnabled()
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder
            ->select('n')
            ->from($this->_entityName, 'n')
            ->where(
                $queryBuilder->expr()->andX(
                    $queryBuilder->expr()->eq('n.enabled', 1)
                )
            )
            ->orderBy('name', 'ASC');
        $query = $queryBuilder->getQuery();
        $nameItems = $query->getResult();
        if (true === empty($nameItems)) {
            return new ArrayCollection();
        }

        return new ArrayCollection($nameItems);
    }

    /**
     * Find objects by name.
     *
     * @param string $name
     *
     * @return object|null
     */
    public function findByName(string $name)
    {
        return $this->findBy(['name', trim($name)]);
    }

    /**
     * Find the first enabled object with a given name.
     *
     * @param string $name
     *
     * @return object|null
     */
    public function findOneByName(string $name)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder
            ->select('n')
            ->from($this->_entityName, 'n')
            ->where(
                $queryBuilder->expr()->andX(
                    $queryBuilder->expr()->eq('n.enabled', 1),
                    $queryBuilder->expr()->eq('n.name', ':name')
                )
            )
            ->orderBy('n.name', 'ASC');
        $query = $queryBuilder->getQuery();
        $query->setParameter('name', trim($name));
        $nameItems = $query->getResult();
        if (true === empty($nameItems)) {
            return null;
        }

        return $nameItems[0];
    }

    /**
     * Find enabled objects that contain name.
     *
     * @param string $name
     *
     * @return ArrayCollection
     */
    public function findLikeName(string $name)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder
            ->select('n')
            ->from($this->_entityName, 'n')
            ->where(
                $queryBuilder->expr()->andX(
                    $queryBuilder->expr()->eq('n.enabled', 1),
                    $queryBuilder->expr()->like('n.name', ':name')
                )
            )
            ->orderBy('n.name', 'ASC');
        $query = $queryBuilder->getQuery();
        $query->setParameter('name', '%'.trim($name).'%');
        $nameItems = $query->getResult();
        if (true === empty($nameItems)) {
            return new ArrayCollection();
        }

        return new ArrayCollection($nameItems);
    }
}
