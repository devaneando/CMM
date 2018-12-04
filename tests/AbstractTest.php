<?php

namespace App\Tests;

use Cocur\Slugify\Slugify;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;
use Symfony\Bundle\FrameworkBundle\Test\TestContainer;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractTest extends WebTestCase
{
    /** TestContainer */
    private $testContainer;

    /** @var ObjectManager */
    private $testObjectManager;

    /**
     * @return TestContainer
     */
    protected function getContainer()
    {
        if (null === $this->testContainer) {
            self::bootKernel();
            $this->testContainer = self::$container;
        }

        return $this->testContainer;
    }

    /**
     * @return ObjectManager
     */
    protected function getObjectManager()
    {
        if (null === $this->testObjectManager) {
            $this->testObjectManager = $this->getContainer()->get('Doctrine\Common\Persistence\ObjectManager');
        }

        return $this->testObjectManager;
    }

    /**
     * @param string $entityClass
     *
     * @return ServiceEntityRepository
     */
    protected function getRepository(string $entityClass)
    {
        return $this
            ->getContainer()
            ->get('doctrine')
            ->getManager()
            ->getRepository($entityClass);
    }

    /**
     * @param string $locale
     *
     * @return FakerFactory
     */
    protected function getFaker(string $locale = 'pt_BR')
    {
        return FakerFactory::create($locale);
    }

    /**
     * @return Slugify
     */
    protected function getSlugifier()
    {
        return new Slugify();
    }
}
