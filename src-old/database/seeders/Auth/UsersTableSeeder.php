<?php

namespace Database\Seeders\Auth;

use Domain\Auth\Models\Entity\User;
use Domain\Auth\Models\Value\UserId;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Infrastructure\Auth\Repositories\UserRepository;
use Ramsey\Uuid\Uuid;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $password = $faker->password();
        
        $user = new User(
            userId: new UserId(Uuid::uuid4()),
            name: 'Zydhan Linnar Putra',
            email: 'zydhanlinnar11@gmail.com',
            hashedPassword: Hash::make($password),
            username: 'zydhanlinnar11',
            admin: true
        );

        $userRepository = new UserRepository();
        $userRepository->create($user);

        echo 'Admin password: ' . $password . "\n";
    }
}
