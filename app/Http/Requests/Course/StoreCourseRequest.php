<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Course Fields
            'title'                 => ['required', 'string', 'max:255'],
            'description'           => ['required', 'string'],
            'category'              => ['required', 'string', 'max:255'],
            'feature_video'         => ['required', 'file', 'max:51200','mimes:mp4,avi,mpeg,mov'],
            'price'                 => ['required', 'numeric', 'min:0'],

            // SEO Fields
            'meta_title'            => ['nullable', 'string', 'max:255'],
            'meta_description'      => ['nullable', 'string'],
            'meta_keywords'         => ['nullable', 'string'],
            'meta_image'            => ['nullable', 'image', 'max:2048'],
            'google_schema'         => ['nullable', 'json'],

            // Nested Modules
            'modules'               => ['required', 'array', 'min:1'],
            'modules.*.title'       => ['required', 'string', 'max:255'],
            'modules.*.description' => ['required', 'string'],
            'modules.*.duration'    => ['nullable', 'string', 'max:50'],

            // Nested Contents
            'modules.*.contents'             => ['required', 'array', 'min:1'],
            'modules.*.contents.*.title'     => ['required', 'string', 'max:255'],
            'modules.*.contents.*.type'      => ['required', 'string'],
            'modules.*.contents.*.video_url' => ['nullable', 'string', 'max:255'],
            'modules.*.contents.*.duration'  => ['nullable', 'string', 'max:50'],
        ];
    }

    public function messages(): array
    {
        return [
            'modules.required'              => 'You must add at least one module.',
            'modules.*.contents.required'   => 'Each module must contain at least one content item.',
            'feature_video.mimetypes'       => 'The feature video must be a valid video file (MP4, AVI, MPEG, MOV).',
        ];
    }
}
