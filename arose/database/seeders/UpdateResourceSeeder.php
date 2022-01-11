<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Resources;
use \DB;

class UpdateResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fileurls = fopen('./_tmp/resources_dropbox_file.csv', 'r');
        while (($row = fgetcsv($fileurls, 0, ';')) != FALSE) {
            if (
                trim($row[0]) !== '' &&
                trim($row[2]) !== '' &&
                trim($row[9]) !== ''
                ) {
                    $filepath = '/storage/resources/arose/'.$row[2].'/'.$row[9];
                    $miau = DB::table('resources')
                        ->where('filename', $row[0])
                        ->where('format', $row[4])
                        ->where('uploaded_by', 1)
                        ->where('country', $row[2])
                        ->get();

                    if (count($miau) === 1) {

                        $miau = DB::table('resources')
                            ->where('filename', $row[0])
                            ->where('format', $row[4])
                            ->where('uploaded_by', 1)
                            ->where('country', $row[2])
                            ->update(['filepath' => $filepath]);

                    } else if( count($miau) === 0) {
                        Resources::create([
                            'filename' => $row[0],
                            'filepath' => $filepath,
                            'country' => $row[2],
                            'level' => $row[3],
                            'format' => $row[4],
                            'type' => $row[5],
                            'creation' => $row[6],
                            'desc' => $row[7],
                            'uploaded_by' => 1
                        ]);
                    } else {
                        $this->command->info($row[0].' -> '.count($miau));
                        $this->command->info(implode('|', $row));
                    }
            }
        }
    }
}
