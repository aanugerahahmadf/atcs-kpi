<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Building;

class BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $buildings = [
            'Gedung Kolaboratif',
            'Gerbang Utama',
            'AWI',
            'Shelter Maintenance Area 1',
            'Shelter Maintenance Area 2',
            'Shelter Maintenance Area 3',
            'Shelter Maintenance Area 4',
            'Shelter White OM',
            'Pintu Masuk Area Kilang',
            'Marine Region III',
            'Main Control Room',
            'Tank Farm Area 1',
            'Gedung EXOR',
            'Produksi CDU',
            'HSSE Demo Room',
            'Gedung Amanah',
            'POC',
            'JGC',
        ];

        // Approximate center of RU VI Balongan
        $baseLat = -6.3895; $baseLng = 108.4040;

        foreach ($buildings as $index => $name) {
            Building::firstOrCreate(
                ['name' => $name],
                [
                    'latitude' => $baseLat + ($index * 0.0005),
                    'longitude' => $baseLng + ($index * 0.0005),
                    'icon_path' => null,
                    'address' => 'RU VI Balongan, Indramayu',
                ]
            );
        }
    }
}
