<?php

namespace App\Http\Requests\Admin;
	
	use Illuminate\Foundation\Http\FormRequest;
    
    class UserRequest extends FormRequest
    {
		/**
		 * Determine if the user is authorized to make this request.
		 *
		 * @return bool
		 */
		public function authorize() {
			return true;
		}
		
		/**
		 * Get the validation rules that apply to the request.
		 *
		 * @return array
		 */
		public function rules() {
			$route_name = $this->route()->getName();
			$rules      = [
				'name'             => 'required',
				'password_confirm' => 'required_with:password|same:password',
			
			];
			
			if ( strstr($route_name, 'store') ) {
				$rules['password'] = 'required|min:6';
				$rules['username'] = 'required|alpha_num|unique:users|min:5';
				$rules['email']    = 'required|email|unique:users';
			}
			
			if ( strstr($route_name, 'update') ) {
				
				$rules['username'] = 'required|alpha_num|unique:users,username,' . $this->user . '|min:5';
				$rules['email']    = 'required|email|unique:users,email,' . $this->user;
				/*$rules['email']    = [
					'required',
					'email',
					Rule::unique('users')->ignore($this->user),
				];*/
				if ( $this->filled('password') ) {
					$rules['password'] = 'min:6';
				}
			}
			
			return $rules;
		}
	}
