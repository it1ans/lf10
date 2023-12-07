<?php

namespace App\DataFixtures;

use App\Entity\Meal;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Asset\Packages;

class MealFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private readonly Packages $packages)
    {
    }


    public function load(ObjectManager $manager): void
    {
        $meals = [
            [
                'name' => 'Pommes',
                'calories' => 123,
                'imageFilename' => 'pommes.jpg',
                'public' => true,
            ],
            [
                'name' => 'Cola',
                'calories' => 456,
                'imageFilename' => 'cola.png',
                'public' => true,
            ],
            [
                'name' => 'Currywurst',
                'calories' => 789,
                'imageFilename' => 'currywurst.jpg',
                'public' => true,
            ],
            [
                'name' => 'Cheeseburger',
                'calories' => 1200,
                'imageFilename' => 'cheeseburger.jpg',
                'public' => false,
            ],
            [
                'name' => 'blah',
                'calories' => 1200,
                'imageFilename' => 'cheeseburger.jpg',
                'public' => false,
            ],
        ];

        $imagePath = 'build/../uploads/meals/';

        foreach ($meals as $mealData) {
            $meal = new Meal();
            $meal->setName($mealData['name']);
            $meal->setCalories($mealData['calories']);
            $meal->setImageFilename(substr($this->packages->getUrl($imagePath . $mealData['imageFilename']), strlen($imagePath) + 1));
            $meal->setPublic($mealData['public']);
            $meal->setUser($this->getReference(UserFixtures::TEST_USER_REFERENCE));

            $manager->persist($meal);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
