<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    const REF_USER_1 = 'REF_USER_1';
    const REF_USER_2 = 'REF_USER_2';

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user1 = (new User())
            ->setEmail('kacper.rogula@gmail.com');
        $user1->setPassword($this->encoder->encodePassword($user1, 'test123'));
        $manager->persist($user1);
        $manager->flush();
        $this->addReference(self::REF_USER_1, $user1);

        $user2 = (new User())
            ->setEmail('karolinagusciora7@gmail.com');
        $user2->setPassword($this->encoder->encodePassword($user2, 'test123'));
        $manager->persist($user2);
        $manager->flush();
        $this->addReference(self::REF_USER_2, $user2);
    }
}
