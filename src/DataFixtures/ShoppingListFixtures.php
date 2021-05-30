<?php

namespace App\DataFixtures;

use App\Entity\ShoppingList;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ShoppingListFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        /** @var User $user1 */
        $user1 = $this->getReference(UserFixtures::REF_USER_1);
        /** @var User $user2 */
        $user2 = $this->getReference(UserFixtures::REF_USER_2);

        $shoppingList = (new ShoppingList($user1))
            ->setOwner($user1)
            ->setPrice(100.00)
            ->setCreatedAt(new \DateTime('2021-05-28'));
        $manager->persist($shoppingList);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
