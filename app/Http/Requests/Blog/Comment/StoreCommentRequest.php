<?php

namespace App\Http\Requests\Blog\Comment;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "publisher_name" => ["required", "string", "min:3", "max:255"],
            "publisher_email" => ["required", "email", "min:3", "max:255"],
            "body" => ["required", "string", "min:3"],
        ];
    }
}
