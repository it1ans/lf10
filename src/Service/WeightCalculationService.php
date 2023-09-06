<?php

declare(strict_types=1);

namespace App\Service;

class WeightCalculationService implements WeightCalculationServiceInterface
{
    public function defineBodyType(string $bodyType): float
    {
        if ($bodyType === "normal") {
            $value = 0.9;
        } elseif ($bodyType === "daintily") {
            $value = 0.9 * 0.9;
        } elseif ($bodyType === "strong") {
            $value = 0.9 * 1.1;
        }

        return $value;
    }

    public function calculateIdealWeight(float $height, int $age, float $bodyType): float
    {
        $idealWeight = (($height - 100) + ($age / 10)) * $bodyType;

        return $idealWeight;
    }

    public function decreaseCalories(int $calories, int $alreadyEaten): int
    {
        $newvalue = $calories - $alreadyEaten;

        return $newvalue;
    }

    public function calculateDailyCalories(float $weight, int $gender): float
    {
        if ($gender === 0) {
            //female calculation
            $dailyCalories = 1 * $weight * 24;
        } else {
            //male calculation
            $dailyCalories = 1.1 * $weight * 24;
        }

        return $dailyCalories;
    }
}
