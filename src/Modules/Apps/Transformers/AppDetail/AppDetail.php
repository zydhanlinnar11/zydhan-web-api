<?php

namespace Modules\Apps\Transformers\AppDetail;

use Illuminate\Http\Resources\Json\JsonResource;

class AppDetail extends JsonResource
{
    public function __construct(
        private string $id,
        private string $name,
        private string $redirectURI,
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
            'name' => $this->name,
            'redirectURI' => $this->redirectURI,
        ];
    }
}
