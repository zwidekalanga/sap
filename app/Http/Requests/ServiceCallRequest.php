<?php namespace App\Http\Requests;

class ServiceCallRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch($this->method())
        {
            case 'POST': {
                return [
                    'CustomerCode' => 'required',
                    'ItemCode' => '',
                    'InternalSerialNum' => '',
                    'Subject' => 'required'
                ]; 
            }
            case 'PUT': {
                return [];
            }    
        }
    }
}