<?php

namespace App\DataFixtures;

use App\DataFixtures\AbstractDataFixture;
use App\Entity\Group;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Doctrine\UserManager;

class GroupFixtures extends AbstractDataFixture
{
    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 1;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->setData($this->loadData('groups.yaml'));

        foreach ($this->data as $item) {
            $group = new Group(
                $item['name'],
                $item['roles']
            );
            $manager->persist($group);
            $manager->flush();
            $this->stepIt();
        }
    }
}
