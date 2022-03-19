<?php

namespace Modules\Blog\Transformers\AdminEditPost;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminEditPostResource extends JsonResource
{
    public function __construct(
        private string $title,
        private string $description,
        private int $visibility,
        private string $markdown,
        private string $slug,
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
            'description' => $this->description,
            'visibility' => $this->visibility,
            'markdown' => $this->markdown,
            'slug' => $this->slug,
        ];
    }
}
