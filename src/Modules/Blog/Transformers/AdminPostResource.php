<?php

namespace Modules\Blog\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Blog\Domain\Models\Entity\Post;

class AdminPostResource extends JsonResource
{
    public function __construct(
        private Post $post,
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
            'title' => $this->post->getTitle(),
            'description' => $this->post->getDescription(),
            'visibility' => $this->post->getVisibility(),
            'markdown' => $this->post->getMarkdown(),
        ];
    }
}
