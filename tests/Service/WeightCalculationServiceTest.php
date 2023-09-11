<?php

namespace App\Tests\Service;

use App\Enum\BodyTypeEnum;
use App\Enum\GenderEnum;
use App\Service\WeightCalculationService;
use PHPUnit\Framework\TestCase;

class WeightCalculationServiceTest extends TestCase
{
    public static function idealWeightProvider(): array
    {
        return [
            [
                'height' => 200,
                'age' => 20,
                'bodyType' => BodyTypeEnum::NORMAL,
                'expected' => 91.8,
            ],
            [
                'height' => 180,
                'age' => 50,
                'bodyType' => BodyTypeEnum::STRONG,
                'expected' => 84.15,
            ],
            [
                'height' => 160,
                'age' => 86,
                'bodyType' => BodyTypeEnum::DAINTILY,
                'expected' => 55.566,
            ],
        ];
    }

    /**
     * @dataProvider idealWeightProvider
     */
    public function testCalculateIdealWeight(int $height, int $age, BodyTypeEnum $bodyType, float $expected): void
    {
        $weightCalculationService = new WeightCalculationService();

        $this->assertSame($expected, $weightCalculationService->calculateIdealWeight($height, $age, $bodyType));
    }

    public function testDecreaseCalories(): void
    {
        $weightCalculationService = new WeightCalculationService();
        self::assertSame(200, $weightCalculationService->decreaseCalories(300, 100));
    }

    public function testCalculateDailyCalories(): void
    {
        $weightCalculationService = new WeightCalculationService();
        $dailyCalories = $weightCalculationService->calculateDailyCalories(85.5, GenderEnum::FEMALE);
        self::assertSame(2052.0, $dailyCalories);
        $dailyCalories = $weightCalculationService->calculateDailyCalories(120, GenderEnum::MALE);
        self::assertSame(3168.0, $dailyCalories);
    }
}
