<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    const REF_CATEGORY_FOOD = 'REF_CATEGORY_FOOD';
    const REF_CATEGORY_BILLS = 'REF_CATEGORY_BILLS';
    const REF_CATEGORY_CHEMISTRY = 'REF_CATEGORY_CHEMISTRY';

    public function load(ObjectManager $manager)
    {
        $categoryFood = (new Category())
            ->setName('Food');
        $manager->persist($categoryFood);
        $this->addReference(self::REF_CATEGORY_FOOD, $categoryFood);

        $categoryBills = (new Category())
            ->setName('Bills');
        $manager->persist($categoryBills);
        $this->addReference(self::REF_CATEGORY_BILLS, $categoryBills);

        $categoryChemistry = (new Category())
            ->setName('Chemistry');
        $manager->persist($categoryChemistry);
        $this->addReference(self::REF_CATEGORY_CHEMISTRY, $categoryChemistry);

        $manager->flush();
    }
}
