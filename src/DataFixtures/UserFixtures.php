<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Enum\BodyTypeEnum;
use App\Enum\GenderEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{

    public const TEST_USER_REFERENCE = 'test-user';

    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
    )
    {
    }


    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('test@test.de');
        $user->setPassword($this->passwordHasher->hashPassword($user, 'test'));
        $user->setAge(24);
        $user->setGender(GenderEnum::MALE);
        $user->setHeight(185);
        $user->setBodyType(BodyTypeEnum::NORMAL);
        $user->setName('Kalle Dude');

        $manager->persist($user);
        $manager->flush();

        $this->setReference(self::TEST_USER_REFERENCE, $user);
    }
}
