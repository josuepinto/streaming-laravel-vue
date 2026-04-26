<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255|unique:movies,title',
            'description' => 'required|string',
            'actor' => 'required|string|max:255',
            'director' => 'required|string|max:255',
            'year' => 'required|integer|digits:4',
            'genre' => 'required|string|max:255',
            'video_url' => 'required|url',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }


    public function messages()
    {
        return [
            'title.required' => 'The title is mandatory.',
            'title.unique' => 'A movie with this title already exists.',
            'description.required' => 'The description is mandatory.',
            'actor.required' => 'The actor field is mandatory.',
            'director.required' => 'The director field is mandatory.',
            'year.required' => 'The year is mandatory.',
            'year.integer' => 'The year must be an integer.',
            'year.digits' => 'The year must have 4 digits.',
            'genre.required' => 'The genre is mandatory.',
            'video_url.required' => 'The video URL is mandatory.',
            'video_url.url' => 'The video URL must be valid.',
            'image.required' => 'The image is mandatory.',
            'image.image' => 'The file must be an image.',
        ];
    }

}
