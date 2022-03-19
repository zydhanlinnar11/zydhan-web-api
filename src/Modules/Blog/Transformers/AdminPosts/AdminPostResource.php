<?php

namespace Modules\Blog\Transformers\AdminPosts;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminPostResource extends JsonResource
{
    public function __construct(
        private string $id,
        private string $title,
        private string $coverUrl,
        private string $created_at,
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
            'title' => $this->title,
            'cover_url' => $this->coverUrl,
            'created_at' => $this->created_at,
        ];
    }
}
