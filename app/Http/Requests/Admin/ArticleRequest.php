<?php

namespace App\Http\Requests\Admin;
	
	use Illuminate\Foundation\Http\FormRequest;
    
    class ArticleRequest extends FormRequest
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
			return [
				'name'       => 'required',
				'intro_text' => 'required_without:full_text',
				'full_text'  => 'required_without:intro_text',
			];
		}
	}
