<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
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
            "name"=>"bail|required|unique:items,name".($this->is("item/update/*") ? ",".$this->route("item")->id:""),
            "photo"=>"image",
            "category"=>"bail|required|exists:categories,id",
            "price"=>"numeric",
            "tax"=>"numeric"
        ];
    }

    public function nessages()
    {
        return [
            "name"=>[
                "required"=>"Product Name is Required",
                "unique"=>"Product Name Should Be Unique",
            ],
            "category"=>[
                "required"=>"Category Is Required",
                "exists"=>"Category Should Exists",
            ],
            "price"=>[
                "numeric"=>"Price Should Be Numeric",
            ],
            "tax"=>[
                "numeric"=>"Tax Should Be Numeric",
            ]
        ];
    }
}
