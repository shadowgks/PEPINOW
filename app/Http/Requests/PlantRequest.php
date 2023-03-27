<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlantRequest extends FormRequest
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
            'name' => 'required',
            'picture' => 'image',
            'price' => 'required',
            'description' => 'required',
            'user_id' => 'exists:App\Models\User,id',
        ];
    }


    // public function messages()
    // {
    //     return [
    //         'name.required' => 'you should provide name for plant',
    //         'picture.required' => 'you should provide picture for plant',
    //         'price.required' => 'you should provide price for plant'
    //     ];
    // }
}
