<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    
    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'socialite_name',
        'client_id',
        'client_secret',
    ];

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id)
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }
    
    public function getSocialiteName(): string
    {
        return $this->socialite_name;
    }

    public function setSocialiteName(string $socialite_name)
    {
        $this->socialite_name = $socialite_name;
    }

    public function getClientId(): string
    {
        return $this->client_id;
    }

    public function setClientId(string $client_id)
    {
        $this->client_id = $client_id;
    }

    public function getClientSecret(): string
    {
        return $this->client_secret;
    }

    public function setClientSecret(string $client_secret)
    {
        $this->client_secret = $client_secret;
    }

    /**
     * The users that belong to the social media.
     */
    public function users()
    {
        return $this->belongsToMany(User::class)
                ->withPivot('identifier')
                ->withTimestamps();
    }

    public function linkUser(int $userId, string|int $socialAccountIdentifier)
    {
        $this->users()
                ->attach(
                    id: $userId,
                    attributes: ['identifier' => strval($socialAccountIdentifier)]
                );
    }

    public function unlinkUser(int $userId)
    {
        $this->users()->detach($userId);
    }
}
