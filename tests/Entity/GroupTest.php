<?php

namespace App\Tests\Entity;

use App\Entity\Group;
use App\Entity\Repository\GroupRepository;
use App\Exception\Entity\UnexistentSlug;
use App\Tests\AbstractTest;
use FOS\UserBundle\Doctrine\UserManager;

class GroupTest extends AbstractTest
{
    public function testSlugTrait()
    {
        $date = new \DateTime();
        $name = $this->getFaker()->company.' '.$this->getFaker()->companySuffix;
        $slug = $this->getSlugifier()->slugify($name);

        $group = new Group($name, ['ROLE_USER']);

        $this->getObjectManager()->persist($group);
        $this->getObjectManager()->flush();

        $this->assertEquals($slug, $group->getSlug());
        $this->assertGreaterThanOrEqual($date, $group->createdAt);
        $this->assertTrue($group->isEnabled());
    }

    public function testSlugRepositoryTrait()
    {
        $date = new \DateTime();
        $company = $this->getFaker()->company;
        $name = $company.' '.$this->getFaker()->companySuffix;
        $slug = $this->getSlugifier()->slugify($name);

        $group = new Group($name, ['ROLE_USER']);

        $this->getObjectManager()->persist($group);
        $this->getObjectManager()->flush();

        /** @var GroupRepository $groupRepository */
        $groupRepository = $this->getRepository(Group::class);

        try {
            $groupRepository->getOneBySlug('doobaadoo');
        } catch (\Exception $ex) {
            $this->assertEquals(UnexistentSlug::class, get_class($ex));
        }

        /** @var Group $slugGroup */
        $slugGroup = $groupRepository->getOneBySlug($slug);
        $this->assertEquals($name, $slugGroup->getName());

        /** @var Group $slugGroup */
        $slugGroup = $groupRepository->findOneBySlug($slug);
        $this->assertNotEmpty($slugGroup);
        $this->assertEquals($name, $slugGroup->getName());

        /** @var Group $nameGroup */
        $nameGroup = $groupRepository->findOneByName($name);
        $this->assertNotEmpty($nameGroup);
        $this->assertEquals($name, $nameGroup->getName());

        /** @var Group $nameGroup */
        $nameGroup = $groupRepository->findLikeName($company);
        $this->assertNotEmpty($nameGroup);
        $this->assertEquals($name, $nameGroup->first()->getName());
    }
}
