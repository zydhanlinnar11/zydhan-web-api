<?php

namespace Modules\Blog\Transformers;

use DateTimeZone;
use Illuminate\Http\Resources\Json\JsonResource;

class PortfolioPostResource extends JsonResource
{
    /**
     * Constructor.
     *
     * @param  \Modules\Blog\Domain\Models\Entity\Post[] $posts
     */
    public function __construct(
        private $posts
    ) { }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $arr = array();

        foreach ($this->posts as $post) {
            array_push($arr, [
                'title' => $post->getTitle(),
                'description' => $post->getDescription(),
                'slug' => $post->getSlug(),
                'created_at' => $post->getCreatedAt()->setTimezone(new DateTimeZone('Asia/Jakarta'))->format('d/m/Y'),
            ]);
        }

        return $arr;
    }
}
