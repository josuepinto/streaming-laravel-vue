<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieRequest extends FormRequest
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
            'title' => 'required',
            'description' => 'required',
            'year' => 'required|numeric',
            'genre' => 'required',
            'video_url' => 'required',
        ];
    }

    public function messages() {
        return [
            'title.required' => 'The title is manadatory',
            'description.required' => 'The desc is manadatory',
            'year.numeric' => 'The year is numeric',
            'genre.required' => 'The genre is manadatory',
            'video_url' => 'The link is manadatory',
        ];
    }
}
