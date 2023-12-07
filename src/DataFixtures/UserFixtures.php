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
        $users = [
            [
                'name' => 'Max Mustermann',
                'email' => 'user@stayfit.test',
                'password' => 'login',
                'age' => 32,
                'gender' => GenderEnum::MALE,
                'height' => 178,
                'weight' => 95,
                'bodyType' => BodyTypeEnum::STRONG,
            ],
            [
                'name' => 'Kalle Dude',
                'email' => 'admin@stayfit.test',
                'password' => 'login',
                'age' => 24,
                'gender' => GenderEnum::MALE,
                'height' => 185,
                'weight' => 80,
                'bodyType' => BodyTypeEnum::NORMAL,
            ],
        ];

        foreach ($users as $userData) {
            $user = new User();
            $user->setName($userData['name']);
            $user->setEmail($userData['email']);
            $user->setPassword($this->passwordHasher->hashPassword($user, $userData['password']));
            $user->setAge($userData['age']);
            $user->setGender($userData['gender']);
            $user->setHeight($userData['height']);
            $user->setWeight($userData['weight']);
            $user->setBodyType($userData['bodyType']);
            $manager->persist($user);
        }

        $manager->flush();

        $this->setReference(self::TEST_USER_REFERENCE, $user);
    }
}
