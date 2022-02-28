<?php

namespace Modules\Blog\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class HomePagePostsResource extends JsonResource
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
                'cover_url' => "https://storage.googleapis.com/zydhan-web.appspot.com/gambar-biner.webp",
                'slug' => $post->getSlug(),
                'created_at' => $post->getCreatedAt(),
            ]);
        }

        return $arr;
    }
}