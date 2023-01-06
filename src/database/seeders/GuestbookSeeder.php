<?php

namespace Database\Seeders;

use Database\Factories\GuestbookFactory;
use Illuminate\Database\Seeder;

class GuestbookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GuestbookFactory::createNewGuestbook(
            userId: 1,
            content: 'Feel free to leave a comment on this website. I would love to hear your views on my website! 😁'
        );
    }
}
