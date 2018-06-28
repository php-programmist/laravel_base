<?php
	
	namespace App\Http\Controllers;
	
	class AdminController extends Controller{
		protected $user;
		protected $template;
		protected $title;
		protected $vars;
		
		/**
		 * Create a new controller instance.
		 *
		 * @return void
		 */
		public function __construct(){
			/*$this->middleware('auth');
			$this->user = \Auth::user();
			//dd(\Auth::user());
			if(!$this->user) {
				abort(403,__('system.Restricted access'));
			}*/
		}
		
		public function renderOutput(){
			$this->vars = array_add($this->vars, 'title', $this->title);
			
			$menu = $this->getMenu();
			
			$this->vars['navigation'] = view('admin.navigation')->with('menu', $menu)->render();
			
			return view($this->template)->with($this->vars);
			
		}
		
		public function getMenu(){
			return \Menu::make('adminMenu', function($menu){
				$users = $menu->add('Пользователи', array( 'route' => 'admin.users.index' ));
				$users->add('Группы', array( 'route' => 'admin.groups.index' ));
				$users->add('Привилегии', array( 'route' => 'admin.groups.index' ));
				
				//if(Gate::allows('VIEW_ADMIN_ARTICLES')) {
				$articles = $menu->add('Статьи', array( 'route' => 'admin.articles.index' ));
				$articles->add('Категории', array( 'route' => 'admin.categories.index' ));
				$articles->add('Комментарии', array( 'route' => 'admin.comments.index' ));
				
				//}
				
				$menu->add('Меню', array( 'route' => 'admin.menus.index' ));
				
			});
		}
	}
