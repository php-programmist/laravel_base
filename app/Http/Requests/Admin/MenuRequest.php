<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
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
        return [
            'title'    => 'required|max:255',
            'element'  => 'required',
            'article'  => 'required_if:element,article',
            'category' => 'required_if:element,category',
            'path'     => 'required_if:element,custom|max:255',
        ];
    }
}
