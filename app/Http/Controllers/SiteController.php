<?php
	
	namespace App\Http\Controllers;
	
	use Illuminate\Http\Request;
	
	
	class SiteController extends Controller {
		protected $template;
		protected $vars = array();
		
		public function __construct() {
		
		}
		
		
		protected function renderOutput() {
			
			$navigation = \Cache::remember('menus', config('settings.cache_menus', 0), function () {
				$menu = $this->getMenu();
				try {
					return view('site.layouts.navigation')->with([ 'menu' => $menu ])->render();
				}
				catch (\Throwable $e) {
					\Session::flash('message', $e->getMessage());
					
					return false;
				}
			});
			
			
			$this->vars = array_add($this->vars, 'navigation', $navigation);
			
			return view($this->template)->with($this->vars);
		}
		
		protected function getMenu() {
			
			$menu     = \App\Menu::all();
			$mBuilder = \Menu::make('main_menu', function ($m) use ($menu) {
				
				foreach ($menu as $item) {
					
					$item->path = ltrim($item->path, '\/');
					
					if ( $item->parent_id == 0 ) {
						$m->add($item->title, $item->path)->id($item->id);
					}
					else {
						if ( $m->find($item->parent_id) ) {
							$m->find($item->parent_id)->add($item->title, $item->path)->id($item->id);
						}
					}
				}
				
			});
			
			return $mBuilder;
		}
	}
