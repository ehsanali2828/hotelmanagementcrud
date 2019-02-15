<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HotelRequest extends FormRequest
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
            'name'     => 'Required',
            'address1' => 'Required',
            'city'     => 'Required',
            'state'    => 'Required',
            'zip'      => 'Required|numeric',
            'country'  => 'Required',
            'amenities'=> 'Required',
			'images.*' => 'sometimes|mimes:jpeg,png,jpg,gif'
        ];
	}

	public function messages()
	{
		return [
			'images.*.mimes' => 'Only jpeg,png and gif images are allowed.'
		];
	}
}
