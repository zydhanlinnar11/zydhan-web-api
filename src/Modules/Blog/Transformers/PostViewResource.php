<?php

namespace Modules\Blog\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Blog\Domain\Models\Entity\Post;

class PostViewResource extends JsonResource
{
    public function __construct(
        private Post $post
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
            'slug' => $this->post->getSlug(),
            'title' => $this->post->getTitle(),
            'description' => $this->post->getDescription(),
            'markdown' => $this->post->getMarkdown(),
            'createdAt' => $this->post->getCreatedAt()
        ];
    }
}
