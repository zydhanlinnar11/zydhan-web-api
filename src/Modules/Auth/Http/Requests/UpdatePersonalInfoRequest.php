<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePersonalInfoRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        /** @var \App\Models\User $user */
        $user = $this->user();

        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->getId()),
                'max:255'
            ],
        ];
    }

    public function getName()
    {
        return $this['name'];
    }

    public function getEmail()
    {
        return $this['email'];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
