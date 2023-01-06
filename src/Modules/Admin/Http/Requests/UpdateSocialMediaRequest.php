<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateSocialMediaRequest extends SocialMediaRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        /** @var \App\Models\SocialMedia $socialMedia */
        $socialMedia = $this->social_medium;
        return array_merge(parent::rules(), [
            'id' => [
                'string',
                Rule::unique('social_media')->ignore($socialMedia->getId()),
            ],
        ]);
    }
}
