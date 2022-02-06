<?php

/**
 * @file   ChangePasswordValidations.php
 * @brief  This file is responsible for handling web services related to Admin Settings Validations.
 * @date   May, 2019
 * @author ZCO Engineer
 * @copyright (c) 2019, ZCO
 */

namespace App\Http\Validations;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordValidations extends FormRequest
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
            'newPassword' => 'required',
            'confirmPassword' => 'required|same:newPassword',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'newPassword.required' => trans('admin.newPassword_required'),
            'confirmPassword.required' => trans('admin.confirmPassword_required'),
            'confirmPassword.same' => trans('admin.password_same_confirmed'),
        ];
    }
}