<?php

namespace App\Http\Controllers\Admin;

class IndexController extends AdminController
{
		public function index(){
			
			if( !\Auth::user()->canDo('VIEW_ADMIN') ){
				return redirect('/');
			}
			$this->title    = __('system.Dashboard');
			$this->template = 'admin.index';
			
			return $this->renderOutput();
			
		}
	}
