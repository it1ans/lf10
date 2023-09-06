<?php

namespace App\Service;

interface WeightCalculationServiceInterface
{
    public function defineBodyType(string $bodyType): float;

    public function calculateIdealWeight(float $height, int $age, float $bodyType): float;

    public function decreaseCalories(int $calories, int $alreadyEaten): int;

    public function calculateDailyCalories(float $weight, int $gender): float;
}
