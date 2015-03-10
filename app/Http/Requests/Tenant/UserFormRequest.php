<?php 
namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest {

	public function rules()
    {
        return [
            //'company' => 'required|min:4|max:55|unique:tenants|alpha_dash',
            'company' => 'required|min:4|max:55|unique:tenants',
            'email' => 'required|email|max:50|unique:tenants'
        ];
    }

    public function authorize()
    {
        // Only allow logged in users
        // return \Auth::check();
        // Allows all users in
        return true;
    }
}
