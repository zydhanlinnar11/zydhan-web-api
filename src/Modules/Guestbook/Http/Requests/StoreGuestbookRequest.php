<?php

namespace Modules\Guestbook\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGuestbookRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'message' => 'required|string|max:1000',
        ];
    }

    public function getGuestbookContent()
    {
        return $this['message'];
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
