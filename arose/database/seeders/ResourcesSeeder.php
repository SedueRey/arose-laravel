<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Resources;

class ResourcesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fileurls = fopen('./_tmp/resources.csv', 'r');
        while (($row = fgetcsv($fileurls, 0, ',')) != FALSE) {
            Resources::create([
                'filename' => $row[0],
                'filepath' => '#',
                'country' => $row[1],
                'level' => $row[2],
                'format' => $row[3],
                'type' => $row[4],
                'creation' => $row[5],
                'desc' => $row[6],
                'uploaded_by' => 1
            ]);
        }
    }
}
