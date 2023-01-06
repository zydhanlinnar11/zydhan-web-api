<?php

namespace Database\Factories;

use App\Models\SocialMedia;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SocialMedia>
 */
class SocialMediaFactory extends Factory
{
    /**
     * Create and store model to database.
     */
    public static function createNewSocialMedia(
        string $id,
        string $name,
        string $socialiteName,
        string $clientId,
        string $clientSecret,
    ): \App\Models\SocialMedia
    {
        $socialMedia = new SocialMedia();
        $socialMedia->setId($id);
        $socialMedia->setName($name);
        $socialMedia->setSocialiteName($socialiteName);
        $socialMedia->setClientId($clientId);
        $socialMedia->setClientSecret($clientSecret);
        $socialMedia->save();
        
        return $socialMedia;
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
