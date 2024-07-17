<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ZohoAccess;

class ZohoAccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = ZohoAccess::create([
            'auth_code' => '1000.094aaed517d27eb7413039c014bdc7fd.81dcc5a11bf5035208a767c598fc8c61',
            'access_token' => '1000.1d4485e688d8a36a280d17c6c1cd1a6a.5b01ab3303971cd09bb73c5768027515',
            'refresh_token' => '1000.043fc88ed63f78aa92ae9bfbcdbd87e3.46c9d4702be817a96fd8cec6345b76c9',
            'expires_at' => '2024-04-29 00:00:00.000',
            'created_at' => '2024-04-29 00:00:00.000',
            'updated_at' => '2024-04-29 00:00:00.000',
        ]);
        $admin->save();
    }
}
