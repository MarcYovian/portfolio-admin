<?php

namespace Database\Seeders;

use App\Models\Message;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // Menggunakan data Faker versi Indonesia

        for ($i = 0; $i < 15; $i++) {
            Message::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'subject' => $faker->sentence(4), // Membuat subjek dari 4 kata
                'message' => $faker->paragraph(3), // Membuat isi pesan dari 3 paragraf
                'is_read' => $faker->boolean(30), // 30% kemungkinan pesan sudah dibaca
                'created_at' => $faker->dateTimeThisYear(),
            ]);
        }
    }
}
