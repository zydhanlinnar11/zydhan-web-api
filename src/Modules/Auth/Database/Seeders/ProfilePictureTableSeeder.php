<?php

namespace Modules\Auth\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class ProfilePictureTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $users = DB::table('users')->select(['id'])->whereNull('avatar_url')->get();

        foreach($users as $user)
        {
            $data = ['avatar_url' => 'https://avatars.dicebear.com/api/human/' . Uuid::uuid4() . '.svg'];
            DB::table('users')->where('id', '=', $user->id)->update($data);
        }
    }
}
