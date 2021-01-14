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
        $qtyAvailableNotes = rand(3, 300);
        $qtyCorrectlyPlayedNotes = rand(0, $qtyAvailableNotes);
        $qtyIncorrectlyPlayedNotes = rand(0, 5000);

        return [
            'segment_id' => rand(1, SegmentSeeder::QTY),
            'user_id' => rand(1, UserSeeder::QTY),
            'session_uuid' => $this->faker->uuid,
            'tempo_multiplier' => $this->faker->randomFloat(2, 0.01, 1.2),
            'qty_available_notes' => $qtyAvailableNotes,
            'qty_correctly_played_notes' => $qtyCorrectlyPlayedNotes,
            'qty_incorrectly_played_notes' => $qtyIncorrectlyPlayedNotes,
        ];
    }
}
