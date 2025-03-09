<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            "categorygroup"=>"required|exists:category_group,id",
            "category"=>$this->getCategoryRule(),
            "status"=>"required|in:active,inactive"
        ];
    }

    public function messages()
    {
        return [
            "categorygroup.required"=>":attribute Is Required",
            "category.required"=>"Category is Required",
            "status"=>[
                "required"=>"Status Is Required",
                "in"=>"Status is :in"
            ],
        ];
    }

    private function getCategoryRule()
    {
        
        if(request()->route()->getName() == "category.update")
        {
           
            return ["required",Rule::unique("categories","name")->where(function($query)
            {
                $query->where("category_group_id",request("categorygroup"));
            })->ignore(request()->route("category")->id)];
        }
        else
        {
            return ["required",Rule::unique("categories","name")->where(function($query)
            {
                $query->where("category_group_id",request("categorygroup"));
            })];
        }
    }
}
