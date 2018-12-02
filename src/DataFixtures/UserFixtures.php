<?php

namespace App\DataFixtures;

use App\DataFixtures\AbstractDataFixture;
use App\Entity\Group;
use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Doctrine\UserManager;

class UserFixtures extends AbstractDataFixture
{
    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 2;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $data = $this->loadData('users.yaml');
        $this->setData($data);

        /** @var UserManager $userManager */
        $userManager = $this->getContainer()->get('fos_user.user_manager');

        foreach ($this->getData() as $item) {
            /** @var User $user */
            $user = $userManager->createUser();
            $user
                ->setUsername($item['username'])
                ->setEmail($item['email'])
                ->setPlainPassword($item['password'])
                ->setName($item['name']);
            if (true === $item['superadmin']) {
                $user->setSuperAdmin($item['superadmin']);
            }
            if (false === empty($item['roles'])) {
                $user->setRoles($item['roles']);
            }
            foreach ($item['groups'] as $groupName) {
                /** @var Group $group */
                $group = $this->getReference('group_'.$groupName);
                $user->addGroup($group);
            }

            $manager->persist($user);
            $manager->flush();
            $this->setReference('user_'.$user->getSlug(), $user);
            $this->stepIt();
        }
    }
}
