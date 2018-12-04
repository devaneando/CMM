<?php

namespace App\DataFixtures;

use App\DataFixtures\AbstractDataFixture;
use App\Entity\Group;
use Doctrine\Common\Persistence\ObjectManager;

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
        $data = $this->loadData('groups.yaml');
        $this->setData($data);

        foreach ($this->getData() as $item) {
            $group = new Group(
                $item['name'],
                $item['roles']
            );
            $manager->persist($group);
            $manager->flush();
            $this->setReference('group_'.$group->getSlug(), $group);
            $this->stepIt();
        }
    }
}
