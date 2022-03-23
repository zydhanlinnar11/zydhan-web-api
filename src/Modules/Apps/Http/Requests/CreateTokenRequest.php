<?php

namespace Modules\Apps\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTokenRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'app_id' => 'required|string',
            'redirect_uri' => 'required|string'
        ];
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

    public function appId(): string
    {
        return $this->app_id;
    }

    public function redirectURI(): string
    {
        return $this->redirect_uri;
    }
}
