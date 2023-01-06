<?php

namespace Database\Factories;

use App\Models\Guestbook;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Guestbook>
 */
class GuestbookFactory extends Factory
{
    public static function createNewGuestbook(
        int $userId,
        string $content,
    ): \App\Models\Guestbook
    {
        return Guestbook::create([
            'user_id' => $userId,
            'content' => $content,
        ]);
    }
        
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
        ];
    }
}
