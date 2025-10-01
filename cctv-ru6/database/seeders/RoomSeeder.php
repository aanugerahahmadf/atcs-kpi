<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Building;
use App\Models\Room;

class RoomSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$buildings = Building::all();
		foreach ($buildings as $building) {
			for ($i = 1; $i <= 5; $i++) {
				Room::firstOrCreate(
					[
						'building_id' => $building->id,
						'name' => "Room $i",
					],
					[
						'latitude' => $building->latitude,
						'longitude' => $building->longitude,
					]
				);
			}
		}
	}
}
