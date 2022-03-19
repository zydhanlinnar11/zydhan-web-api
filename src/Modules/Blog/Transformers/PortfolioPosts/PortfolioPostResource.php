<?php

namespace Modules\Blog\Transformers\PortfolioPosts;

use Illuminate\Http\Resources\Json\JsonResource;

class PortfolioPostResource extends JsonResource
{
    public function __construct(
        private string $title,
        private string $description,
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
            'description' => $this->description,
            'slug' => $this->slug,
            'created_at' => $this->created_at,
        ];
    }
}
