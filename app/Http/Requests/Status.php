<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class Status extends Request
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
            'message' => 'required',
            'link' => 'active_url',
            'image' => 'max:2000',
            'post_in' => 'required|date_format:Y-m-d H:i:s',
            'delete_in' => 'required|date_format:Y-m-d H:i:s',
        ];
    }
}
