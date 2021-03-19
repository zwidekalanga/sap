<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2019/03/19
 * Time: 06:22
 */

namespace App\Http\Requests;

class AuthLoginRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'CompanyUsername' => 'required',
            'CompanyPassword' => 'required',
            'DatabaseName' => 'required',
        ];
    }
}