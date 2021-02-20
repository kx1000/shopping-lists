<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
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

        $user2 = (new User())
            ->setEmail('karolinagusciora99@wp.pl');
        $user2->setPassword($this->encoder->encodePassword($user2, 'test123'));
        $manager->persist($user2);
        $manager->flush();
    }
}
