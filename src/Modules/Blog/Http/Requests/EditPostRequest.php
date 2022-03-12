<?php

namespace Modules\Blog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Auth\Facade\Auth;
use Modules\Blog\Domain\Models\Value\PostVisibility;

class EditPostRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:64',
            'description' => 'required|string|max:255',
            'markdown' => 'required|string|max:65535',
            'visibility' => 'required|numeric|min:1|max:3',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user($this)->isAdmin();
    }

    public function title(): string
    {
        return $this->validated()['title'];
    }

    public function description(): string
    {
        return $this->validated()['description'];
    }

    public function markdown(): string
    {
        return $this->validated()['markdown'];
    }

    public function visibility(): PostVisibility
    {
        return PostVisibility::from($this->validated()['visibility']);
    }
}
