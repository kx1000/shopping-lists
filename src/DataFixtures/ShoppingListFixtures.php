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

        $shoppingList1 = (new ShoppingList($user1))
            ->setOwner($user1)
            ->setPrice(100.00)
            ->setCreatedAt(new \DateTime('2021-05-28'));
        $manager->persist($shoppingList1);

        $shoppingList2 = (new ShoppingList($user1))
            ->setOwner($user1)
            ->setPrice(100.00)
            ->setCreatedAt(new \DateTime('2021-05-18'));
        $manager->persist($shoppingList2);

        $shoppingList3 = (new ShoppingList($user1))
            ->setOwner($user1)
            ->setPrice(100.00)
            ->setCreatedAt(new \DateTime('2021-04-28'));
        $manager->persist($shoppingList3);

        $shoppingList4 = (new ShoppingList($user1))
            ->setOwner($user1)
            ->setPrice(100.00)
            ->setCreatedAt(new \DateTime('2021-03-28'));
        $manager->persist($shoppingList4);

        $shoppingList5 = (new ShoppingList($user2))
            ->setOwner($user2)
            ->setPrice(100.00)
            ->setCreatedAt(new \DateTime('2021-05-28'));
        $manager->persist($shoppingList5);

        $shoppingList6 = (new ShoppingList($user2))
            ->setOwner($user2)
            ->setPrice(100.00)
            ->setCreatedAt(new \DateTime('2021-05-18'));
        $manager->persist($shoppingList6);

        // missing april :)

        $shoppingList7 = (new ShoppingList($user2))
            ->setOwner($user2)
            ->setPrice(100.00)
            ->setCreatedAt(new \DateTime('2021-03-28'));
        $manager->persist($shoppingList7);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
