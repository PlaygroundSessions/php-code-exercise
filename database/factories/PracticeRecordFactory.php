<?php

namespace Database\Factories;

use App\Models\PracticeRecord;
use Database\Seeders\SegmentSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;

class PracticeRecordFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PracticeRecord::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'segment_id' => rand(1, SegmentSeeder::QTY),
            'user_id' => rand(1, UserSeeder::QTY),
            'session_uuid' => $this->faker->uuid,
            'tempo_multiplier' => $this->faker->randomFloat(2, 0.01, 1.2),
            'score' => self::getScore(),
        ];
    }

    /**
     * Get a score between 0 and 100.
     * There is about a 33% probability that a practice record will have any of the following
     * - A perfect score
     * - A passing score
     * - A failing score
     */
    private static function getScore(): int
    {
        /** Polymorphism would be overkill right now */
        return match(rand(0, 2)) {
            0 => self::getFailingScore(),
            1 => self::getPassingScore(),
            2 => self::getPerfectScore(),
        };
    }

    private static function getPassingScore(): int
    {
        return rand(80, 100);
    }

    private static function getFailingScore(): int
    {
        return rand(0, 79);
    }

    private static function getPerfectScore(): int
    {
        return 100;
    }
}
