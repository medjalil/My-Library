<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;

class UserFixture extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setFullName($faker->name);
            $user->setUsername($faker->firstNameMale);
            $user->setPassword($this->passwordEncoder->encodePassword($user, 'password'));
            $user->setEmail('user'.$i.'@test.com');
            $user->setRoles(array('ROLE_USER'));
            $manager->persist($user);
        }

        $manager->flush();
    }

}
