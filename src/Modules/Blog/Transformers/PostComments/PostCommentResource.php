<?php

namespace Modules\Blog\Transformers\PostComments;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class PostCommentResource extends JsonResource
{
    public function __construct(
        private string $id,
        private string $comment,
        private string $createdAt,
        private string $user_name,
        private string $user_id,
        private ?string $user_avatar_url,
    ) { }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'comment' => $this->comment,
            'createdAt' => $this->createdAt,
            'user_name' => $this->user_name,
            'is_own_comment' => Auth::guard('sanctum')->id() === $this->user_id,
            'user_avatar_url' => $this->user_avatar_url
        ];
    }
}
