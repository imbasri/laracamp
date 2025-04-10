<?php

namespace App\Http\Requests\Admin\Discount;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class Store extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /* The line `return Auth::check() && Auth::user()->is_admin;` in the `authorize` method of the
        `Store` class is checking if the current user is authenticated and if the authenticated user
        is an admin. */
        return Auth::check() && Auth::user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:5|unique:discounts,code',
            'description' => 'nullable|string|max:255',
            'percentage' => 'required|numeric|min:1|max:100',
        ];
    }
}
