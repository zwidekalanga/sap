<?php namespace App\Http\Requests;

class AuthLogoutRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'SessionId' => 'required'
        ];
    }
}