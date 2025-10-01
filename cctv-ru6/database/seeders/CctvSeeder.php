<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Building;
use App\Models\Room;
use App\Models\Cctv;

class CctvSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$buildings = Building::all();
		if ($buildings->isEmpty()) {
			return;
		}

		$counter = 1;
		foreach ($buildings as $building) {
			// Create a few rooms per building
			$roomCount = 3;
			$rooms = collect();
			for ($r = 1; $r <= $roomCount; $r++) {
				$rooms->push(
					Room::firstOrCreate(
						[
							'building_id' => $building->id,
							'name' => "Room $r",
						],
						[
							'latitude' => $building->latitude,
							'longitude' => $building->longitude,
						]
					)
				);
			}

			foreach ($rooms as $room) {
				for ($i = 1; $i <= 15 && $counter <= 700; $i++, $counter++) {
					$octet = str_pad((string)$counter, 3, '0', STR_PAD_LEFT);
					$rtsp = "rtsp://admin:password.123@10.56.236.$octet/streaming/channels/";
					Cctv::firstOrCreate(
						[
							'rtsp_url' => $rtsp,
						],
						[
							'building_id' => $building->id,
							'room_id' => $room->id,
							'name' => "CCTV $counter",
							'status' => 'offline',
							'latitude' => $building->latitude,
							'longitude' => $building->longitude,
						]
					);
				}
			}
			if ($counter > 700) {
				break;
			}
		}
	}
}
