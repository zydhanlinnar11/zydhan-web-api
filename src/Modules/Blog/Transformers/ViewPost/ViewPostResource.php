<?php

namespace Modules\Blog\Transformers\ViewPost;

use Illuminate\Http\Resources\Json\JsonResource;

class ViewPostResource extends JsonResource
{
    public function __construct(
        private string $slug,
        private string $title,
        private string $description,
        private string $markdown,
        private string $createdAt,
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
            'slug' => $this->slug,
            'title' => $this->title,
            'description' => $this->description,
            'markdown' => $this->markdown,
            'createdAt' => $this->createdAt
        ];
    }
}
