<?php
	
	namespace App\Http\Controllers;
	
	use App\Mail\ContactsMail;
	use Illuminate\Http\Request;
	
	class ContactController extends SiteController{
		public function index(){
			$this->template      = 'site.contacts';
			$this->vars['title'] = __('system.contacts');
			
			return $this->renderOutput();
		}
		
		public function post(Request $request){
			/*$messages = [
				'required' => 'Поле :attribute Обязательно к заполнению',
				'email'    => 'Поле :attribute должно содержать правильный email адрес',
			];*/
			$this->validate($request, [
				'name'  => 'required|max:255',
				'email' => 'required|email',
				'text'  => 'required',
			]/*,$messages*/);
			
			$data = $request->all();
			
			\Mail::to(config('settings.admin_email'))
			     ->send(new ContactsMail($data));
			
			return redirect()->route('contacts')->with('message', __('system.email_sended'));
			
		}
	}
