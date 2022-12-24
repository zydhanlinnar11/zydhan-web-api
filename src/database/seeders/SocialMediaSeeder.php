<?php

namespace Database\Seeders;

use App\Models\SocialMedia;
use Illuminate\Database\Seeder;

class SocialMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SocialMedia::create([
            'id' => 'github',
            'name' => 'Github',
            'socialite_name' => 'github',
            'client_id' => 'temp',
            'client_secret' => 'temp',
        ]);
    }
}
