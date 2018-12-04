<?php

namespace App\Entity\Repository\Traits;

use App\Exception\Entity\UnexistentSlug;
use Doctrine\Common\Collections\ArrayCollection;

trait SlugTrait
{
    /**
     * find One object, based on the slug.
     *
     * @param string $slug
     *
     * @return object|null
     */
    public function findOneBySlug(string $slug)
    {
        $slugItems = $this->findBy(['slug' => trim($slug)]);
        if (0 >= count($slugItems)) {
            return null;
        }

        return $slugItems[0];
    }

    /**
     * Get one enabled object, based on the slug, or throw an Exception if it does not exists.
     *
     * @param string $slug
     *
     * @throws UnexistentSlug
     *
     * @return object
     */
    public function getOneBySlug(string $slug)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder
            ->select('s')
            ->from($this->_entityName, 's')
            ->where(
                $queryBuilder->expr()->andX(
                    //$queryBuilder->expr()->eq('s.enabled', 1),
                    $queryBuilder->expr()->eq('s.slug', ':slug')
                )
            );
        $query = $queryBuilder->getQuery();
        $query->setParameter('slug', trim($slug));
        $slugItems = $query->getResult();
        if (true === empty($slugItems)) {
            throw new UnexistentSlug();
        }

        return $slugItems[0];
    }
}
