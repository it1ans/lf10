<?php

namespace App\Service;

use App\Enum\BodyType;
use App\Enum\Gender;

interface WeightCalculationServiceInterface
{
    public function calculateIdealWeight(int $height, int $age, BodyType $bodyType): float;

    public function decreaseCalories(int $calories, int $alreadyEaten): int;

    public function calculateDailyCalories(float $weight, Gender $gender): float;
}
