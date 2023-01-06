<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class SocialMediaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /** @var \App\Models\User $user */
        $user = $this->user();
        return $user->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'string',
            'socialite_name' => 'string',
            'client_id' => 'string',
            'client_secret' => 'string',
        ];
    }

    public function getId(): string
    {
        return $this['id'];
    }

    public function getName(): string
    {
        return $this['name'];
    }
    
    public function getSocialiteName(): string
    {
        return $this['socialite_name'];
    }

    public function getClientId(): string
    {
        return $this['client_id'];
    }

    public function getClientSecret(): string
    {
        return $this['client_secret'];
    }
}
