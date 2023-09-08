<?php

declare(strict_types=1);

namespace App\Service;

use App\Enum\BodyTypeEnum;
use App\Enum\GenderEnum;

class WeightCalculationService implements WeightCalculationServiceInterface
{
    public function calculateIdealWeight(int $height, int $age, BodyTypeEnum $bodyType): float
    {
        return (($height - 100) + ($age / 10)) * $bodyType->define();
    }

    public function decreaseCalories(int $calories, int $alreadyEaten): int
    {
        return $calories - $alreadyEaten;
    }

    public function calculateDailyCalories(float $weight, GenderEnum $gender): float
    {
        return match ($gender){
            GenderEnum::FEMALE => $weight * 24,
            GenderEnum::MALE => 1.1 * $weight * 24,
        };
    }
}
