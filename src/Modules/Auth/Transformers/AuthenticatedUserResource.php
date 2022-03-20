<?php

namespace Modules\Auth\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Auth\Domain\Models\Entity\User;

class AuthenticatedUserResource extends JsonResource
{
    public function __construct(private User $user) { }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'email' => $this->user->getEmail(),
            'name' => $this->user->getName(),
            'linkedAccount' => [
                'google' => $this->user->getGoogleId() ? true : false,
                'github' => $this->user->getGithubId() ? true : false,
            ],
            'admin' => $this->user->isAdmin(),
            'avatar_url' => $this->user->getAvatar()
        ];
    }
}
