<?php

namespace App\Service;

use App\Enum\BodyTypeEnum;
use App\Enum\GenderEnum;

interface WeightCalculationServiceInterface
{
    public function calculateIdealWeight(int $height, int $age, BodyTypeEnum $bodyType): float;

    public function decreaseCalories(int $calories, int $alreadyEaten): int;

    public function calculateDailyCalories(float $weight, GenderEnum $gender): float;
}
