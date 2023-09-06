<?php

declare(strict_types=1);

namespace App\Service;

use App\Enum\BodyType;
use App\Enum\Gender;

class WeightCalculationService implements WeightCalculationServiceInterface
{
    public function calculateIdealWeight(int $height, int $age, BodyType $bodyType): float
    {
        return (($height - 100) + ($age / 10)) * $bodyType->define();
    }

    public function decreaseCalories(int $calories, int $alreadyEaten): int
    {
        return $calories - $alreadyEaten;
    }

    public function calculateDailyCalories(float $weight, Gender $gender): float
    {
        return match ($gender){
            Gender::FEMALE => $weight * 24,
            Gender::MALE => 1.1 * $weight * 24,
        };
    }
}
