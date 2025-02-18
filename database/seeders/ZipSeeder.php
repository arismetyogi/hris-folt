<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ZipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = database_path('data\zips.json');

        // Check if the JSON file exists
        if (File::exists($jsonPath)) {
            // Read the file
            $jsonData = File::get($jsonPath);
            $zips = json_decode($jsonData, true);
            
            if (!is_array($zips)) {
                dump("JSON decode failed!", json_last_error_msg());
            }

            if (is_array($zips)) {
                // Split the data into smaller chunks
                $chunks = array_chunk($zips, 500); // Adjust chunk size as needed

                foreach ($chunks as $chunk) {
                    try {
                        DB::table('zips')->insert($chunk);
                    } catch (\Exception $e) {
                        dump($e->getMessage());
                    }
                    dump("Inserted " . count($chunk) . " records.");
                }
            }
        } else {
            $this->command->error("JSON file not found at {$jsonPath}");
        }
    }
}
