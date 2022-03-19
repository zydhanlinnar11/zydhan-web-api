<?php

namespace Modules\Blog\Transformers\HomePosts;

use Illuminate\Http\Resources\Json\JsonResource;

class HomePostResource extends JsonResource
{
    public function __construct(
        private string $title,
        private string $coverUrl,
        private string $slug,
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
            'title' => $this->title,
            'cover_url' => $this->coverUrl,
            'slug' => $this->slug,
            'created_at' => $this->created_at,
            // 'created_at' => $post->getCreatedAt()->setTimezone(new DateTimeZone('Asia/Jakarta'))->format('l, F d, Y'),
        ];
    }
}
