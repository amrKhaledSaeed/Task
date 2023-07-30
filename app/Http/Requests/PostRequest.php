<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        if(in_array($this->method(),['PUT','PATCH']))
        {
            return [
                'title' => 'nullable|max:255',
                'body' => 'nullable',
                'file' => 'nullable|image',
                'pinned' => 'nullable|boolean',
                'tag_ids' => 'nullable|sometimes|array',
                'tag_ids.*' => 'nullable|exists:tags,id',
            ];
        }else{
            return [
                'title' => 'required|max:255',
                'body' => 'required',
                'file' => 'required|image',
                'pinned' => 'required|boolean',
                'tag_ids' => 'sometimes|array',
                'tag_ids.*' => 'exists:tags,id',
            ];
        }

    }
}
